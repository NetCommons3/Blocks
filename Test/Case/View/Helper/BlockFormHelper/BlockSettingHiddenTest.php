<?php
/**
 * BlockFormHelper::blockSettingHidden()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * BlockFormHelper::blockSettingHidden()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockFormHelper
 */
class BlockFormHelperBlockSettingHiddenTest extends NetCommonsHelperTestCase {

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

		//テストデータ生成
		$viewVars = array();
		$requestData = array(
			'Block' => [
				'key' => 'block_1'
			]
		);
		$params = array();

		//Helperロード
		$this->loadHelper('Blocks.BlockForm', $viewVars, $requestData, $params);
	}

/**
 * blockSettingHidden()のテスト
 *
 * @return void
 */
	public function testBlockSettingHidden() {
		//データ生成
		$inputValue = 'BlockSetting.use_like';
		$useValue = 0;
		Current::write('Plugin.key', 'dummy');
		Current::write('Room.id', '999');

		//テスト実施
		/** @see BlockFormHelper::blockSettingHidden() */
		$result = $this->BlockForm->blockSettingHidden($inputValue, $useValue);

		//チェック
		//debug($result);
		// valueのhiddenはない事
		$this->assertTextNotContains('data[BlockSetting][use_like][value]', $result);
		// valueはセットされているか
		$this->assertTextContains('value="' . Current::read('Plugin.key'), $result);
		$this->assertTextContains('value="' . Current::read('Room.id'), $result);
		$this->assertTextContains('value="block_1"', $result);
	}

/**
 * blockSettingHidden()のテスト - valueのhiddenがある事
 *
 * @return void
 */
	public function testBlockSettingHiddenUseValue() {
		//データ生成
		$inputValue = 'BlockSetting.use_like';
		$useValue = 1;

		//テスト実施
		/** @see BlockFormHelper::blockSettingHidden() */
		$result = $this->BlockForm->blockSettingHidden($inputValue, $useValue);

		//チェック
		//debug($result);
		// valueのhiddenがある事
		$this->assertTextContains('data[BlockSetting][use_like][value]', $result);
	}

}
