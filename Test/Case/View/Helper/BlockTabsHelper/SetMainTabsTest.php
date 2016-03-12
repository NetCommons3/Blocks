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
				'url' => '/original_plugin/controller/original_ctrl/edit',
				'label' => array('original_plugin', 'Original settings')
			)
		);

		//テスト実施
		$this->BlockTabs->setMainTabs($mainTabs);

		//チェック
		$expected = array('settingTabs' => array(
			'block_index' => array(
				'url' => array(
					'plugin' => 'test_plugin',
					'controller' => 'test_ctrl',
					'action' => 'test',
					'frame_id' => null
				),
				'label' => array(0 => 'net_commons', 1 => 'List')
			),
			'frame_settings' => array(
				'url' => array(
					'plugin' => 'test_blocks',
					'controller' => 'test_block_frame_settings',
					'action' => 'edit',
					'frame_id' => null
				),
				'label' => array(0 => 'net_commons', 1 => 'Frame settings')
			),
			'mail_settings' => array(
				'url' => array(
					'plugin' => 'test_blocks',
					'controller' => 'test_block_mail_settings',
					'action' => 'edit',
					'frame_id' => null,
					'block_id' => null
				),
				'label' => array(0 => 'mails', 1 => 'Mail settings')
			),
			'role_permissions' => array(
				'url' => array(
					'plugin' => 'test_blocks',
					'controller' => 'test_block_block_role_permissions',
					'action' => 'edit',
					'frame_id' => null,
					'block_id' => null
				),
				'label' => array(0 => 'net_commons', 1 => 'Role permission settings'),
				'permission' => 'block_permission_editable'
			),
			'original' => array(
				'url' => '/original_plugin/controller/original_ctrl/edit',
				'label' => array(0 => 'original_plugin', 1 => 'Original settings'),
			)
		));
		$this->assertEquals($expected, $this->BlockTabs->_View->viewVars);
	}

}
