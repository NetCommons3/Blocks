<?php
/**
 * BlockRolePermissionsControllerEditTest::testAccessPermission()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlockRolePermissionsControllerEditTest::testAccessPermission()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlockRolePermissionsControllerEditTest
 */
class TestSuiteBlockRolePermissionsControllerEditTestTestAccessPermissionTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlockRolePermissionsControllerEditTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlockRolePermissionsControllerEditTest();
	}

/**
 * testAccessPermission()のテスト
 *
 * @return void
 */
	public function testTestAccessPermission() {
		//データ生成
		$role = 'chief_editor';
		$exception = null;

		//テスト実施
		$result = $this->TestSuite->testAccessPermission($role, $exception);

		//チェック
		$pattern = '/' . preg_quote('TestSuite/BlockRolePermissionsControllerEditTestPermission/edit.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
		$this->assertEquals('chief_editor', $result->controller->viewVars['username']);
	}

/**
 * testAccessPermission()のテスト(ログインなし)
 *
 * @return void
 */
	public function testTestAccessPermissionWOLogin() {
		//データ生成
		$role = null;
		$exception = null;

		//テスト実施
		$result = $this->TestSuite->testAccessPermission($role, $exception);

		//チェック
		$pattern = '/' . preg_quote('TestSuite/BlockRolePermissionsControllerEditTestPermission/edit.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);
		$this->assertNull($result->controller->viewVars['username']);
	}

}
