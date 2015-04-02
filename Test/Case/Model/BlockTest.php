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
 * @package NetCommons\Blocks\Test\Case\Model
 */
class BlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.boxes.box',
		'plugin.frames.frame',
		'plugin.frames.plugin',
		'plugin.m17n.language',
		'plugin.rooms.room',
		'plugin.users.user',
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

		$this->assertArrayHasKey('id', $result['Block']);
		$this->assertArrayHasKey('key', $result['Block']);
		$this->assertTrue(strlen($result['Block']['key']) > 0, 'Error strlen Block.key');

		$this->assertEquals((int)$result['Block']['modified_user'], 1);
		$this->assertEquals((int)$result['Block']['created_user'], 1);

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

		$this->assertEquals($result['Block']['id'], 1, 'Error equals id = 1');
		$this->assertEquals($result['Block']['modified_user'], 1, 'Error equals modified_user = 1');

		CakeSession::write('Auth.User.id', null);
	}

/**
 * testSaveByFrameIdNoFrame
 *
 * @return  void
 */
	public function testSaveByFrameIdNoFrame() {
		$this->setExpectedException('InternalErrorException');

		$frameId = 999;

		$result = $this->Block->saveByFrameId($frameId);

		$this->assertFalse($result);
	}

/**
 * testSaveByFrameId
 *
 * @return  void
 */
	public function testSaveByFrameId() {
		$frameId = 1;

		$result = $this->Block->saveByFrameId($frameId);

		$this->assertArrayHasKey('id', $result['Block']);
		$this->assertArrayHasKey('key', $result['Block']);
		$this->assertTrue(strlen($result['Block']['key']) > 0, 'Error strlen Block.key');
	}

/**
 * testSaveByFrameIdNewBlock
 *
 * @return  void
 */
	public function testSaveByFrameIdNewBlock() {
		$frameId = 11;

		$result = $this->Block->saveByFrameId($frameId);

		$this->assertArrayHasKey('Block', $result, print_r($result, true));
		$this->assertArrayHasKey('id', $result['Block'], print_r($result['Block'], true));
		$this->assertArrayHasKey('key', $result['Block'], print_r($result['Block'], true));
		$this->assertTrue(strlen($result['Block']['key']) > 0, 'Error strlen Block.key');
	}

/**
 * testSaveByFrameIdBlockSaveError
 *
 * @return  void
 */
	public function testSaveByFrameIdBlockSaveError() {
		$this->setExpectedException('InternalErrorException');

		$this->Block = $this->getMockForModel('Blocks.Block', array('save'));
		$this->Block->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$frameId = 11;

		$this->Block->saveByFrameId($frameId);
	}

/**
 * testSaveByFrameIdBlockSaveError
 *
 * @return  void
 */
	public function testSaveByFrameIdFrameSaveError() {
		$this->setExpectedException('InternalErrorException');

		$this->Frame = $this->getMockForModel('Frames.Frame', array('save'));
		$this->Frame->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$frameId = 11;

		$this->Block->saveByFrameId($frameId);
	}

/**
 * Expect Block->validateBlock() to return true on validation success
 *
 * @return  void
 */
	public function testValidateBlock() {
		$data = array(
			'id' => 1,
			'language_id' => 2,
			'room_id' => 1,
			'key' => 'block_1',
		);
		$result = $this->Block->validateBlock($data);

		$this->assertTrue($result);
	}
}
