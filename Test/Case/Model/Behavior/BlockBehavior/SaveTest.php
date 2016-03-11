<?php
/**
 * BlockBehavior::save()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestBlockBehaviorSaveModelFixture', 'Blocks.Test/Fixture');

/**
 * BlockBehavior::save()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockBehavior
 */
class BlockBehaviorSaveTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.test_block_behavior_save_model',
		'plugin.blocks.test_block_behavior_save_many_model',
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
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockBehaviorSaveModel');
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
		$results = array();

		$results[0]['data'] = array(
			'Block' => array('id' => '2', 'key' => 'block_1'),
			'Frame' => array('id' => '6'),
			'TestBlockBehaviorSaveModel' => array(
				'id' => '2', 'block_id' => '2', 'block_key' => 'block_1',
				'language_id' => '2', 'key' => 'key_1', 'name' => 'Edit Name',
			),
		);

		return $results;
	}

/**
 * DataProvider
 *
 * ### 戻り値
 * ```
 * array(
 *		'Block' => array('id' => '2', 'key' => 'block_1'),
 *		'Frame' => array('id' => '6'),
 *		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '',
 * 			'block_id' => '',
 * 			'block_key' => '',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'New Name'
 *		)
 *	);
 * ```
 *
 * @return array テストデータ
 */
	public function dataProviderNew() {
		$results = array();

		$results[0]['data'] = array(
			'Block' => array('id' => '2', 'key' => 'block_1'),
			'Frame' => array('id' => '6'),
			'TestBlockBehaviorSaveModel' => array(
				'id' => '', 'block_id' => '', 'block_key' => '',
				'language_id' => '2', 'key' => 'key_1', 'name' => 'New Name',
			)
		);

		return $results;
	}

/**
 * save()のテスト
 *
 * #### テストケース1
 * ```
 * $data = array(
 * 		'Block' => array('id' => '2', 'key' => 'block_1'),
 * 		'Frame' => array('id' => '6'),
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '2',
 * 			'block_id' => '2',
 * 			'block_key' => 'block_1',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'Edit Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveCase1($data) {
		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$data['Block']['name'] = $data[$this->TestModel->alias]['name'];
		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);
	}

/**
 * save()のテスト
 *
 * #### テストケース2
 * ```
 * $data = array(
 * 		'Block' => テストケース1と同じ,
 * 		'Frame' => テストケース1と同じ,
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '',
 * 			'block_id' => '',
 * 			'block_key' => '',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'New Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderNew
 * @return void
 */
	public function testSaveCase2($data) {
		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$data['Block']['name'] = $data[$this->TestModel->alias]['name'];
		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);
	}

