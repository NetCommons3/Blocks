<?php
/**
 * BlockSettingBehavior::createBlockSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BlockSettingBehavior::createBlockSetting()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockSettingBehavior
 */
class BlockSettingBehaviorCreateBlockSettingTest extends NetCommonsModelTestCase {

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
		$this->TestModel->plugin = 'dummy';
	}

/**
 * createBlockSetting()のテスト
 *
 * @return void
 */
	public function testCreateBlockSetting() {
		Current::write('Room.id', 2);
		Current::write('Room.need_approval', 1);	//ルーム承認する
		Current::write('Block.key', 'block_1');

		//テスト実施
		/** @see BlockSettingBehavior::getBlockSetting() */
		/** @see BlockSettingBehavior::_createBlockSetting() */
		$result = $this->TestModel->getBlockSetting();

		//チェック
		//debug($result);
		//デフォルト値は承認する
		$this->assertEquals('1', $result[$this->TestModel->alias]['use_workflow']);
		$this->assertEquals('1', $result[$this->TestModel->alias]['use_comment_approval']);
	}

/**
 * createBlockSetting()のテスト 縦持ちデータ
 *
 * @return void
 */
	public function testCreateBlockSettingRow() {
		Current::write('Room.id', 2);
		Current::write('Room.need_approval', 1);	//ルーム承認する
		Current::write('Block.key', 'block_1');

		//テスト実施
		/** @see BlockSettingBehavior::createBlockSetting() */
		$result = $this->TestModel->createBlockSetting(null, true);

		//チェック
		//debug($result);
		$this->assertArrayHasKey('field_name', $result['BlockSetting']['use_comment']);
		$this->assertArrayHasKey('value', $result['BlockSetting']['use_comment']);
		//プラグインキー、ルームIDセットされている
		$this->assertEquals($this->TestModel->plugin,
			$result['BlockSetting']['use_comment']['plugin_key']);
		$this->assertEquals(Current::read('Room.id'),
			$result['BlockSetting']['use_comment']['room_id']);
		//デフォルト値は承認する
		$this->assertEquals('1', $result['BlockSetting']['use_workflow']['value']);
		$this->assertEquals('1', $result['BlockSetting']['use_comment_approval']['value']);
		//デフォルト値のプラグインキー、ルームIDセットされている
		$this->assertEquals($this->TestModel->plugin,
			$result['BlockSetting']['use_workflow']['plugin_key']);
		$this->assertEquals(Current::read('Room.id'),
			$result['BlockSetting']['use_workflow']['room_id']);
	}

/**
 * createBlockSetting()のテスト - ルーム承認しない
 *
 * @return void
 */
	public function testCreateBlockSettingNoApproval() {
		Current::write('Room.id', 2);
		Current::write('Room.need_approval', 0);	//ルーム承認しない
		Current::write('Block.key', 'block_1');

		//テスト実施
		/** @see BlockSettingBehavior::createBlockSetting() */
		$result = $this->TestModel->createBlockSetting();

		//チェック
		//debug($result);
		//デフォルト値は承認しない
		$this->assertEquals('0', $result[$this->TestModel->alias]['use_workflow']);
		$this->assertEquals('0', $result[$this->TestModel->alias]['use_comment_approval']);
	}

}
