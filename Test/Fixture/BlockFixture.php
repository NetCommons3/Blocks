<?php
/**
 * BlockFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BlockFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Fixture
 */
class BlockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'room_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'plugin_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the plugin.', 'charset' => 'utf8'),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the block.', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Name of the block.', 'charset' => 'utf8'),
		'public_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => ''),
		'from' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame from.'),
		'to' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame to.'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'language_id' => 2,
			'room_id' => 1,
			'plugin_key' => 'blocks',
			'key' => 'block_1',
			'created_user' => 1,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 1,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 2,
			'language_id' => 2,
			'room_id' => 2,
			'plugin_key' => 'blocks',
			'key' => 'block_2',
			'created_user' => 2,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 2,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 3,
			'language_id' => 2,
			'room_id' => 3,
			'plugin_key' => 'blocks',
			'key' => 'block_3',
			'created_user' => 3,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 3,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 4,
			'language_id' => 2,
			'room_id' => 4,
			'plugin_key' => 'blocks',
			'key' => 'block_4',
			'created_user' => 4,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 4,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 5,
			'language_id' => 2,
			'room_id' => 1,
			'plugin_key' => 'blocks',
			'key' => 'block_5',
			'created_user' => 5,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 5,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 6,
			'language_id' => 2,
			'room_id' => 6,
			'plugin_key' => 'blocks',
			'key' => 'block_6',
			'created_user' => 6,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 6,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 7,
			'language_id' => 2,
			'room_id' => 7,
			'plugin_key' => 'blocks',
			'key' => 'block_7',
			'created_user' => 7,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 7,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 8,
			'language_id' => 2,
			'room_id' => 8,
			'plugin_key' => 'blocks',
			'key' => 'block_8',
			'created_user' => 8,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 8,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 9,
			'language_id' => 2,
			'room_id' => 9,
			'plugin_key' => 'blocks',
			'key' => 'block_9',
			'created_user' => 9,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 9,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 10,
			'language_id' => 2,
			'room_id' => 10,
			'plugin_key' => 'blocks',
			'key' => 'block_10',
			'created_user' => 10,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 10,
			'modified' => '2014-06-18 02:06:22'
		),

		//Faq plugin
		array(
			'id' => '100',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'faqs',
			'key' => 'block_100',
		),
		array(
			'id' => '101',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'faqs',
			'key' => 'block_101',
		),
		array(
			'id' => '102',
			'language_id' => '2',
			'room_id' => '2',
			'plugin_key' => 'faqs',
			'key' => 'block_102',
		),

		//Edumap plugin
		array(
			'id' => '121',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'edumap',
			'key' => 'block_121',
		),
		array(
			'id' => '122',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'edumap',
			'key' => 'block_122',
		),
		array(
			'id' => '123',
			'language_id' => '2',
			'room_id' => '2',
			'plugin_key' => 'edumap',
			'key' => 'block_123',
		),

		//Iframes plugin
		array(
			'id' => '141',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'iframes',
			'key' => 'block_141',
		),
		array(
			'id' => '142',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'iframes',
			'key' => 'block_142',
		),
		array(
			'id' => '143',
			'language_id' => '2',
			'room_id' => '2',
			'plugin_key' => 'iframes',
			'key' => 'block_143',
		),

		//AccessCounters plugin
		array(
			'id' => '161',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'access_counters',
			'key' => 'block_161',
		),
		array(
			'id' => '162',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'access_counters',
			'key' => 'block_162',
		),
		array(
			'id' => '163',
			'language_id' => '2',
			'room_id' => '2',
			'plugin_key' => 'access_counters',
			'key' => 'block_163',
		),

		//RssReaders plugin
		array(
			'id' => '181',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'rss_readers',
			'key' => 'block_181',
		),
		array(
			'id' => '182',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'rss_readers',
			'key' => 'block_182',
		),
		array(
			'id' => '183',
			'language_id' => '2',
			'room_id' => '2',
			'plugin_key' => 'rss_readers',
			'key' => 'block_183',
		),
		array(
			'id' => '186',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'rss_readers',
			'key' => 'block_186',
		),

		//Topics plugin
		array(
			'id' => '191',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'topics',
			'key' => 'block_191',
		),
		array(
			'id' => '192',
			'language_id' => '2',
			'room_id' => '1',
			'to' => '2000-01-01 00:00:00',
			'plugin_key' => 'topics',
			'key' => 'block_192',
		),
		array(
			'id' => '193',
			'language_id' => '2',
			'room_id' => '2',
			'plugin_key' => 'topics',
			'key' => 'block_193',
		),
		array(
			'id' => '196',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'topics',
			'key' => 'block_196',
		),

	);

}
