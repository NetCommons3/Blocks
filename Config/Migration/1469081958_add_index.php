<?php
/**
 * AddIndex
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * AddIndex
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Config\Migration
 */
class AddIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'block_role_permissions' => array(
					'roles_room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
				),
				'block_settings' => array(
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'blocks' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'ブロックKey', 'charset' => 'utf8'),
				),
			),
			'create_field' => array(
				'block_role_permissions' => array(
					'indexes' => array(
						'roles_room_id' => array('column' => array('roles_room_id', 'block_key'), 'unique' => 0),
					),
				),
				'block_settings' => array(
					'indexes' => array(
						'plugin_key' => array('column' => array('plugin_key', 'room_id', 'block_key', 'field_name'), 'unique' => 0, 'length' => array('191', '191', '191')),
					),
				),
				'blocks' => array(
					'indexes' => array(
						'key' => array('column' => 'key', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'block_role_permissions' => array(
					'roles_room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
				),
				'block_settings' => array(
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'blocks' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'ブロックKey', 'charset' => 'utf8'),
				),
			),
			'drop_field' => array(
				'block_role_permissions' => array('indexes' => array('roles_room_id')),
				'block_settings' => array('indexes' => array('plugin_key')),
				'blocks' => array('indexes' => array('key')),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
