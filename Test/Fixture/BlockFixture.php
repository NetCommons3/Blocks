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
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'unsigned' => false),
		'room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'block key |  プラグインKEY | plugins.key | ', 'charset' => 'utf8'),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the block.', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Name of the block.', 'charset' => 'utf8'),
		'public_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'unsigned' => false, 'comment' => '一般以下のパートが閲覧可能かどうか。
（0:非公開, 1:公開, 2:期間限定公開）

ルーム配下ならルーム管理者、またはそれに準ずるユーザ(room_parts.edit_page, room_parts.create_page 双方が true のユーザ)はこの値に関わらず閲覧できる。
e.g.) ルーム管理者、またはそれに準ずるユーザ: ルーム管理者、編集長

期間限定公開の場合、現在時刻がfrom-toカラムの範囲内の時に公開。'),
		'from' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame from.'),
		'to' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame to.'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//公開データ
		array(
			'id' => '1',
			'language_id' => '1',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_1',
			'name' => 'Block name 1',
			'public_type' => '1',
			'from' => null,
			'to' => null,
		),
		array(
			'id' => '2',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_1',
			'name' => 'Block name 1',
			'public_type' => '1',
			'from' => null,
			'to' => null,
		),
		//非公開データ
		array(
			'id' => '3',
			'language_id' => '1',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_2',
			'name' => 'Block name 2',
			'public_type' => '0',
			'from' => null,
			'to' => null,
		),
		array(
			'id' => '4',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_2',
			'name' => 'Block name 2',
			'public_type' => '0',
			'from' => null,
			'to' => null,
		),
		//期間限定公開(範囲内)
		array(
			'id' => '5',
			'language_id' => '1',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_3',
			'name' => 'Block name 3',
			'public_type' => '2',
			'from' => null,
			'to' => null,
		),
		array(
			'id' => '6',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_3',
			'name' => 'Block name 3',
			'public_type' => '2',
			'from' => null,
			'to' => null,
		),

		//期間限定公開(過去)
		array(
			'id' => '7',
			'language_id' => '1',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_4',
			'name' => 'Block name 4',
			'public_type' => '2',
			'from' => null,
			'to' => null,
		),
		array(
			'id' => '8',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_4',
			'name' => 'Block name 4',
			'public_type' => '2',
			'from' => null,
			'to' => null,
		),

		//期間限定公開(未来)
		array(
			'id' => '9',
			'language_id' => '1',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_5',
			'name' => 'Block name 5',
			'public_type' => '2',
			'from' => null,
			'to' => null,
		),
		array(
			'id' => '10',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'blocks',
			'key' => 'block_5',
			'name' => 'Block name 5',
			'public_type' => '2',
			'from' => null,
			'to' => null,
		),

		////Faq plugin
		//array(
		//	'id' => '100',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'faqs',
		//	'key' => 'block_100',
		//),
		//array(
		//	'id' => '101',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'faqs',
		//	'key' => 'block_101',
		//),
		//array(
		//	'id' => '102',
		//	'language_id' => '2',
		//	'room_id' => '2',
		//	'plugin_key' => 'faqs',
		//	'key' => 'block_102',
		//),
		//
		////Edumap plugin
		//array(
		//	'id' => '121',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'edumap',
		//	'key' => 'block_121',
		//),
		//array(
		//	'id' => '122',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'edumap',
		//	'key' => 'block_122',
		//),
		//array(
		//	'id' => '123',
		//	'language_id' => '2',
		//	'room_id' => '2',
		//	'plugin_key' => 'edumap',
		//	'key' => 'block_123',
		//),
		//
		////Iframes plugin
		//array(
		//	'id' => '141',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'iframes',
		//	'key' => 'block_141',
		//),
		//array(
		//	'id' => '142',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'iframes',
		//	'key' => 'block_142',
		//),
		//array(
		//	'id' => '143',
		//	'language_id' => '2',
		//	'room_id' => '2',
		//	'plugin_key' => 'iframes',
		//	'key' => 'block_143',
		//),
		//
		////AccessCounters plugin
		//array(
		//	'id' => '161',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'access_counters',
		//	'key' => 'block_161',
		//),
		//array(
		//	'id' => '162',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'access_counters',
		//	'key' => 'block_162',
		//),
		//array(
		//	'id' => '163',
		//	'language_id' => '2',
		//	'room_id' => '2',
		//	'plugin_key' => 'access_counters',
		//	'key' => 'block_163',
		//),
		//
		////RssReaders plugin
		//array(
		//	'id' => '181',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'rss_readers',
		//	'key' => 'block_181',
		//),
		//array(
		//	'id' => '182',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'rss_readers',
		//	'key' => 'block_182',
		//),
		//array(
		//	'id' => '183',
		//	'language_id' => '2',
		//	'room_id' => '2',
		//	'plugin_key' => 'rss_readers',
		//	'key' => 'block_183',
		//),
		//array(
		//	'id' => '186',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'rss_readers',
		//	'key' => 'block_186',
		//),
		//
		////Topics plugin
		//array(
		//	'id' => '191',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'topics',
		//	'key' => 'block_191',
		//),
		//array(
		//	'id' => '192',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'to' => '2000-01-01 00:00:00',
		//	'plugin_key' => 'topics',
		//	'key' => 'block_192',
		//),
		//array(
		//	'id' => '193',
		//	'language_id' => '2',
		//	'room_id' => '2',
		//	'plugin_key' => 'topics',
		//	'key' => 'block_193',
		//),
		//array(
		//	'id' => '196',
		//	'language_id' => '2',
		//	'room_id' => '1',
		//	'plugin_key' => 'topics',
		//	'key' => 'block_196',
		//),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		if (class_exists('NetCommonsCakeTestCase')) {
			$records = array_keys($this->records);
			foreach ($records as $i) {
				$this->records[$i]['plugin_key'] = NetCommonsCakeTestCase::$plugin;
			}
		}
		parent::init();
	}

}
