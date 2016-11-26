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
 * Records
 *
 * @var array
 */
	public $records = array(
		//公開データ
		array(
			'id' => '2',
			'room_id' => '2',
			'plugin_key' => 'test_plugin',
			'key' => 'block_1',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		//非公開データ
		array(
			'id' => '4',
			'room_id' => '2',
			'plugin_key' => 'test_plugin',
			'key' => 'block_2',
			'public_type' => '0',
			'publish_start' => null,
			'publish_end' => null,
		),
		//期間限定公開(範囲内)
		array(
			'id' => '6',
			'room_id' => '2',
			'plugin_key' => 'test_plugin',
			'key' => 'block_3',
			'public_type' => '2',
			'publish_start' => '2014-01-01 00:00:00',
			'publish_end' => '2035-12-31 00:00:00',
		),

		//期間限定公開(過去)
		array(
			'id' => '8',
			'room_id' => '2',
			'plugin_key' => 'test_plugin',
			'key' => 'block_4',
			'public_type' => '2',
			'publish_start' => null,
			'publish_end' => null,
		),

		//期間限定公開(未来)
		array(
			'id' => '10',
			'room_id' => '2',
			'plugin_key' => 'test_plugin',
			'key' => 'block_5',
			'public_type' => '2',
			'publish_start' => null,
			'publish_end' => null,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Blocks') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new BlocksSchema())->tables['blocks'];

		if (class_exists('NetCommonsTestSuite') && NetCommonsTestSuite::$plugin) {
			$records = array_keys($this->records);
			foreach ($records as $i) {
				if (Hash::get($this->records[$i], 'plugin_key', 'test_plugin') === 'test_plugin') {
					$this->records[$i]['plugin_key'] = NetCommonsTestSuite::$plugin;
				}
			}
		}
		parent::init();
	}

}
