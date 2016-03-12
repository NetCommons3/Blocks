<?php
/**
 * BlockBehavior::validates()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestBlockBehaviorValidatesModelFixture', 'Blocks.Test/Fixture');

/**
 * BlockBehavior::validates()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockBehavior
 */
class BlockBehaviorValidatesTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.test_block_behavior_validates_model',
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
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockBehaviorValidatesModel');
	}

/**
 * DataProvider
 *
 * ### 戻り値
 * ```
 * array(
 * 	'Block' => array('id' => '2', 'key' => 'block_1'),
 * 	'Frame' => array('id' => '6'),
 * 	'TestBlockBehaviorSaveModel' => array(
 *		'id' => '2',
 *		'block_id' => '2',
 *		'block_key' => 'block_1',
 * 		'language_id' => '2',
 *		'key' => 'key_1',
 *		'name' => 'Edit Name',
 *	)
 * );
 * ```
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		$data = array(
			'TestBlockBehaviorValidatesModel' => array(
				'id' => '2',
				'block_id' => '2',
				'block_key' => 'block_1',
				'language_id' => '2',
				'key' => 'key_1',
				'name' => 'Test Name 1 ja',
			),
			'Block' => array(
				'id' => '2',
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => 'test_plugin',
				'key' => 'block_1',
				'name' => 'Block name 1',
				'public_type' => '2',
				'publish_start' => '2016-01-01 00:00:00',
				'publish_end' => '2035-03-31 00:00:00',
			)
		);

		$results = array();
		$results[0]['data'] = $data;
		$results[1]['data'] = Hash::insert($data, 'Block.public_type', '1');
		$results[2]['data'] = Hash::insert($data, 'Block.public_type', '0');

		return $results;
	}

/**
 * validates()のテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testValidates($data) {
		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();
		$this->assertTrue($result);

		//チェック
		if ($data['Block']['public_type'] !== '2') {
			$this->assertArrayNotHasKey('publish_start', $this->TestModel->data['Block']);
			$this->assertArrayNotHasKey('publish_end', $this->TestModel->data['Block']);
		} else {
			$this->assertArrayHasKey('publish_start', $this->TestModel->data['Block']);
			$this->assertArrayHasKey('publish_end', $this->TestModel->data['Block']);
		}
	}

/**
 * validates()のテスト(Blockなし)
 *
 * @return void
 */
	public function testValidatesWOBlock() {
		//テストデータ
		$data = $this->dataProvider()[0]['data'];
		unset($data['Block']);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();
		$this->assertTrue($result);
	}

/**
 * validates()のValidationErrorテスト
 *
 * @return void
 */
	public function testValidatesOnValidationError() {
		//テストデータ
		$data = $this->dataProvider()[0]['data'];
		$data['Block']['public_type'] = 'aaaa';

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();
		$this->assertFalse($result);

		//チェック
		$this->assertEquals(
			$this->TestModel->Block->validationErrors['public_type'][0], __d('net_commons', 'Invalid request.')
		);
	}

}
