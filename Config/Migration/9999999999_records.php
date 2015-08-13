<?php
/**
 * Initial data generation of Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Initial data generation of Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Config\Migration
 */
class Records extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * Records keyed by model name.
 *
 * @var array $records
 */
	public $records = array(
		'Block' => array(
			//日本語
			array(
				'id' => '1',
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => 'announcements',
				'key' => 'block_1',
			),
			array(
				'id' => '2',
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => 'menus',
				'key' => 'block_2',
			),
			//英語
			array(
				'id' => '3',
				'language_id' => '1',
				'room_id' => '1',
				'plugin_key' => 'announcements',
				'key' => 'block_1',
			),
			array(
				'id' => '4',
				'language_id' => '1',
				'room_id' => '1',
				'plugin_key' => 'menus',
				'key' => 'block_2',
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
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}

		return true;
	}
}
