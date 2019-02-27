<?php
/**
 * Currentライブラリの速度改善
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Currentライブラリの速度改善
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Config\Migration
 */
class ImprovePerformanceCurrent2 extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'improve_performance_current_2';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'block_role_permissions' => array(
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
			),
			'create_field' => array(
				'block_role_permissions' => array(
					'indexes' => array(
						'block_key' => array('column' => array('block_key', 'permission', 'roles_room_id', 'value', 'id'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'block_role_permissions' => array(
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
			),
			'drop_field' => array(
				'block_role_permissions' => array('indexes' => array('block_key')),
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
