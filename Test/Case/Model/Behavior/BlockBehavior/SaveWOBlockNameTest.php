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
class BlockBehaviorSaveWOBlockNameTest extends NetCommonsModelTestCase {

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
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockBehaviorSaveModelWOName');
	}

/**
 * DataProvider
 *
 * ### 戻り値
 * ```
 * array(
 * 	'Block' => array('id' => '2', 'key' => 'block_1'),
 * 	'Frame' => array('id' => '6'),
 * 	'TestBlockBehaviorSaveModelWOName' => array(
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
			'TestBlockBehaviorSaveModelWOName' => array(
				'id' => '2', 'block_id' => '2', 'block_key' => 'block_1',
				'language_id' => '2', 'key' => 'key_1', 'name' => 'Edit Name',
			),
		);

		return $results;
	}

/**
 * save()のテスト
 *
 * #### テストケース(setupでname指定なし)
 * ```
 * $data = array(
 *		'Block' => array('id' => '2', 'key' => 'block_1'),
 *		'Frame' => array('id' => '6'),
 *		'TestBlockBehaviorSaveModelWOName' => array(
 *			'id' => '2',
 *			'block_id' => '2',
 *			'block_key' => 'block_1',
 *			'language_id' => '2',
 *			'key' => 'key_1',
 *			'name' => 'Edit Name',
 *		)
 * 	);
 * ```
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveCaseWOBlockName($data) {
		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		$this->assertNotEmpty($result['BlocksLanguage']['name']);
		$this->assertFalse($result['BlocksLanguage']['name'] === $result[$this->TestModel->alias]['name']);

		$data['BlocksLanguage']['name'] = $result['BlocksLanguage']['name'];
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
			'room_id' => '2',
			'plugin_key' => 'test_blocks',
		);
		$this->assertDatetime($result[$alias]['modified']);
		$result[$alias] = Hash::remove($result[$alias], 'modified');
		if ($data[$alias]['id'] !== '2') {
			$expected['id'] = '11';
			$this->assertDatetime($result[$alias]['created']);
			$result[$alias] = Hash::remove($result[$alias], 'created');

			$data['BlocksLanguage']['id'] = '11';
		} else {
			$data['BlocksLanguage']['id'] = '2';
		}
		$this->assertEquals($expected, $result[$alias]);

		$alias = 'BlocksLanguage';
		$expected = array(
			'block_id' => $data['Block']['id'],
			'language_id' => '2',
			'name' => $data[$alias]['name'],
			'id' => $data[$alias]['id'],
			'is_original' => true,
			'is_translation' => false,
		);
		$this->assertDatetime($result[$alias]['modified']);
		$result[$alias] = Hash::remove($result[$alias], 'modified');
		$result[$alias] = Hash::remove($result[$alias], 'created');
		$result[$alias] = Hash::remove($result[$alias], 'modified_user');
		$result[$alias] = Hash::remove($result[$alias], 'created_user');
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
		$alias = 'TestBlockBehaviorSaveModelWOName';

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

		$this->assertEquals($expected, $result[$alias]);
	}

}