/**
 * save()のテスト
 *
 * #### テストケース3
 * ```
 * $data = array(
 * 		'Block' => テストケース１と同じ,
 * 		'Frame' => テストケース１と同じ,
 * 		'TestBlockBehaviorSaveModel' => テストケース１と同じ,
 * 		0 => array(
 * 			'TestBlockBehaviorSaveManyModel' => array(
 * 				'block_id' => '',
 * 				'block_key' => '',
 * 				'language_id' => '2',
 * 				'model_key' => 'key_1',
 * 				'name' => 'Name'
 * 			)
 * 		),
 * 		1 => array(
 * 			'TestBlockBehaviorSaveManyModel' => array(
 * 				'block_id' => '',
 * 				'block_key' => '',
 * 				'language_id' => '2',
 * 				'model_key' => 'key_1',
 * 				'name' => 'Name'
 * 			)
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveCase3($data) {
		//テストデータ生成
		$data = Hash::merge($data, array(
			0 => array('TestBlockBehaviorSaveManyModel' => array(
				'block_id' => '', 'block_key' => '',
				'language_id' => '2', 'model_key' => 'key_1', 'name' => 'Name 1',
			)),
			1 => array('TestBlockBehaviorSaveManyModel' => array(
				'block_id' => '', 'block_key' => '',
				'language_id' => '2', 'model_key' => 'key_1', 'name' => 'Name 2',
			)),
		));

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$data['Block']['name'] = $data[$this->TestModel->alias]['name'];
		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);
		$this->__assertTestModelMany('0.TestBlockBehaviorSaveManyModel', $data, $result);
		$this->__assertTestModelMany('1.TestBlockBehaviorSaveManyModel', $data, $result);
	}

/**
 * save()のテスト
 *
 * #### テストケース4
 * ```
 * $data = array(
 * 		'Block' => テストケース１と同じ,
 * 		'Frame' => テストケース１と同じ,
 * 		'TestBlockBehaviorSaveModel' => テストケース１と同じ,
 * 		'TestBlockBehaviorSaveManyModel' => array(
 * 			0 => array(
 * 				'block_id' => '',
 * 				'block_key' => '',
 * 				'language_id' => '2',
 * 				'model_key' => 'key_1',
 * 				'name' => 'Name 1'
 * 			),
 * 			1 => array(
 * 				'block_id' => '',
 * 				'block_key' => '',
 * 				'language_id' => '2',
 * 				'model_key' => 'key_1',
 * 				'name' => 'Name 2'
 * 			)
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveCase4($data) {
		//テストデータ生成
		$data = Hash::merge($data, array(
			'TestBlockBehaviorSaveManyModel' => array(
				0 => array(
					'block_id' => '', 'block_key' => '',
					'language_id' => '2', 'model_key' => 'key_1', 'name' => 'Name 1',
				),
				1 => array(
					'block_id' => '', 'block_key' => '',
					'language_id' => '2', 'model_key' => 'key_1', 'name' => 'Name 2',
				)
			),
		));

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$data['Block']['name'] = $data[$this->TestModel->alias]['name'];

		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);
		$this->__assertTestModelMany('TestBlockBehaviorSaveManyModel.0', $data, $result);
		$this->__assertTestModelMany('TestBlockBehaviorSaveManyModel.1', $data, $result);
	}

/**
 * save()のテスト
 *
 * #### テストケース5
 * ```
 * $data = array(
 * 		'Block' => テストケース１と同じ,
 * 		'Frame' => テストケース１と同じ,
 * 		'TestBlockBehaviorSaveModel' => テストケース１と同じ,
 * 		'TestBlockBehaviorSaveManyModels' => array(
 * 			0 => array(
 * 				'TestBlockBehaviorSaveManyModel' => array(
 * 					'block_id' => '',
 * 					'block_key' => '',
 * 					'language_id' => '2',
 * 					'model_key' => 'key_1',
 * 					'name' => 'Name 1'
 * 				)
 * 			),
 * 			1 => array(
 * 				'TestBlockBehaviorSaveManyModel' => array(
 * 					'block_id' => '',
 * 					'block_key' => '',
 * 					'language_id' => '2',
 * 					'model_key' => 'key_1',
 * 					'name' => 'Name 2'
 * 				)
 * 			)
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveCase5($data) {
		//テストデータ生成
		$data = Hash::merge($data, array(
			'TestBlockBehaviorSaveManyModels' => array(
				0 => array('TestBlockBehaviorSaveManyModel' => array(
					'block_id' => '', 'block_key' => '',
					'language_id' => '2', 'model_key' => 'key_1', 'name' => 'Name 1',
				)),
				1 => array('TestBlockBehaviorSaveManyModel' => array(
					'block_id' => '', 'block_key' => '',
					'language_id' => '2', 'model_key' => 'key_1', 'name' => 'Name 2',
				)),
			)
		));

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$data['Block']['name'] = $data[$this->TestModel->alias]['name'];
		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);
		$this->__assertTestModelMany('TestBlockBehaviorSaveManyModels.0.TestBlockBehaviorSaveManyModel', $data, $result);
		$this->__assertTestModelMany('TestBlockBehaviorSaveManyModels.1.TestBlockBehaviorSaveManyModel', $data, $result);
	}

/**
 * save()のテスト
 *
 * #### テストケース(Frameなし)
 * ```
 * $data = array(
 * 		'Block' => テストケース1と同じ,
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '',
 * 			'block_id' => '',
 * 			'block_key' => '',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'New Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderNew
 * @return void
 */
	public function testSaveCaseWOFrame($data) {
		//テストデータ生成
		unset($data['Frame']);

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$alias = 'TestBlockBehaviorSaveModel';
		$this->assertEquals($data['Block'], $result['Block']);

		$expected = array(
			'id' => '3',
			'block_id' => '',
			'block_key' => '',
			'language_id' => '2',
			'key' => 'key_1',
			'name' => $data[$alias]['name'],
		);
		$this->assertDatetime($result[$alias]['created']);
		$this->assertDatetime($result[$alias]['modified']);
		$result[$alias] = Hash::remove($result[$alias], 'created');
		$result[$alias] = Hash::remove($result[$alias], 'modified');

		$this->assertEquals($expected, $result[$alias]);
	}

