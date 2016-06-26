<?php
/**
 * BlockBehavior::getBlockIndexSettings()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BlockBehavior::getBlockIndexSettings()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\Model\Behavior\BlockBehavior
 */
class BlockBehaviorGetBlockIndexSettingsTest extends NetCommonsModelTestCase {

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
		$this->TestModel = ClassRegistry::init('TestBlocks.TestBlockBehaviorModel');
	}

/**
 * getBlockIndexSettings()テストのDataProvider
 *
 * ### 戻り値
 *  - options Model::find conditions default value
 *
 * @return array データ
 */
	public function dataProvider() {
		//TODO:テストパタンを書く
		$result[0] = array();
		$result[0]['options'] = array();

		return $result;
	}

/**
 * getBlockIndexSettings()のテスト
 *
 * @param array $options Model::find conditions default value
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetBlockIndexSettings($options) {
		//テスト実施
		$result = $this->TestModel->getBlockIndexSettings($options);

		//チェック
		//TODO:Assertを書く
		debug($result);
	}

}
