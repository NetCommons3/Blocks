<?php
/**
 * BlockRolePermissionBehavior::validates()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestBlockRolePermissionBehaviorValidatesModelFixture', 'Blocks.Test/Fixture');

/**
 * BlockRolePermissionBehavior::validates()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockRolePermissionBehavior
 */
class BlockRolePermissionBehaviorValidatesTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.test_block_role_permission_behavior_validates_model',
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
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockRolePermissionBehaviorValidatesModel');
	}

/**
 * テストデータ取得
 *
 * @return void
 */
	private function __data() {
		//テストデータ
		$data = array(
			'TestBlockRolePermissionBehaviorValidatesModel' => (new TestBlockRolePermissionBehaviorValidatesModelFixture())->records[0],
			'BlockRolePermission' => array(
				'content_creatable' => array(
					'general_user' => array(
						'id' => '1',
						'roles_room_id' => '4',
						'block_key' => 'block_1',
						'permission' => 'content_creatable',
						'value' => true,
					),
				),
				'content_comment_creatable' => array(
					'editor' => array(
						'id' => '',
						'roles_room_id' => '3',
						'block_key' => 'block_1',
						'permission' => 'content_comment_creatable',
						'value' => true,
					),
					'general_user' => array(
						'id' => '',
						'roles_room_id' => '4',
						'block_key' => 'block_1',
						'permission' => 'content_comment_creatable',
						'value' => true,
					),
					'visitor' => array(
						'id' => '',
						'roles_room_id' => '5',
						'block_key' => 'block_1',
						'permission' => 'content_comment_creatable',
						'value' => false,
					),
				),
			),
		);

		return $data;
	}

/**
 * validates()のテスト
 *
 * @return void
 */
	public function testValidates() {
		//テストデータ
		$data = $this->__data();

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();
		$this->assertTrue($result);
	}

/**
 * validates()のテスト(BlockRolePermissionなし)
 *
 * @return void
 */
	public function testValidatesWOBlockRolePermission() {
		//テストデータ
		$data = $this->__data();
		unset($data['BlockRolePermission']);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();
		$this->assertTrue($result);
	}

/**
 * validates()のValidationErrorテスト
 *
 * @return void
 */
	public function testValidatesOnValidationError() {
		//テストデータ
		$data = $this->__data();
		$data = Hash::remove($data, 'BlockRolePermission.content_creatable.general_user.permission');

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();
		$this->assertFalse($result);

		//チェック
		$this->assertEquals(
			__d('net_commons', 'Invalid request.'), Hash::get($this->TestModel->validationErrors, 'general_user.permission.0')
		);
	}

}
