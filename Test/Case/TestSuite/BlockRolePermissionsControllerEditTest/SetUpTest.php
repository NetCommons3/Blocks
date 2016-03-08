<?php
/**
 * BlockRolePermissionsControllerEditTest::setUp()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlockRolePermissionsControllerEditTest::setUp()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlockRolePermissionsControllerEditTest
 */
class TestSuiteBlockRolePermissionsControllerEditTestSetUpTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlockRolePermissionsControllerEditSetUpTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlockRolePermissionsControllerEditSetUpTest();
	}

/**
 * setUp()のテスト
 *
 * @return void
 */
	public function testSetUp() {
		//テスト実施
		$result = $this->TestSuite->setUp();

		//チェック
		$this->assertEquals('test_block_block_role_permissions', $result);
	}

}
