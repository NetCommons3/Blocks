<?php
/**
 * Block Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Block', 'Blocks.Model');

/**
 * Block Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package Blocks\Test\Case\Model
 */
class BlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		//'plugin.blocks.language',
		//'plugin.blocks.room',
		//'plugin.blocks.group',
		//'plugin.blocks.groups_language',
		//'plugin.blocks.user',
		//'plugin.blocks.groups_user',
		//'plugin.blocks.space',
		//'plugin.blocks.box',
		//'plugin.blocks.top_page',
		//'plugin.blocks.page',
		//'plugin.blocks.frame',
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

/**
 * testIndex
 *
 * @return  void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}

/**
 * testCreateSave
 *
 * @return  void
 */
	public function testCreateSave() {
		CakeSession::write('Auth.User.id', 1);

		$block['Block'] = array(
			'language_id' => 2,
			'room_id' => 1,
			'name' => 'testCreateSave',
		);
		$result = $this->Block->save($block);

		$this->assertTrue(isset($result['Block']['id']));
		$this->assertTrue(isset($result['Block']['key']) && strlen($result['Block']['key']) > 0);
		$this->assertTrue((int)$result['Block']['created_user'] === 1);
		$this->assertTrue((int)$result['Block']['modified_user'] === 1);

		CakeSession::write('Auth.User.id', null);
	}

/**
 * testUpdateSave
 *
 * @return  void
 */
	public function testUpdateSave() {
		CakeSession::write('Auth.User.id', 1);

		$block['Block'] = array(
			'id' => 1,
			'name' => 'testUpdateSave',
		);

		$result = $this->Block->save($block);

		$this->assertTrue((int)$result['Block']['id'] === 1);
		$this->assertTrue((int)$result['Block']['modified_user'] === 1);

		CakeSession::write('Auth.User.id', null);
	}

}
