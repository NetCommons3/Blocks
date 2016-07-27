<?php
/**
 * BlockSettingBehavior::saveBlockSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BlockSettingBehavior::saveBlockSetting()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockSettingBehavior
 */
class BlockSettingBehaviorSaveBlockSettingTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block_setting',
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

		Current::write('Plugin.key', 'dummy');

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Blocks', 'TestBlocks');
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockSettingBehaviorModel');
	}

/**
 * saveBlockSetting()のテスト
 *
 * @return void
 */
	public function testSaveBlockSetting() {
		// テストデータ
		$blockKey = 'block_1';
		Current::write('Room.id', 1);
		Current::write('Block.key', $blockKey);

		$data[$this->TestModel->alies]['use_comment'] = '0';
		$data[$this->TestModel->alies]['use_like'] = '0';
		$data[$this->TestModel->alies]['use_unlike'] = '0';
		$data[$this->TestModel->alies]['auto_play'] = '0';
		$data[$this->TestModel->alies]['total_size'] = '200';
		$this->TestModel->data = $data;

		//テスト実施
		/** @see BlockSettingBehavior::saveBlockSetting() */
		$result = $this->TestModel->saveBlockSetting();
		//チェック
		$this->assertTrue($result);

		$result = $this->TestModel->getBlockSetting($blockKey, 1);
		$checks = array(
			'use_comment',
			'use_like',
			'use_unlike',
			'auto_play',
			'total_size',
		);
		//debug($result);
		foreach ($checks as $check) {
			// 更新した値チェック 横データ
			$this->assertEquals($data[$this->TestModel->alies][$check],
				$result[$this->TestModel->alies][$check]);
			//  縦データ
			$this->assertEquals($data[$this->TestModel->alies][$check],
				$result['BlockSetting'][$check]['value']);
			// 更新日時セットされてるよねチェック
			$this->assertNotNull($result['BlockSetting'][$check]['modified']);
		}
	}

/**
 * saveBlockSetting()の Validate テスト
 *
 * @return void
 */
	public function testSaveBlockSettingValidate() {
		// テストデータ
		Current::write('Room.id', 1);

		$data[$this->TestModel->alies]['use_comment'] = '0';
		$data[$this->TestModel->alies]['use_like'] = '0';
		$data[$this->TestModel->alies]['use_unlike'] = '0';
		$data[$this->TestModel->alies]['auto_play'] = '0';
		$data[$this->TestModel->alies]['total_size'] = '200';
		$data[$this->TestModel->alies]['approval_type'] = '1';	// 登録不要なデータ
		$this->TestModel->data = $data;
		//debug($result);

		//テスト実施
		/** @see BlockSettingBehavior::validateBlockSetting() */
		$this->TestModel->validateBlockSetting();

		// チェック
		//var_dump($this->TestModel->validator()->getField());
		$checks = array(
			'use_comment',
			'use_like',
			'use_unlike',
			'auto_play',
			'total_size',
		);
		foreach ($checks as $check) {
			// 追加validate条件セットされてるよねチェック
			$this->assertArrayHasKey($check, $this->TestModel->validator()->getField());
		}
	}

/**
 * saveBlockSetting()の例外テスト
 *
 * @return void
 */
	public function testSaveBlockSettingOnExeptionError() {
		//テストデータ
		$this->_mockForReturnFalse('TestModel', 'Blocks.BlockSetting', 'saveMany');

		$blockKey = 'block_1';
		Current::write('Room.id', 1);

		$result = $this->TestModel->getBlockSetting($blockKey);
		$this->TestModel->data = $result;
		//debug($result);

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		/** @see BlockSettingBehavior::saveBlockSetting() */
		$this->TestModel->saveBlockSetting();
	}

}
