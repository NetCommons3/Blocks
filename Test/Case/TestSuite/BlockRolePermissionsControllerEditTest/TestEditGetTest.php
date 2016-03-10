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
 * testEditGet()のテスト
 *
 * @return void
 */
	public function testTestEditGet() {
		//データ生成
		$approvalFields = array(
			'TestBlocks' => array(
				'use_workflow',
				'use_comment_approval',
				'approval_type',
			)
		);
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testEditGet($approvalFields, $exception, $return);

		//チェック
		$expected = array(
			0 => array(array(
				'method' => 'assertInput', 'type' => 'form', 'name' => null,
				'value' => '/test_blocks/TestSuiteBlockRolePermissionsControllerEditTest/edit/4?frame_id=6'
			)),
			1 => array(array(
				'method' => 'assertInput', 'type' => 'input', 'name' => 'data[Block][id]', 'value' => '4'
			)),
			2 => array(array(
				'name' => 'data[BlockRolePermission][content_creatable][room_administrator][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			3 => array(array(
				'name' => 'data[BlockRolePermission][content_creatable][chief_editor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			4 => array(array(
				'name' => 'data[BlockRolePermission][content_creatable][editor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			5 => array(array(
				'name' => 'data[BlockRolePermission][content_creatable][general_user][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			6 => array(array(
				'name' => 'data[BlockRolePermission][content_comment_creatable][room_administrator][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			7 => array(array(
				'name' => 'data[BlockRolePermission][content_comment_creatable][chief_editor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			8 => array(array(
				'name' => 'data[BlockRolePermission][content_comment_creatable][editor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			9 => array(array(
				'name' => 'data[BlockRolePermission][content_comment_creatable][general_user][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			10 => array(array(
				'name' => 'data[BlockRolePermission][content_comment_creatable][visitor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			11 => array(array(
				'name' => 'data[BlockRolePermission][content_comment_publishable][room_administrator][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			12 => array(array(
				'name' => 'data[BlockRolePermission][content_comment_publishable][chief_editor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			13 => array(array(
				'name' => 'data[BlockRolePermission][content_comment_publishable][editor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			14 => array(array(
				'name' => 'data[TestBlocks][use_workflow]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			15 => array(array(
				'name' => 'data[TestBlocks][use_comment_approval]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			16 => array(array(
				'name' => 'data[TestBlocks][approval_type]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * testEditGet()のテスト(コメントがない（コメント承認もない）)
 *
 * @return void
 */
	public function testTestEditGetWOUseCommentApproval() {
		//データ生成
		$approvalFields = array(
			'TestBlocks' => array(
				'use_workflow',
				'approval_type',
			)
		);
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testEditGet($approvalFields, $exception, $return);

		//チェック
		$expected = array(
			0 => array(array(
				'method' => 'assertInput', 'type' => 'form', 'name' => null,
				'value' => '/test_blocks/TestSuiteBlockRolePermissionsControllerEditTest/edit/4?frame_id=6'
			)),
			1 => array(array(
				'method' => 'assertInput', 'type' => 'input', 'name' => 'data[Block][id]', 'value' => '4'
			)),
			2 => array(array(
				'name' => 'data[BlockRolePermission][content_creatable][room_administrator][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			3 => array(array(
				'name' => 'data[BlockRolePermission][content_creatable][chief_editor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			4 => array(array(
				'name' => 'data[BlockRolePermission][content_creatable][editor][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			5 => array(array(
				'name' => 'data[BlockRolePermission][content_creatable][general_user][value]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			6 => array(array(
				'name' => 'data[TestBlocks][use_workflow]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
			7 => array(array(
				'name' => 'data[TestBlocks][approval_type]',
				'method' => 'assertInput', 'type' => 'input', 'value' => null
			)),
		);
		$this->assertEquals($expected, $result);
	}

}
