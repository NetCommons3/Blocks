<?php
/**
 * BlockSettingBehavior::isExsistBlockSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BlockSettingBehavior::isExsistBlockSetting()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockSettingBehavior
 */
class BlockSettingBehaviorIsExsistBlockSettingTest extends NetCommonsModelTestCase {

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
 * isExsistBlockSetting()のテスト
 *
 * @return void
 */
	public function testIsExsistBlockSetting() {
		Current::write('Room.id', 1);
		Current::write('Block.key', 'block_1');

		//テスト実施
		/** @see BlockSettingBehavior::isExsistBlockSetting() */
		$result = $this->TestModel->isExsistBlockSetting();

		//チェック
		//debug($result);
		// データあり
		$this->assertTrue($result);
	}

/**
 * isExsistBlockSetting()のテスト - データなし
 *
 * @return void
 */
	public function testIsExsistBlockSettingEmpty() {
		Current::write('Room.id', 1);
		Current::write('Block.key', 'block_999'); // 該当なしキー

		//テスト実施
		/** @see BlockSettingBehavior::isExsistBlockSetting() */
		$result = $this->TestModel->isExsistBlockSetting();

		//チェック
		//debug($result);
		// データなし
		$this->assertFalse($result);
	}

}
