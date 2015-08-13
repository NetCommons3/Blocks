<?php
/**
 * BlockRolePermission Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockRolePermission', 'Blocks.Model');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');

/**
 * BlockRolePermission Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model
 */
class BlockRolePermissionTest extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block_role_permission',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlockRolePermission = ClassRegistry::init('Blocks.BlockRolePermission');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlockRolePermission);

		parent::tearDown();
	}

/**
 * Expect BlockRolePermission->validateBlockRolePermissions() to return true on validation success
 *
 * @return  void
 */
	public function testValidateBlockRolePermissions() {
		$data = array(
			'BlockRolePermission' => array(
				'id' => 1,
				'roles_room_id' => 1,
				'block_key' => 'Lorem ipsum dolor sit amet',
				'permission' => 'Lorem ipsum dolor sit amet',
				'value' => true,
			)
		);
		$result = $this->BlockRolePermission->validateBlockRolePermissions($data);

		$this->assertTrue($result);
	}

/**
 * Expect BlockRolePermission->validateBlockRolePermissions() to return true on validation error
 *
 * @return  void
 */
	public function testValidateBlockRolePermissionsError() {
		$data = array(
			'BlockRolePermission' => array(
				'id' => 1,
				'roles_room_id' => 1,
				'block_key' => 'Lorem ipsum dolor sit amet',
				'permission' => '',
				'value' => true,
			)
		);
		$result = $this->BlockRolePermission->validateBlockRolePermissions($data);

		$this->assertFalse($result);
	}
}
