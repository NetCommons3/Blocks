<?php
/**
 * Block Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Block', 'Blocks.Model');

/**
 * Summary for Block Test Case
 */
class BlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.blocks.language',
		'plugin.blocks.room',
		'plugin.blocks.group',
		'plugin.blocks.groups_language',
		'plugin.blocks.user',
		'plugin.blocks.groups_user',
		'plugin.blocks.space',
		'plugin.blocks.box',
		'plugin.blocks.top_page',
		'plugin.blocks.page',
		'plugin.blocks.access_counter',
		'plugin.blocks.access_counters_count',
		'plugin.blocks.access_counters_format',
		'plugin.blocks.announcement',
		'plugin.blocks.frame',
		'plugin.blocks.notepad',
		'plugin.blocks.notepads_block'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Block = ClassRegistry::init('Blocks.Block');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Block);

		parent::tearDown();
	}

}
