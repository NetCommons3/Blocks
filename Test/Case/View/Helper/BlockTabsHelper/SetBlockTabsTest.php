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
				'url' => '/original_plugin/controller/original_ctrl/edit',
				'label' => array('original', 'Original settings')
			)
		);

		//テスト実施
		$this->BlockTabs->setBlockTabs($blockTabs);

		//チェック
		$expected = array('blockSettingTabs' => array(
			'block_settings' => array(
				'url' => array(
					'plugin' => 'test_plugin',
					'controller' => 'test_ctrl',
					'action' => 'test',
					'frame_id' => null,
					'block_id' => null
				),
				'label' => array(0 => 'blocks', 1 => 'Block settings')
			),
			'mail_settings' => array(
				'url' => array(
					'plugin' => 'test_blocks',
					'controller' => 'test_block_mail_settings',
					'action' => 'edit',
					'frame_id' => null,
					'block_id' => null
				),
				'label' => array(0 => 'mails', 1 => 'Mail settings'),
				'permission' => 'block_permission_editable'
			),
			'role_permissions' => array(
				'url' => array(
					'plugin' => 'test_blocks',
					'controller' => 'test_block_block_role_permissions',
					'action' => 'edit',
					'frame_id' => null,
					'block_id' => null
				),
				'label' => array(0 => 'net_commons', 1 => 'Role permission settings')
			),
			'original' => array(
				'url' => '/original_plugin/controller/original_ctrl/edit',
				'label' => array(0 => 'original', 1 => 'Original settings')
			)
		));
		$this->assertEquals($expected, $this->BlockTabs->_View->viewVars);
	}

}
