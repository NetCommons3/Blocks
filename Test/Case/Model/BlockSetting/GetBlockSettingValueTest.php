<?php
/**
 * BlockSetting::getBlockSettingValue()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * BlockSetting::getBlockSettingValue()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\Model\BlockSetting
 */
class BlockSettingGetBlockSettingValueTest extends NetCommonsGetTest {

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
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'BlockSetting';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getBlockSettingValue';

/**
 * testGetBlockSettingValue()のテスト
 *
 * @return void
 * @see BlockSetting::getBlockSettingValue
 */
	public function testGetBlockSettingValue() {
		//データ生成
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		Current::write('Plugin.key', 'dummy');
		Current::write('Block.key', 'block_1');
		$fieldName = 'use_workflow';

		//テスト実施
		$result = $this->$model->$methodName($fieldName);

		//チェック
		//debug($result);
		$this->assertEquals('0', $result);
	}

/**
 * testGetBlockSettingValue()のテスト - 空
 *
 * @return void
 * @see BlockSetting::getBlockSettingValue
 */
	public function testGetBlockSettingValueEmpty() {
		//データ生成
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		Current::write('Plugin.key', 'dummy');
		Current::write('Block.key', 'block_xxx');   //データなし条件
		$fieldName = 'use_workflow';

		//テスト実施
		$result = $this->$model->$methodName($fieldName);

		//チェック
		//debug($result);
		$this->assertEquals(null, $result);
	}

}
