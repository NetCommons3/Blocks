<?php
/**
 * BlockFormHelper::displayEditForm()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksHelperTestCase', 'Blocks.TestSuite');

/**
 * BlockFormHelper::displayEditForm()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockFormHelper
 */
class BlockFormHelperDisplayEditFormTest extends BlocksHelperTestCase {

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
		$resultVars = array();
		$requestData = array();
		$params = array();

		//Helperロード
		$this->loadHelper('Blocks.BlockForm', $resultVars, $requestData, $params);

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Blocks', 'TestBlocks');
	}

/**
 * displayEditForm()のテスト
 *
 * @return void
 */
	public function testDisplayEditForm() {
		//データ生成
		$options = array(
			'model' => 'Block',
			'callback' => 'TestBlocks.test_view_elements_edit_form',
		);

		//テスト実施
		$result = $this->BlockForm->displayEditForm($options);

		//チェック
		$pattern = '<form .*?id="BlockForm" method="post" accept-charset="utf-8">';
		$this->assertRegExp($pattern, $result);

		$this->assertInput('input', 'data[Frame][id]', null, $result);
		$this->assertInput('input', 'data[Block][id]', null, $result);
		$this->assertInput('input', 'data[Block][id]', null, $result);
		$this->assertInput('input', 'data[BlocksLanguage][language_id]', null, $result);
		$this->assertInput('input', 'data[Block][room_id]', null, $result);
		$this->assertInput('input', 'data[Block][plugin_key]', null, $result);

		$pattern = '/' . preg_quote('View/Elements/test_view_elements_edit_form', '/') . '/';
		$this->assertRegExp($pattern, $result);
	}

}
