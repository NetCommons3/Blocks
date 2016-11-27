<?php
/**
 * BlockBehavior::getBlockConditions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BlockBehavior::getBlockConditions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockBehavior
 */
class BlockBehaviorGetBlockConditionsTest extends NetCommonsModelTestCase {

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
 * getBlockConditions()テストのDataProvider
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
 * getBlockConditions()のテスト
 *
 * @param array $conditions Model::find conditions default value
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetBlockConditions($conditions) {
		//テストデータ
		Current::$current = Hash::insert(Current::$current, 'Room.id', '2');
		Current::$current = Hash::insert(Current::$current, 'Plugin.key', 'blocks');

		//テスト実施
		$conditions = $this->TestModel->getBlockConditions($conditions);
		$expected = array(
			'BlocksLanguage.language_id' => '2',
			'Block.room_id' => '2',
			'Block.plugin_key' => 'blocks',
			'TestBlockBehaviorModel.key' => 'content_1'
		);
		$this->assertEquals($expected, $conditions);

		$result = $this->TestModel->find('all', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));
		$expected = array(
			0 => array(
				'TestBlockBehaviorModel' => array(
					'id' => '1',
					'block_id' => '2',
					'key' => 'content_1',
					'created_user' => '0',
					'created' => null,
					'modified_user' => '0',
					'modified' => null,
				),
				'Block' => array(
					'id' => '2',
					'room_id' => '2',
					'plugin_key' => 'blocks',
					'key' => 'block_1',
					'public_type' => '1',
					'publish_start' => null,
					'publish_end' => null,
					'content_count' => '0',
					'created_user' => null,
					'created' => null,
					'modified_user' => null,
					'modified' => null,
				),
				'TrackableCreator' => array(
					'id' => null, 'handlename' => null,
				),
				'TrackableUpdater' => array(
					'id' => null, 'handlename' => null,
				),
				'BlocksLanguage' => array(
					'language_id' => '2',
					'block_id' => '2',
					'name' => 'Block name 1',
					'is_origin' => true,
					'is_translation' => false,
				),
			),
			1 => array(
				'TestBlockBehaviorModel' => array(
					'id' => '2',
					'block_id' => '2',
					'key' => 'content_1',
					'created_user' => '0',
					'created' => null,
					'modified_user' => '0',
					'modified' => null,
				),
				'Block' => array(
					'id' => '2',
					'room_id' => '2',
					'plugin_key' => 'blocks',
					'key' => 'block_1',
					'public_type' => '1',
					'publish_start' => null,
					'publish_end' => null,
					'content_count' => '0',
					'created_user' => null,
					'created' => null,
					'modified_user' => null,
					'modified' => null,
				),
				'TrackableCreator' => array(
					'id' => null, 'handlename' => null,
				),
				'TrackableUpdater' => array(
					'id' => null, 'handlename' => null,
				),
				'BlocksLanguage' => array(
					'language_id' => '2',
					'block_id' => '2',
					'name' => 'Block name 1',
					'is_origin' => true,
					'is_translation' => false,
				),
			),
		);
		$this->assertEquals($expected, $result);
	}

}
