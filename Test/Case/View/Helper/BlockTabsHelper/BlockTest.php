<?php
/**
 * BlockTabsHelper::block()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * BlockTabsHelper::block()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockTabsHelper
 */
class BlockTabsHelperBlockTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'blocks';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Blocks', 'TestBlocks');
	}

/**
 * viewVarsにセットするデータ取得
 *
 * @return array
 */
	private function __getViewVars() {
		//テストデータ生成
		$viewVars = array(
			'blockSettingTabs' => array(
				'block_settings' => array(
					'url' => array(
						'plugin' => 'test_plugin',
						'controller' => 'test_ctrl',
						'action' => 'test',
						'frame_id' => '6',
						'block_id' => null
					),
					'label' => array(0 => 'blocks', 1 => 'Block settings')
				),
				'mail_settings' => array(
					'url' => array(
						'plugin' => 'test_blocks',
						'controller' => 'test_block_mail_settings',
						'action' => 'edit',
						'frame_id' => '6',
						'block_id' => null
					),
					'label' => array(0 => 'mails', 1 => 'Mail settings'),
				),
				'role_permissions' => array(
					'url' => array(
						'plugin' => 'test_blocks',
						'controller' => 'test_block_block_role_permissions',
						'action' => 'edit',
						'frame_id' => '6',
						'block_id' => null
					),
					'label' => array(0 => 'net_commons', 1 => 'Role permission settings'),
					'permission' => 'block_permission_editable'
				),
				'original' => array(
					'url' => array(
						'plugin' => 'original_plugin',
						'controller' => 'original_ctrl',
						'action' => 'edit',
						'frame_id' => '6',
						'block_id' => null
					),
					'label' => array('test_blocks', 'Original settings')
				)
			)
		);

		return $viewVars;
	}

/**
 * block()のテスト用DataProvider
 *
 * ### 戻り値
 *  - activeTab アクティブタブ
 *  - blockPermission ブロックパーミッションの値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('activeTab' => 'block_settings', 'blockPermission' => true),
			array('activeTab' => 'mail_settings', 'blockPermission' => true),
			array('activeTab' => 'role_permissions', 'blockPermission' => true),
			array('activeTab' => 'role_permissions', 'blockPermission' => false),
			array('activeTab' => 'original', 'blockPermission' => true),
		);
	}

/**
 * block()のテスト
 *
 * @param string $activeTab アクティブタブ
 * @param bool $blockPermission ブロックパーミッションの値
 * @dataProvider dataProvider
 * @return void
 */
	public function testBlock($activeTab, $blockPermission) {
		//Helperロード
		$viewVars = $this->__getViewVars();
		$requestData = array();
		$params = array('action' => 'edit');
		$this->loadHelper('Blocks.BlockTabs', $viewVars, $requestData, $params);

		//データ生成
		Current::$current['Permission']['block_editable']['value'] = true;
		Current::$current['Permission']['block_permission_editable']['value'] = $blockPermission;

		//テスト実施
		$result = $this->BlockTabs->block($activeTab);

		//チェック
		$this->__assertListTag($result, $activeTab, 'block_settings',
				'/test_plugin/test_ctrl/test', __d('blocks', 'Block settings'));

		$this->__assertListTag($result, $activeTab, 'mail_settings',
				'/test_blocks/test_block_mail_settings/edit', __d('mails', 'Mail settings'));

		if ($blockPermission) {
			$this->__assertListTag($result, $activeTab, 'role_permissions',
					'/test_blocks/test_block_block_role_permissions/edit', __d('net_commons', 'Role permission settings'));
		} else {
			$this->assertTextNotContains('role_permissions', $result);
		}

		$this->__assertListTag($result, $activeTab, 'original',
				'/original_plugin/original_ctrl/edit', 'Original settings(lang)'); //言語が読まれているかチェックするため固定する
	}

/**
 * block()のテスト(addアクション)
 *
 * @return void
 */
	public function testBlockAdd() {
		//Helperロード
		$viewVars = $this->__getViewVars();
		$requestData = array();
		$params = array('action' => 'add');
		$this->loadHelper('Blocks.BlockTabs', $viewVars, $requestData, $params);

		//データ生成
		$activeTab = 'block_settings';
		Current::$current['Permission']['block_editable']['value'] = true;
		Current::$current['Permission']['block_permission_editable']['value'] = true;

		//テスト実施
		$result = $this->BlockTabs->block($activeTab);

		//チェック
		$this->__assertListTag($result, $activeTab, 'block_settings',
				'/test_plugin/test_ctrl/test', __d('blocks', 'Block settings'));

		$this->assertTextNotContains('mail_settings', $result);
		$this->assertTextNotContains('role_permissions', $result);
		$this->assertTextNotContains('original', $result);
	}

/**
 * <li>の出力チェック
 *
 * @param string $result 結果
 * @param string $activeTab アクティブタブ
 * @param string $url URL
 * @param string $key タブキー
 * @param string $lang タブデータ
 * @return string <li>タグの出力
 */
	private function __assertListTag($result, $activeTab, $key, $url, $lang) {
		if ($activeTab === $key) {
			$activeCss = 'active';
		} else {
			$activeCss = '';
		}
		$pattern = '<li class="' . $activeCss . '"><a href="' . $url . '?frame_id=6">' . $lang . '</a></li>';
		$this->assertTextContains($pattern, $result);
	}

}
