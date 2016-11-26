<?php
/**
 * BlockBehavior::deleteBlock()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BlockBehavior::deleteBlock()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockBehavior
 */
class BlockBehaviorDeleteBlockTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.test_block_behavior_delete_block_model',
		'plugin.blocks.test_block_behavior_delete_block_id_model',
		'plugin.blocks.test_block_behavior_delete_block_key_model',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'blocks';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Blocks', 'TestBlocks');
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockBehaviorDeleteBlockModel');
	}

/**
 * deleteBlock()テストのDataProvider
 *
 * ### 戻り値
 *  - blockId ブロックID
 *  - blockKey ブロックKey
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['blockId'] = array('1', '2');
		$result[0]['blockKey'] = 'block_1';

		return $result;
	}

/**
 * deleteBlock()のテスト
 *
 * @param array $blockId ブロックID
 * @param string $blockKey ブロックKey
 * @dataProvider dataProvider
 * @return void
 */
	public function testDeleteBlock($blockId, $blockKey) {
		//事前チェック
		$this->__preCheck($blockId, $blockKey);

		//テスト実施
		$result = $this->TestModel->deleteBlock($blockKey);
		$this->assertTrue($result);

		//チェック
		$this->__postCheck($blockId, $blockKey);
	}

/**
 * $model->Block->deleteAll()のExceptionErrorテスト
 *
 * @return void
 */
	public function testDeleteBlockOnBlockExceptionError() {
		$this->_mockForReturnFalse('TestModel', 'Blocks.Block', 'deleteAll');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->deleteBlock('block_1');
	}

/**
 * $model->Frame->updateAll()のExceptionErrorテスト
 *
 * @return void
 */
	public function testDeleteBlockOnFrameExceptionError() {
		$this->_mockForReturnFalse('TestModel', 'Frames.Frame', 'updateAll');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->deleteBlock('block_1');
	}

/**
 * $model->Frame->updateAll()のExceptionErrorテスト
 *
 * @return void
 */
	public function testDeleteBlockOnExceptionError() {
		$this->_mockForReturnFalse('TestModel', 'Blocks.BlockRolePermission', 'deleteAll');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->deleteBlock('block_1');
	}

/**
 * deleteBlock()の事前チェック
 *
 * @param array $blockId ブロックID
 * @param string $blockKey ブロックKey
 * @return void
 */
	private function __preCheck($blockId, $blockKey) {
		//事前チェック
		$Model = ClassRegistry::init('TestBlocks.TestBlockBehaviorDeleteBlockIdModel');
		$count = $Model->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_id' => $blockId)
		));
		$this->assertEquals(2, $count);

		$Model = ClassRegistry::init('TestBlocks.TestBlockBehaviorDeleteBlockKeyModel');
		$count = $Model->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_key' => $blockKey)
		));
		$this->assertEquals(1, $count);

		$Model = ClassRegistry::init('Blocks.Block');
		$count = $Model->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $blockKey)
		));
		$this->assertEquals(1, $count);

		$Model = ClassRegistry::init('Blocks.BlocksLanguage');
		$count = $Model->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_id' => $blockId)
		));
		$this->assertEquals(1, $count);

		$Model = ClassRegistry::init('Frames.Frame');
		$count = $Model->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_id' => $blockId)
		));
		$this->assertEquals(2, $count);

		$Model = ClassRegistry::init('Blocks.BlockRolePermission');
		$count = $Model->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_key' => $blockKey)
		));
		$this->assertEquals(1, $count);
	}

/**
 * deleteBlock()の実施後のチェック
 *
 * @param array $blockId ブロックID
 * @param string $blockKey ブロックKey
 * @return void
 */
	private function __postCheck($blockId, $blockKey) {
		//事前チェック
		$count = $this->TestModel->TestBlockBehaviorDeleteBlockIdModel->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_id' => $blockId)
		));
		$this->assertEquals(0, $count);

		$count = $this->TestModel->TestBlockBehaviorDeleteBlockKeyModel->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_key' => $blockKey)
		));
		$this->assertEquals(0, $count);

		$count = $this->TestModel->Block->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $blockKey)
		));
		$this->assertEquals(0, $count);

		$count = $this->TestModel->Frame->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_id' => $blockId)
		));
		$this->assertEquals(0, $count);

		$count = $this->TestModel->BlockRolePermission->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_key' => $blockKey)
		));
		$this->assertEquals(0, $count);
	}

}
