<?php
/**
 * 移行速度UPのためのIndex追加
 */
App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Class AddIndexForBlockSetting
 */
class AddIndexForBlockSetting extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index_for_block_setting';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'block_settings' => array(
					'room_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
				),
			),
			'create_field' => array(
				'block_settings' => array(
					'indexes' => array(
						'room_id' => array('column' => 'room_id', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'block_settings' => array(
					'room_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
				),
			),
			'drop_field' => array(
				'block_settings' => array('indexes' => array('room_id')),
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
