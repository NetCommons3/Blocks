<?php
/**
 * ブロックにコンテンツの件数(content_count)を追加 migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * ブロックにコンテンツの件数(content_count)を追加 migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Config\Migration
 */
class AddContentCount extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Add_content_count';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'blocks' => array(
					'content_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'after' => 'publish_end'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'blocks' => array('content_count'),
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
