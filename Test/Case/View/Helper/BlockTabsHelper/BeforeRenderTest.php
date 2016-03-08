<?php
/**
 * BlockTabsHelper::beforeRender()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlockTabsHelper::beforeRender()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Controller\Component\BlockTabsHelper
 */
class BlockTabsHelperBeforeRenderTest extends NetCommonsControllerTestCase {

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
 * beforeRender()のテスト
 *
 * @return void
 */
	public function testBeforeRender() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestBlockTabsHelperBeforeRender');

		//テスト実行
		$this->_testGetAction('/test_blocks/test_block_tabs_helper_before_render/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertTabs('assertTextContains', 'assertTextContains');
	}

/**
 * beforeRender()のテスト(メインタブのsettingsがない場合)
 *
 * @return void
 */
	public function testBeforeRenderWOMainTabs() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestBlockTabsHelperBeforeRender');

		//テスト実行
		$this->_testGetAction('/test_blocks/test_block_tabs_helper_before_render/index_w_o_main_tabs',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertTabs('assertTextNotContains', 'assertTextNotContains');
	}

/**
 * beforeRender()のテスト(ブロックタブのsettingsがない場合)
 *
 * @return void
 */
	public function testBeforeRenderWOBlockTabs() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestBlockTabsHelperBeforeRender');

		//テスト実行
		$this->_testGetAction('/test_blocks/test_block_tabs_helper_before_render/index_w_o_block_tabs',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertTabs('assertTextContains', 'assertTextNotContains');
	}

/**
 * beforeRender()のテスト
 *
 * @param string $methodMainTabs メインタブのチェックメソッド
 * @param string $methodBlockTabs ブロック設定タブのチェックメソッド
 * @return void
 */
	private function __assertTabs($methodMainTabs, $methodBlockTabs) {
		$pattern = '/' . preg_quote('View/Helper/TestBlockTabsHelperBeforeRender', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = 'settingTabs = array (' .
						'\'block_index\' => array (\'url\' => \'/test_blocks/test_block_blocks\',),' .
						'\'frame_settings\' => array (\'url\' => \'/test_blocks/test_block_frame_settings/edit\',),' .
						'\'mail_settings\' => array (\'url\' => \'/test_blocks/test_block_mail_settings/edit\',),' .
						'\'role_permissions\' => array (\'url\' => \'/test_blocks/test_block_block_role_permissions/edit\',),' .
					')';
		$this->$methodMainTabs($pattern, $this->view);

		$pattern = 'blockSettingTabs = array (' .
						'\'block_settings\' => array (\'url\' => \'/test_blocks/test_block_blocks\',),' .
						'\'role_permissions\' => array (\'url\' => \'/test_blocks/test_block_block_role_permissions/edit\',),' .
						'\'mail_settings\' => array (\'url\' => \'/test_blocks/test_block_mail_settings/edit\',),' .
					')';
		$this->$methodBlockTabs($pattern, $this->view);
	}

}
