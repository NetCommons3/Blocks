<?php
/**
 * BlockSettingBehavior::getBlockSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BlockSettingBehavior::getBlockSetting()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockSettingBehavior
 */
class BlockSettingBehaviorGetBlockSettingTest extends NetCommonsModelTestCase {

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
 * getBlockSetting()のテスト
 *
 * @return void
 */
	public function testGetBlockSetting() {
		Current::write('Plugin.key', 'dummy');
		Current::write('Room.id', 1);
		Current::write('Block.key', 'block_1');

		//テスト実施
		/** @see BlockSettingBehavior::getBlockSetting() */
		$result = $this->TestModel->getBlockSetting();

		//チェック
		//debug($result);
		// データあり(縦持ち)
		$this->assertArrayHasKey('use_like', $result['BlockSetting']);
		// 承認系データあり
		$this->assertEquals('0', $result['BlockSetting']['use_workflow']['value']);
		$this->assertEquals('1', $result['BlockSetting']['use_comment_approval']['value']);
		// データあり(横持ち)
		$this->assertArrayHasKey('use_like', $result[$this->TestModel->alias]);
	}

/**
 * getBlockSetting()のテスト - データあり、しかしuse_workflowのデータがないパターン
 *
 * @return void
 */
	public function testGetBlockSettingNoUseWorkFlowData() {
		Current::write('Plugin.key', 'dummy');
		Current::write('Room.id', 2);	// use_workflowのデータがないパターン
		Current::write('Block.key', 'block_2');	// use_workflowのデータがないパターン

		//テスト実施
		/** @see BlockSettingBehavior::getBlockSetting() */
		$result = $this->TestModel->getBlockSetting();

		//チェック
		debug($result);
		// データあり(縦持ち)
		$this->assertArrayHasKey('use_like', $result['BlockSetting']);
		// 承認系データあり
		$this->assertEquals('0', $result['BlockSetting']['use_workflow']['value']);
		$this->assertEquals('0', $result['BlockSetting']['use_comment_approval']['value']);
		// データあり(横持ち)
		$this->assertArrayHasKey('use_like', $result[$this->TestModel->alias]);
	}

/**
 * getBlockSetting()のテスト - 空
 *
 * @return void
 */
	public function testGetBlockSettingEmpty() {
		$blockKey = 'block_999';	// データがないブロックID
		Current::write('Plugin.key', 'dummy');
		Current::write('Room.id', 1);

		//テスト実施
		$result = $this->TestModel->getBlockSetting($blockKey);

		//チェック
		//debug($result);
		// データなし
		$this->assertEmpty($result);
	}

}
