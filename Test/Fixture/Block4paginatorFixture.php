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

App::uses('BlockFixture', 'Blocks.Test/Fixture');

/**
 * ページネーション用のBlockFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Fixture
 */
class Block4paginatorFixture extends BlockFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Block';

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
			'publish_start' => null,
			'publish_end' => null,
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

		//11-20は、各プラグインで設定関係のテストで使う

		//101-200まで、ページ遷移のためのテスト
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		for ($i = 11; $i <= 20; $i++) {
			$this->records[$i] = array(
				'id' => $i,
				'room_id' => '2',
				'plugin_key' => 'test_plugin',
				'key' => 'block_' . $i,
				'public_type' => '1',
			);
		}
		for ($i = 101; $i <= 200; $i++) {
			$this->records[$i] = array(
				'id' => $i,
				'room_id' => '5',
				'plugin_key' => 'test_plugin',
				'key' => 'block_' . $i,
				'public_type' => '1',
			);
		}

		if (class_exists('NetCommonsTestSuite') && NetCommonsTestSuite::$plugin) {
			$records = array_keys($this->records);
			foreach ($records as $i) {
				$this->records[$i]['plugin_key'] = NetCommonsTestSuite::$plugin;
			}
		}
		parent::init();
	}

}
