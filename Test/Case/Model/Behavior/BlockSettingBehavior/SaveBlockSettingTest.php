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
		//$isRow = 0;
		//$roomId = 1;
		$blockKey = 'block_1';
		Current::write('Plugin.key', 'dummy');
		Current::write('Room.id', 1);

		$result = $this->TestModel->getBlockSetting($blockKey);
		//debug($result);
		$result['BlockSetting']['use_comment']['value'] = '0';
		$result['BlockSetting']['use_like']['value'] = '0';
		$result['BlockSetting']['use_unlike']['value'] = '0';
		$result['BlockSetting']['auto_play']['value'] = '0';
		$result['BlockSetting']['total_size']['value'] = '200';
		$data = $result;
		$this->TestModel->data = $data;
		//debug($result);

		//テスト実施
		/** @see BlockSettingBehavior::validateBlockSetting() */
		$result = $this->TestModel->validateBlockSetting();
		//チェック
		//debug($this->TestModel->validationErrors);
		$this->assertTrue($result);

		//テスト実施
		/** @see BlockSettingBehavior::saveBlockSetting() */
		$result = $this->TestModel->saveBlockSetting();
		//チェック
		$this->assertTrue($result);

		$result = $this->TestModel->getBlockSetting($blockKey);
		$checks = array(
			'use_comment',
			'use_like',
			'use_unlike',
			'auto_play',
			'total_size',
		);
		//debug($result);
		foreach ($checks as $check) {
			// 更新した値チェック
			$this->assertEquals($data['BlockSetting'][$check]['value'],
				$result['BlockSetting'][$check]['value']);
			// 更新日時セットされてるよねチェック
			$this->assertNotNull($result['BlockSetting'][$check]['modified']);
		}
	}

/**
 * saveBlockSetting()の Validate Error テスト
 *
 * @return void
 */
	public function testSaveBlockSettingValidateError() {
		// テストデータ
		$blockKey = 'block_1';
		Current::write('Plugin.key', 'dummy');
		Current::write('Room.id', 1);

		$result = $this->TestModel->getBlockSetting($blockKey);
		//debug($result);
		$result['BlockSetting']['use_comment']['value'] = '0';
		$result['BlockSetting']['use_like']['value'] = '0';
		$result['BlockSetting']['use_unlike']['value'] = '0';
		$result['BlockSetting']['auto_play']['value'] = '2'; // 入力値不正エラー
		$result['BlockSetting']['total_size']['value'] = 'xxx';	// 入力値不正エラー
		$result['BlockSetting']['approval_type'] = '1';	// 登録不要なデータ
		$data = $result;
		$this->TestModel->data = $data;
		//debug($result);

		//テスト実施
		/** @see BlockSettingBehavior::validateBlockSetting() */
		$result = $this->TestModel->validateBlockSetting();

		// チェック
		//debug($this->TestModel->validationErrors);
		$this->assertFalse($result);
	}

}
