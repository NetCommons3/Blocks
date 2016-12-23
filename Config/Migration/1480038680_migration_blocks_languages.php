<?php
/**
 * blocks.nameをblocks_languagesテーブルへ移動
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * blocks.nameをblocks_languagesテーブルへ移動
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Config\Migration
 */
class MigrationBlocksLanguages extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'migration_blocks_languages';

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
	public $records = array();

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
		$Block = $this->generateModel('Block');
		$BlocksLanguage = $this->generateModel('BlocksLanguage');

		if ($direction === 'up') {
			$sql = 'INSERT INTO ' . $BlocksLanguage->tablePrefix . $BlocksLanguage->table .
					' SELECT ' .
						'Block.id, Block.language_id, Block.id, Block.name, 1, 0, ' .
						'Block.created_user, Block.created, Block.modified_user, Block.modified' .
					' FROM ' . $Block->tablePrefix . $Block->table . ' ' . $Block->alias .
					' WHERE Block.language_id = 2';
			$BlocksLanguage->query($sql);

			$conditions = array(
				'Block.language_id !=' => '2'
			);
			if (! $Block->deleteAll($conditions, false)) {
				return false;
			}
		}
		return true;
	}
}