/**
 * save()のテスト
 *
 * #### テストケース(Frameあり、Blockなし)
 * ```
 * $data = array(
 * 		'Block' => テストケース1と同じ,
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '',
 * 			'block_id' => '',
 * 			'block_key' => '',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'New Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderNew
 * @return void
 */
	public function testSaveCaseWFrameWOBlock($data) {
		//テストデータ生成
		unset($data['Block']);

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$this->assertNull(Hash::get($result, 'Block'));

		$alias = 'TestBlockBehaviorSaveModel';
		$expected = array(
			'id' => '3',
			'block_id' => '',
			'block_key' => '',
			'language_id' => '2',
			'key' => 'key_1',
			'name' => $data[$alias]['name'],
		);
		$this->assertDatetime($result[$alias]['created']);
		$this->assertDatetime($result[$alias]['modified']);
		$result[$alias] = Hash::remove($result[$alias], 'created');
		$result[$alias] = Hash::remove($result[$alias], 'modified');

		$this->assertEquals($expected, $result[$alias]);
	}

/**
 * save()のテスト
 *
 * #### テストケース(Frameなし、Blockなし)
 * ```
 * $data = array(
 * 		'Frame' => array('id' => '14'),
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '',
 * 			'block_id' => '',
 * 			'block_key' => '',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'New Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderNew
 * @return void
 */
	public function testSaveCaseWOFrameWOBlock($data) {
		//テストデータ生成
		unset($data['Block']);
		$data['Frame']['id'] = '14';

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$data['Block']['id'] = '11';
		$data['Block']['key'] = OriginalKeyBehavior::generateKey($this->TestModel->Block->alias, $this->TestModel->useDbConfig);
		$data['Block']['name'] = $data[$this->TestModel->alias]['name'];
		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);
	}

/**
 * save()のテスト
 *
 * #### テストケース(ブロック名とModelのnameが異なる)
 * ```
 * $data = array(
 * 		'Block' => array('id' => '2', 'key' => 'block_1', 'name' => 'Block name'),
 * 		'Frame' => テストケース1と同じ,
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '',
 * 			'block_id' => '',
 * 			'block_key' => '',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'New Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderNew
 * @return void
 */
	public function testSaveCaseWBlockName($data) {
		//テストデータ生成
		$data['Block']['name'] = 'Block name';

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);
	}

