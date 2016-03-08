<?php
/**
 * BlockTabsHelper::setMainTabs()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * BlockTabsHelper::setMainTabs()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockTabsHelper
 */
class BlockTabsHelperSetMainTabsTest extends NetCommonsHelperTestCase {

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

		//テストデータ生成
		$viewVars = array();
		$requestData = array();
		$params = array(
			'plugin' => 'test_blocks'
		);

		//Helperロード
		$this->loadHelper('Blocks.BlockTabs', $viewVars, $requestData, $params);
	}

/**
 * setMainTabs()のテスト
 *
 * @return void
 */
	public function testSetMainTabs() {
		//データ生成
		$mainTabs = array(
			'block_index' => array(
				'url' => array('plugin' => 'test_plugin', 'controller' => 'test_ctrl', 'action' => 'test')
			),
			'frame_settings', 'mail_settings', 'role_permissions',
			'original' => array(
				'url' => '/original_plugin/controller/original_ctrl/edit'
			)
		);

		//テスト実施
		$this->BlockTabs->setMainTabs($mainTabs);

		//チェック
		$expected = array('settingTabs' => array(
			'block_index' => array(
				'url' => '/test_plugin/test_ctrl/test'
			),
			'frame_settings' => array(
				'url' => '/test_blocks/test_block_frame_settings/edit'
			),
			'mail_settings' => array(
				'url' => '/test_blocks/test_block_mail_settings/edit'
			),
			'role_permissions' => array(
				'url' => '/test_blocks/test_block_block_role_permissions/edit'
			),
			'original' => array(
				'url' => '/original_plugin/controller/original_ctrl/edit'
			)
		));
		$this->assertEquals($expected, $this->BlockTabs->_View->viewVars);
	}

}
