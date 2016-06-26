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
	}

	///**
	// * createBlockSetting()テストのDataProvider
	// *
	// * ### 戻り値
	// *
	// * @return array データ
	// */
	//	public function dataProvider() {
	//		$result[0] = array();
	//
	//		return $result;
	//	}
	//
	//  * @dataProvider dataProvider

/**
 * createBlockSetting()のテスト
 *
 * @return void
 */
	public function testCreateBlockSetting() {
		Current::write('Plugin.key', 'dummy');

		//テスト実施
		$result = $this->TestModel->createBlockSetting();

		//チェック
		debug($result);
	}

}