/**
 * save()のテスト
 *
 * #### テストケース(Frame.idが不正)
 * ```
 * $data = array(
 * 		'Block' => テストケース1と同じ,
 * 		'Frame' => array('id' => '9999'),
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '2',
 * 			'block_id' => '2',
 * 			'block_key' => 'block_1',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'Edit Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveCaseOnFailureFrameId($data) {
		//テストデータ生成
		$data['Frame']['id'] = '9999';

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->save($data);
	}

/**
 * save()のテスト
 *
 * #### テストケース(Block->save()がエラー)
 * ```
 * $data = array(
 * 		'Block' => テストケース1と同じ,
 * 		'Frame' => array('id' => '9999'),
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '2',
 * 			'block_id' => '2',
 * 			'block_key' => 'block_1',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'Edit Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveCaseOnBlockFailure($data) {
		//テストデータ生成
		$this->_mockForReturnFalse('TestModel', 'Blocks.Block', 'save');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->save($data);
	}

/**
 * save()のテスト
 *
 * #### テストケース(その他のデータが付与されている)
 * ```
 * $data = array(
 * 		'Block' => テストケース1と同じ,
 * 		'Frame' => テストケース1と同じ,
 * 		'TestBlockBehaviorSaveModel' => テストケース1と同じ,
 *		0 => array('aaaaa')
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveCaseWOtherData($data) {
		//テスト実施
		$data[0] = array('aaaaa');
		$result = $this->TestModel->save($data);

		//チェック
		$data['Block']['name'] = $data[$this->TestModel->alias]['name'];
		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);

		$this->assertEquals($data[0], $result[0]);
	}

/**
 * save()のテスト
 *
 * #### テストケース2
 * ```
 * $data = array(
 * 		'Block' => テストケース1と同じ,
 * 		'Frame' => テストケース1と同じ,
 * 		'TestBlockBehaviorSaveModel' => array(
 * 			'id' => '',
 * 			'language_id' => '2',
 * 			'key' => 'key_1',
 * 			'name' => 'New Name'
 * 		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderNew
 * @return void
 */
	public function testSaveCaseWOBlockIdAndKey($data) {
		//テストデータ作成
		unset($data[$this->TestModel->alias]['block_id']);
		unset($data[$this->TestModel->alias]['block_key']);

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$data['Block']['name'] = $data[$this->TestModel->alias]['name'];
		$this->__assertBlock($data, $result);
		$this->__assertTestModel($data, $result);
	}

/**
 * Blockのチェック
 *
 * @param array $data 登録データ
 * @param array $result 結果データ
 * @return void
 */
	private function __assertBlock($data, $result) {
		$alias = 'Block';

		$expected = array(
			'id' => $data[$alias]['id'],
			'key' => $data[$alias]['key'],
			'room_id' => '1',
			'language_id' => '2',
			'name' => $data[$alias]['name'],
			'plugin_key' => 'test_blocks',
		);

		$this->assertDatetime($result[$alias]['modified']);
		$result[$alias] = Hash::remove($result[$alias], 'modified');

		if ($data[$alias]['id'] !== '2') {
			$expected['id'] = '11';

			$this->assertDatetime($result[$alias]['created']);
			$result[$alias] = Hash::remove($result[$alias], 'created');
		}

		$this->assertEquals($expected, $result[$alias]);
	}

/**
 * TestBlockBehaviorSaveModelのチェック
 *
 * @param array $data 登録データ
 * @param array $result 結果データ
 * @return void
 */
	private function __assertTestModel($data, $result) {
		$alias = 'TestBlockBehaviorSaveModel';

		$expected = array(
			'id' => '2',
			'block_id' => Hash::get($result['Block'], 'id', '2'),
			'block_key' => Hash::get($result['Block'], 'key', 'block_1'),
			'language_id' => '2',
			'key' => 'key_1',
			'name' => $data[$alias]['name'],
		);
		$this->assertDatetime($result[$alias]['modified']);
		$result[$alias] = Hash::remove($result[$alias], 'modified');

		if (! $data[$alias]['id']) {
			$expected['id'] = '3';

			$this->assertDatetime($result[$alias]['created']);
			$result[$alias] = Hash::remove($result[$alias], 'created');
		}

		$this->assertEquals($expected, $result[$alias]);
	}

/**
 * TestBlockBehaviorSaveManyModelのチェック
 *
 * @param string $keyPath HashのkeyPath
 * @param array $data 登録データ
 * @param array $result 結果データ
 * @return void
 */
	private function __assertTestModelMany($keyPath, $data, $result) {
		$expected = Hash::get($data, $keyPath);
		$expected = Hash::insert($expected, 'block_id', '2');
		$expected = Hash::insert($expected, 'block_key', 'block_1');

		$this->assertEquals($expected, Hash::get($result, $keyPath));
	}

}
