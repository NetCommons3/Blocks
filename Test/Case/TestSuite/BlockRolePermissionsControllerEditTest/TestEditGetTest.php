<?php
/**
 * BlockRolePermissionsControllerEditTest::testEditGet()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlockRolePermissionsControllerEditTest::testEditGet()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlockRolePermissionsControllerEditTest
 */
class TestSuiteBlockRolePermissionsControllerEditTestTestEditGetTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.test_suite_block_role_permissions_controller_edit_test_model',
	);

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
 * testEditGet()のテスト
 *
 * @return void
 */
	public function testTestEditGet() {
		//データ生成
		$approvalFields = array(
			'TestSuiteBlockRolePermissionsControllerEditTestModel' => array(
				'use_workflow' => true,
				'use_comment_approval' => true,
				'approval_type' => true,
			)
		);
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testEditGet($approvalFields, $exception, $return);

		//チェック
		//TODO:assertを書く
		debug($result->view);
	}

}
