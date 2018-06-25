<?php
/**
 * BlocksControllerEditTest::testAccessPermission()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerEditTest::testAccessPermission()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerEditTest
 */
class TestSuiteBlocksControllerEditTestTestAccessPermissionTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlocksControllerEditTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlocksControllerEditTest();
	}

/**
 * testAccessPermission()のテスト
 *
 * @return void
 */
	public function testTestAccessPermission() {
		//データ生成
		$action = 'edit';
		$method = 'get';
		$expected = 'edit';
		$role = 'chief_editor';
		$exception = null;

		//テスト実施
		$result = $this->TestSuite->testAccessPermission($action, $method, $expected, $role, $exception);

		//チェック
		$pattern = '/' . preg_quote('TestSuite/BlocksControllerEditTestPermission/edit.ctp', '/') . '/';
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
		$action = 'edit';
		$method = 'get';
		$expected = 'edit';
		$role = null;
		$exception = null;

		//テスト実施
		$result = $this->TestSuite->testAccessPermission($action, $method, $expected, $role, $exception);

		//チェック
		$pattern = '/' . preg_quote('TestSuite/BlocksControllerEditTestPermission/edit.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);

		$this->assertNull($result->controller->viewVars['username']);
	}

/**
 * testAccessPermission()のテスト(ExceptionError)
 *
 * @return void
 */
	//public function testTestAccessPermissionOnExceptionError() {
	//	//データ生成
	//	$action = 'edit_exception_error';
	//	$method = 'get';
	//	$expected = 'edit';
	//	$role = 'chief_editor';
	//	$exception = 'BadRequestException';
	//
	//	//テスト実施
	//	$this->TestSuite->testAccessPermission($action, $method, $expected, $role, $exception);
	//}

}
