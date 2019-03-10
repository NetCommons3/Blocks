<?php
/**
 * BlockRolePermissionsControllerEditTest::testEditPost()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlockRolePermissionsControllerEditTest::testEditPost()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlockRolePermissionsControllerEditTest
 */
class TestSuiteBlockRolePermissionsControllerEditTestTestEditPostTest extends NetCommonsControllerTestCase {

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
 * testEditPost()のテスト
 *
 * @return void
 */
	public function testTestEditPost() {
		//データ生成
		$data = array(
			'TestBlocks' => array(
				'use_workflow' => true,
				'use_comment_approval' => true,
				'approval_type' => '2',
			)
		);
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testEditPost($data, $exception, $return);

		//チェック
		$expected = array(
			'Block' => array('id' => '2', 'key' => 'block_1'),
			'BlockRolePermission' => array(
				'content_creatable' => array(
					'general_user' => array(
						'roles_room_id' => '4', 'block_key' => 'block_1',
						'permission' => 'content_creatable', 'value' => '1'
					)
				),
				'content_comment_creatable' => array(
					'editor' => array(
						'roles_room_id' => '3', 'block_key' => 'block_1',
						'permission' => 'content_comment_creatable', 'value' => '1'
					),
					'general_user' => array(
						'roles_room_id' => '4', 'block_key' => 'block_1',
						'permission' => 'content_comment_creatable', 'value' => '1'
					),
					'visitor' => array(
						'roles_room_id' => '5', 'block_key' => 'block_1',
						'permission' => 'content_comment_creatable', 'value' => '1'
					)
				),
				'content_comment_publishable' => array(
					'editor' => array(
						'roles_room_id' => '3', 'block_key' => 'block_1',
						'permission' => 'content_comment_publishable', 'value' => '1'
					)
				)
			),
			'TestBlocks' => array(
				'use_workflow' => true, 'use_comment_approval' => true, 'approval_type' => '2'
			)
		);
		$this->assertEquals($expected, $result->controller->data);
	}

/**
 * testEditPost()のテスト(コメントがない（コメント承認もない）)
 *
 * @return void
 */
	public function testTestEditPostWOUseCommentApproval() {
		//データ生成
		$data = array(
			'TestBlocks' => array(
				'use_workflow' => true,
				'approval_type' => '1',
			)
		);
		$exception = null;
		$return = 'view';

		//テスト実施
		$result = $this->TestSuite->testEditPost($data, $exception, $return);

		//チェック
		$expected = array(
			'Block' => array('id' => '2', 'key' => 'block_1'),
			'BlockRolePermission' => array(
				'content_creatable' => array(
					'general_user' => array(
						'roles_room_id' => '4', 'block_key' => 'block_1',
						'permission' => 'content_creatable', 'value' => '1'
					)
				),
			),
			'TestBlocks' => array(
				'use_workflow' => true, 'approval_type' => '1'
			)
		);
		$this->assertEquals($expected, $result->controller->data);
	}

}
