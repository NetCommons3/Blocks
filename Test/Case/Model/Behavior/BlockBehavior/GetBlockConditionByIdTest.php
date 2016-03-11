<?php
/**
 * BlockBehavior::getBlockConditionById()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BlockBehavior::getBlockConditionById()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockBehavior
 */
class BlockBehaviorGetBlockConditionByIdTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.test_block_behavior_model',
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
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockBehaviorModel');
	}

/**
 * getBlockConditionById()テストのDataProvider
 *
 * ### 戻り値
 *  - conditions Model::find conditions default value
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['conditions'] = array('TestBlockBehaviorModel.key' => 'content_1');

		return $result;
	}

/**
 * getBlockConditionById()のテスト
 *
 * @param array $conditions Model::find conditions default value
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetBlockConditionById($conditions) {
		//テストデータ
		Current::$current = Hash::insert(Current::$current, 'Room.id', '1');
		Current::$current = Hash::insert(Current::$current, 'Block.id', '2');

		//テスト実施
		$result = $this->TestModel->find('all', array(
			'recursive' => -1,
			'conditions' => $this->TestModel->getBlockConditionById($conditions),
			'joins' => array(
				array(
					'table' => $this->TestModel->Block->table,
					'alias' => $this->TestModel->Block->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->TestModel->alias . '.block_id' . ' = ' . $this->TestModel->Block->alias . ' .id',
					),
				),
			),
		));

		//チェック
		$expected = array(
			0 => array('TestBlockBehaviorModel' => array(
				'id' => '1',
				'block_id' => '2',
				'key' => 'content_1',
				'created_user' => '0',
				'created' => null,
				'modified_user' => '0',
				'modified' => null
			)),
			1 => array('TestBlockBehaviorModel' => array(
				'id' => '2',
				'block_id' => '2',
				'key' => 'content_1',
				'created_user' => '0',
				'created' => null,
				'modified_user' => '0',
				'modified' => null
			))
		);
		$this->assertEquals($expected, $result);
	}

}
