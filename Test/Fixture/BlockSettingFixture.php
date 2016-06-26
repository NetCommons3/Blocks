<?php
/**
 * BlockSettingFixture
 *
* @author Noriko Arai <arai@nii.ac.jp>
* @author Your Name <yourname@domain.com>
* @link http://www.netcommons.org NetCommons Project
* @license http://www.netcommons.org/license.txt NetCommons License
* @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for BlockSettingFixture
 */
class BlockSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'room_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'block_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'field_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'value' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * #### BlockSettingBehaviorよりサンプルコードのコピー
 * ##### Model
 * ```php
 * public $actsAs = array(
 *	'Blocks.BlockSetting' => array(
 *		'fields' => array(
 *			'use_workflow',	// rooms.use_approvalによって値決まる。BlockSettingでデフォルト値設定しても無視される。
 *			'use_comment',
 *			'use_comment_approval',	// rooms.use_approvalによって値決まる。BlockSettingでデフォルト値設定しても無視される。
 *			'use_like',
 *			'use_unlike',
 *			'auto_play',	// 共通以外の項目もBlockSettingに持つ
 *		),
 *	),
 * ),
 * ```
 *
 * @var array
 */
	public $records = array(
		// プラグインデフォルト値 - room_idなし、block_keyなし
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => 'use_comment',
			'value' => 1,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => 'use_like',
			'value' => 1,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => 'use_unlike',
			'value' => 0,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => 'auto_play',
			'value' => 0,
		),
		// ブロック設定後 - room_idあり、block_keyあり
		array(
			'plugin_key' => 'dummy',
			'room_id' => 1,
			'block_key' => 'block_1',
			'field_name' => 'use_comment',
			'value' => 0,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => 1,
			'block_key' => 'block_1',
			'field_name' => 'use_like',
			'value' => 1,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => 1,
			'block_key' => 'block_1',
			'field_name' => 'use_unlike',
			'value' => 1,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => 1,
			'block_key' => 'block_1',
			'field_name' => 'auto_play',
			'value' => 1,
		),
	);

}
