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
	public $fixtures = array();

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
 * saveBlockSetting()テストのDataProvider
 *
 * ### 戻り値
 *  - data received post data
 *  - isBlockSetting ブロック設定画面か
 *
 * @return array データ
 */
	public function dataProvider() {
		//TODO:テストパタンを書く
		$result[0] = array();
		$result[0]['data'] = null;
		$result[0]['isBlockSetting'] = null;

		return $result;
	}

/**
 * saveBlockSetting()のテスト
 *
 * @param array $data received post data
 * @param bool $isBlockSetting ブロック設定画面か
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveBlockSetting($data, $isBlockSetting) {
		//テスト実施
		$result = $this->TestModel->saveBlockSetting($data, $isBlockSetting);

		//チェック
		//TODO:Assertを書く
		debug($result);
	}

}
