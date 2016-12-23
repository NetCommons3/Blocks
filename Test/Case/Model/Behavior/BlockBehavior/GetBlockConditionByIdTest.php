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
		'plugin.blocks.test_block_behavior_model_translation',
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
		$result[0]['model'] = 'TestBlocks.TestBlockBehaviorModel';

		$result[1] = array();
		$result[1]['conditions'] = array('TestBlockBehaviorModelTranslation.key' => 'content_1');
		$result[1]['model'] = 'TestBlocks.TestBlockBehaviorModelTranslation';

		return $result;
	}

/**
 * getBlockConditionById()のテスト
 *
 * @param array $conditions Model::find conditions default value
 * @param array $model Model名
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetBlockConditionById($conditions, $model) {
		$this->TestModel = ClassRegistry::init($model);

		//テストデータ
		Current::$current = Hash::insert(Current::$current, 'Room.id', '2');
		Current::$current = Hash::insert(Current::$current, 'Block.id', '2');

		//テスト実施
		$conditions = $this->TestModel->getBlockConditionById($conditions);
		if ($this->TestModel->alias === 'TestBlockBehaviorModel') {
			$expected = array(
				'Block.id' => '2',
				'Block.room_id' => '2',
				$this->TestModel->alias . '.key' => 'content_1'
			);
		} elseif ($this->TestModel->alias === 'TestBlockBehaviorModelTranslation') {
			$expected = array(
				'Block.id' => '2',
				'Block.room_id' => '2',
				$this->TestModel->alias . '.key' => 'content_1',
				'OR' => array(
					$this->TestModel->alias . '.language_id' => '2',
					$this->TestModel->alias . '.is_translation' => false,
				),
			);
		}
		$this->assertEquals($expected, $conditions);

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
		$expected = array(
			0 => array($this->TestModel->alias => array(
				'id' => '1',
				'block_id' => '2',
				'key' => 'content_1',
				'created_user' => '0',
				'created' => null,
				'modified_user' => '0',
				'modified' => null
			)),
			1 => array($this->TestModel->alias => array(
				'id' => '2',
				'block_id' => '2',
				'key' => 'content_1',
				'created_user' => '0',
				'created' => null,
				'modified_user' => '0',
				'modified' => null
			))
		);
		if ($this->TestModel->alias === 'TestBlockBehaviorModelTranslation') {
			$expected = Hash::merge($expected, array(
				0 => array(
					$this->TestModel->alias => array(
						'language_id' => '2',
						'is_origin' => true,
						'is_translation' => false,
					),
				),
				1 => array(
					$this->TestModel->alias => array(
						'language_id' => '2',
						'is_origin' => true,
						'is_translation' => false,
					),
				)
			));
		}

		$this->assertEquals($expected, $result);
	}

}
