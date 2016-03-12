<?php
/**
 * BlockFormHelper::displayFrame()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * BlockFormHelper::displayFrame()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockFormHelper
 */
class BlockFormHelperDisplayFrameTest extends NetCommonsHelperTestCase {

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
			'TestBlocks' => array('fieldName' => '2')
		);
		$params = array();

		//Helperロード
		$this->loadHelper('Blocks.BlockForm', $viewVars, $requestData, $params);
	}

/**
 * displayFrame()のテスト
 *
 * @return void
 */
	public function testDisplayFrame() {
		//データ生成
		$fieldName = 'TestBlocks.fieldName';
		$blockId = '2';

		//テスト実施
		$result = $this->BlockForm->displayFrame($fieldName, $blockId);

		//チェック
		$pattern = '<input type="radio" name="data[TestBlocks][fieldName]" ' .
							'id="TestBlocksFieldName2" value="2" checked="checked" ' .
							'onclick="submit()" ng-click="sending=true" ng-disabled="sending"';
		$this->assertRegExp('/' . preg_quote($pattern, '/') . '/', $result);
	}

}
