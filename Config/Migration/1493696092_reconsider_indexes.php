<?php
/**
 * インデックスの見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * インデックスの見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Config\Migration
 */
class ReconsiderIndexes extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'reconsider_indexes';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'blocks' => array(
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
				),
				'blocks_languages' => array(
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'ブロックID'),
					'is_translation' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '翻訳したかどうか'),
				),
			),
			'drop_field' => array(
				'blocks_languages' => array('indexes' => array('language_id')),
			),
			'create_field' => array(
				'blocks' => array(
					'indexes' => array(
						'room_id' => array('column' => array('room_id', 'plugin_key'), 'unique' => 0),
					),
				),
				'blocks_languages' => array(
					'indexes' => array(
						'language_id' => array('column' => array('block_id', 'is_translation', 'language_id', 'id'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'blocks' => array(
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
				),
				'blocks_languages' => array(
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'ブロックID'),
					'is_translation' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index', 'comment' => '翻訳したかどうか'),
				),
			),
			'create_field' => array(
				'blocks_languages' => array(
					'indexes' => array(
						'language_id' => array(),
					),
				),
			),
			'drop_field' => array(
				'blocks' => array('indexes' => array('room_id')),
				'blocks_languages' => array('indexes' => array('language_id')),
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
