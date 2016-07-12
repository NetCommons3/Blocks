<?php
/**
 * BlockSettingBehavior::find()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestBlockSettingBehaviorFindModelFixture', 'Blocks.Test/Fixture');

/**
 * BlockSettingBehavior::find()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockSettingBehavior
 */
class BlockSettingBehaviorFindTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block_setting',
		'plugin.blocks.test_block_setting_behavior_find_model',
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
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockSettingBehaviorFindModel');
	}

/**
 * find()のテスト
 *
 * @return void
 */
	public function testFind() {
		//テストデータ
		$type = 'first';
		$query = array(
			'conditions' => array($this->TestModel->alias . '.id' => 1)
		);
		Current::write('Room.id', '1');
		Current::write('Plugin.key', 'dummy');

		//テスト実施
		/** @see BlockSettingBehavior::afterFind() */
		$result = $this->TestModel->find($type, $query);

		//チェック
		//debug($result);
		// BlockSettingが取得できた
		$this->assertArrayHasKey('BlockSetting', $result);
	}

/**
 * find()の空テスト
 *
 * @return void
 */
	public function testFindEmpty() {
		//テストデータ
		$type = 'first';
		$query = array(
			'conditions' => array($this->TestModel->alias . '.id' => 999)
		);
		Current::write('Room.id', '1');
		Current::write('Plugin.key', 'dummy');

		//テスト実施
		/** @see BlockSettingBehavior::afterFind() */
		$result = $this->TestModel->find($type, $query);

		//チェック
		//debug($result);
		$this->assertEmpty($result);
	}

}
