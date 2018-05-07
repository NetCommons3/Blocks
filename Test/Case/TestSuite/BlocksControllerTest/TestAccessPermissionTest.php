<?php
/**
 * BlocksControllerTest::testAccessPermission()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerTest::testAccessPermission()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerTest
 */
class TestSuiteBlocksControllerTestTestAccessPermissionTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlocksControllerTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlocksControllerTest();
	}

/**
 * testAccessPermission()のテスト
 *
 * @return void
 */
	public function testTestAccessPermission() {
		//データ生成
		$role = 'chief_editor';
		$isException = false;

		//テスト実施
		$result = $this->TestSuite->testAccessPermission($role, $isException);

		//チェック
		$pattern = '/' . preg_quote('TestSuite/BlocksControllerTest/index.ctp', '/') . '/';
		$this->assertRegExp($pattern, $result->view);

		$this->assertEquals('chief_editor', $result->controller->viewVars['username']);
	}

/**
 * testAccessPermission()のテスト(ExceptionError)
 *
 * @return void
 */
	//public function testTestAccessPermissionOnExceptionError() {
	//	//データ生成
	//	$role = 'chief_editor';
	//	$isException = true;
	//
	//	//テスト実施
	//	$this->TestSuite->testAccessPermissionError($role, $isException);
	//}

}
