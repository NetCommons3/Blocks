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

/**
 * BlockRolePermission Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package Blocks\Test\Case\Model
 */
class BlockRolePermissionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block_role_permission',
		//'plugin.blocks.roles_room'
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
 * testIndex
 *
 * @return  void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}

}
