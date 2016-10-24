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
		$this->TestModel->plugin = 'dummy';
	}

/**
 * getBlockSetting()のテスト
 *
 * @return void
 */
	public function testGetBlockSetting() {
		Current::write('Room.id', '2');
		Current::write('Block.key', 'block_1');

		//テスト実施
		/** @see BlockSettingBehavior::getBlockSetting() */
		$result = $this->TestModel->getBlockSetting();

		//チェック
		//debug($result);
		// データあり(横持ち)
		$this->assertArrayHasKey('use_like', $result[$this->TestModel->alias]);
		// 承認系データあり
		$this->assertEquals('0', $result[$this->TestModel->alias]['use_workflow']);
		$this->assertEquals('1', $result[$this->TestModel->alias]['use_comment_approval']);
	}

/**
 * getBlockSetting()のテスト - データあり、しかしuse_workflowのデータがないパターン
 *
 * @return void
 */
	public function testGetBlockSettingNoUseWorkFlowData() {
		Current::write('Room.id', '3');	// use_workflowのデータがないパターン
		Current::write('Block.key', 'block_2');	// use_workflowのデータがないパターン

		//テスト実施
		/** @see BlockSettingBehavior::getBlockSetting() */
		$result = $this->TestModel->getBlockSetting();

		//チェック
		//debug($result);
		// データあり(横持ち)
		$this->assertArrayHasKey('use_like', $result[$this->TestModel->alias]);
		// 承認系データあり
		$this->assertEquals('0', $result[$this->TestModel->alias]['use_workflow']);
		$this->assertEquals('0', $result[$this->TestModel->alias]['use_comment_approval']);
	}

/**
 * getBlockSetting()のテスト - 空
 *
 * @return void
 */
	public function testGetBlockSettingEmpty() {
		$blockKey = 'block_999';	// データがないブロックID
		Current::write('Room.id', '2');

		//テスト実施
		$result = $this->TestModel->getBlockSetting($blockKey);

		//チェック
		//debug($result);
		// 検索データなし->新規作成データあり
		$this->assertNotEmpty($result);
	}

}
