<?php
/**
 * BlockRolePermissionFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BlockRolePermissionFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Fixture
 */
class BlockRolePermissionFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'roles_room_id' => '4',
			'block_key' => 'block_1',
			'permission' => 'content_creatable',
			'value' => true,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Blocks') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new BlocksSchema())->tables['block_role_permissions'];

		parent::init();
	}

}
