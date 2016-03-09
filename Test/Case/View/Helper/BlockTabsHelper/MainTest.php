<?php
/**
 * BlockTabsHelper::main()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * BlockTabsHelper::main()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockTabsHelper
 */
class BlockTabsHelperMainTest extends NetCommonsHelperTestCase {

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

		//テストデータ生成
		$viewVars = array(
			'settingTabs' => array(
				'block_index' => array(
					'url' => array(
						'plugin' => 'test_plugin',
						'controller' => 'test_ctrl',
						'action' => 'test',
						'frame_id' => '6'
					),
					'label' => array(0 => 'net_commons', 1 => 'List')
				),
				'frame_settings' => array(
					'url' => array(
						'plugin' => 'test_blocks',
						'controller' => 'test_block_frame_settings',
						'action' => 'edit',
						'frame_id' => '6'
					),
					'label' => array(0 => 'net_commons', 1 => 'Frame settings')
				),
				'mail_settings' => array(
					'url' => array(
						'plugin' => 'test_blocks',
						'controller' => 'test_block_mail_settings',
						'action' => 'edit',
						'frame_id' => '6',
						'block_id' => null
					),
					'label' => array(0 => 'mails', 1 => 'Mail settings')
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
		$requestData = array();
		$params = array();

		//Helperロード
		$this->loadHelper('Blocks.BlockTabs', $viewVars, $requestData, $params);
	}

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - activeTab アクティブタブ
 *  - blockPermission ブロックパーミッションの値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('activeTab' =>  'block_index', 'blockPermission' => true),
			array('activeTab' =>  'frame_settings', 'blockPermission' => true),
			array('activeTab' =>  'mail_settings', 'blockPermission' => true),
			array('activeTab' =>  'role_permissions', 'blockPermission' => true),
			array('activeTab' =>  'role_permissions', 'blockPermission' => false),
			array('activeTab' =>  'original', 'blockPermission' => true),
		);
	}

/**
 * main()のテスト
 *
 * @param string $activeTab アクティブタブ
 * @param bool $blockPermission ブロックパーミッションの値
 * @dataProvider dataProvider
 * @return void
 */
	public function testMain($activeTab, $blockPermission) {
		//データ生成
		Current::$current['Permission']['block_editable']['value'] = true;
		Current::$current['Permission']['block_permission_editable']['value'] = $blockPermission;

		//テスト実施
		$result = $this->BlockTabs->main($activeTab);

		//チェック
		$this->__assertListTag($result, $activeTab, 'block_index',
				'/test_plugin/test_ctrl/test', __d('net_commons', 'List'));
		$this->__assertListTag($result, $activeTab, 'frame_settings',
				'/test_blocks/test_block_frame_settings/edit', __d('net_commons', 'Frame settings'));
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
 * <li>の出力チェック
 *
 * @param string $result 結果
 * @param string $activeTab アクティブタブ
 * @param string $url URL
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
