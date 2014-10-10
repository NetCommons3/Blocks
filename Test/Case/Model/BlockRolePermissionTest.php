<?php
/**
 * BlockRolePermission Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlockRolePermission', 'Blocks.Model');

/**
 * Summary for BlockRolePermission Test Case
 */
class BlockRolePermissionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block_role_permission',
		'plugin.blocks.roles_room'
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

}
