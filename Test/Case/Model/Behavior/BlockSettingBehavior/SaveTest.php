<?php
/**
 * BlockSettingBehavior::save()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestBlockSettingBehaviorSaveModelFixture', 'Blocks.Test/Fixture');

/**
 * BlockSettingBehavior::save()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockSettingBehavior
 */
class BlockSettingBehaviorSaveTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block_setting',
		'plugin.blocks.test_block_setting_behavior_save_model',
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
		/** @see TestBlockSettingBehaviorSaveModel */
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockSettingBehaviorSaveModel');
		$this->TestModel->plugin = 'dummy';
	}

/**
 * save()のテスト
 * USE_WORKFLOWのみの利用を想定したテスト @see TestBlockSettingBehaviorSaveModel
 *
 * @return void
 */
	public function testSave() {
		//テストデータ
		$data = array(
			'TestBlockSettingBehaviorSaveModel' => (new TestBlockSettingBehaviorSaveModelFixture())->records[0],
		);

		$blockKey = 'block_1';
		Current::write('Room.id', '2');
		Current::write('Room.need_approval', 0);	//ルーム承認しない

		$result = $this->TestModel->getBlockSetting($blockKey);
		//debug($result);
		$result[$this->TestModel->alias]['use_like'] = '0';
		$result[$this->TestModel->alias]['use_unlike'] = '0';
		$result[$this->TestModel->alias]['auto_play'] = '0';
		$result[$this->TestModel->alias]['total_size'] = '200';
		$data = Hash::merge($data, $result);
		//$this->TestModel->data = $data;

		//テスト実施
		$result = $this->TestModel->save($data);

		//チェック
		//debug($result);
		$checks = array(
			//'use_comment',
			'use_like',
			'use_unlike',
			'auto_play',
			'total_size',
		);
		foreach ($checks as $check) {
			// 更新した値チェック
			$this->assertEquals($data[$this->TestModel->alias][$check],
				$result[$this->TestModel->alias][$check]);
		}
	}

}
