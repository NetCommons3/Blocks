<?php
/**
 * BlockTabsHelper::setBlockTabs()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * BlockTabsHelper::setBlockTabs()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockTabsHelper
 */
class BlockTabsHelperSetBlockTabsTest extends NetCommonsHelperTestCase {

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
 * setBlockTabs()のテスト
 *
 * @return void
 */
	public function testSetBlockTabs() {
		//データ生成
		$blockTabs = array(
			'block_settings' => array(
				'url' => array('plugin' => 'test_plugin', 'controller' => 'test_ctrl', 'action' => 'test')
			),
			'mail_settings', 'role_permissions',
			'original' => array(
				'url' => '/original_plugin/controller/original_ctrl/edit'
			)
		);

		//テスト実施
		$this->BlockTabs->setBlockTabs($blockTabs);

		//チェック
		$expected = array('blockSettingTabs' => array(
			'block_settings' => array(
				'url' => '/test_plugin/test_ctrl/test'
			),
			'role_permissions' => array(
				'url' => '/test_blocks/test_block_block_role_permissions/edit'
			),
			'mail_settings' => array(
				'url' => '/test_blocks/test_block_mail_settings/edit'
			),
			'original' => array(
				'url' => '/original_plugin/controller/original_ctrl/edit'
			)
		));
		$this->assertEquals($expected, $this->BlockTabs->_View->viewVars);
	}

}
