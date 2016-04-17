<?php
/**
 * View/Elements/block_permission_settingのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/block_permission_settingのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Elements\BlockPermissionSetting
 */
class BlocksViewElementsBlockPermissionSettingTest extends NetCommonsControllerTestCase {

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
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestViewElementsBlockPermissionSetting');
	}

/**
 * View/Elements/block_permission_settingのテスト
 *
 * @return void
 */
	public function testBlockPermissionSetting() {
		//テスト実行
		$this->_testGetAction('/test_blocks/test_view_elements_block_permission_setting/block_permission_setting/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/block_permission_setting', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertTextContains('ng-controller="BlockRolePermissions"', $this->view);

		$pattern = 'data[BlockRolePermission][content_creatable][room_administrator][value]';
		$this->assertTextContains($pattern, $this->view);
	}

}
