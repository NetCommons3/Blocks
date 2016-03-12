<?php
/**
 * BlockRolePermissionBehavior::save()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestBlockRolePermissionBehaviorSaveModelFixture', 'Blocks.Test/Fixture');

/**
 * BlockRolePermissionBehavior::save()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockRolePermissionBehavior
 */
class BlockRolePermissionBehaviorSaveTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.test_block_role_permission_behavior_save_model',
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
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockRolePermissionBehaviorSaveModel');

		//事前チェック用のモデル
		$this->BlockRolePermission = ClassRegistry::init('Blocks.BlockRolePermission');
	}

/**
 * テストデータ取得
 *
 * @return void
 */
	private function __data() {
		//テストデータ
		$data = array(
			'TestBlockRolePermissionBehaviorSaveModel' => (new TestBlockRolePermissionBehaviorSaveModelFixture())->records[0],
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
 * save()のテスト
 *
 * @return void
 */
	public function testSave() {
		//テストデータ
		$data = $this->__data();

		//事前チェック
		$count = $this->BlockRolePermission->find('count', array(
			'recursive' => -1,
		));
		$this->assertEquals(1, $count);

		//テスト実施
		$result = $this->TestModel->save($data);
		$this->assertNotEmpty($result);

		//チェック
		$count = $this->TestModel->BlockRolePermission->find('count', array(
			'recursive' => -1,
		));
		$this->assertEquals(4, $count);
	}

/**
 * save()のテスト(BlockRolePermissionなし)
 *
 * @return void
 */
	public function testSaveWOBlockRolePermission() {
		//テストデータ
		$data = $this->__data();
		unset($data['BlockRolePermission']);

		//事前チェック
		$count = $this->BlockRolePermission->find('count', array(
			'recursive' => -1,
		));
		$this->assertEquals(1, $count);

		//テスト実施
		$result = $this->TestModel->save($data);
		$this->assertNotEmpty($result);

		//チェック
		$count = $this->BlockRolePermission->find('count', array(
			'recursive' => -1,
		));
		$this->assertEquals(1, $count);
	}

/**
 * save()のテスト(BlockRolePermissionなし)
 *
 * @return void
 */
	public function testSaveOnExceptionError() {
		//テストデータ
		$data = $this->__data();
		$this->_mockForReturnFalse('TestModel', 'Blocks.BlockRolePermission', 'saveMany');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->save($data);
	}

}
