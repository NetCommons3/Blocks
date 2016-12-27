<?php
/**
 * BlockFormHelper::displayDeleteForm()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksHelperTestCase', 'Blocks.TestSuite');

/**
 * BlockFormHelper::displayDeleteForm()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockFormHelper
 */
class BlockFormHelperDisplayDeleteFormTest extends BlocksHelperTestCase {

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
	}

/**
 * displayDeleteForm()のeditアクション時のテスト
 *
 * @return void
 */
	public function testByEditAction() {
		//テストデータ生成
		$resultVars = array();
		$requestData = array();
		$params = array(
			'action' => 'edit'
		);

		//Helperロード
		$this->loadHelper('Blocks.BlockForm', $resultVars, $requestData, $params);

		//データ生成
		$options = array(
			'callback' => 'TestBlocks.test_view_elements_delete_form',
		);

		//テスト実施
		$result = $this->BlockForm->displayDeleteForm($options);

		//チェック
		$pattern = '<form action="\/delete" .*?id="BlockDeleteEditForm" method="post" accept-charset="utf-8">';
		$this->assertRegExp($pattern, $result);

		$this->assertInput('input', '_method', 'DELETE', $result);

		$pattern = '/' . preg_quote('View/Elements/test_view_elements_delete_form', '/') . '/';
		$this->assertRegExp($pattern, $result);
	}

/**
 * displayDeleteForm()のeditアクション時のテスト
 *
 * @return void
 */
	public function testUrlByEditAction() {
		//テストデータ生成
		$resultVars = array();
		$requestData = array();
		$params = array(
			'action' => 'edit'
		);

		//Helperロード
		$this->loadHelper('Blocks.BlockForm', $resultVars, $requestData, $params);

		//データ生成
		$options = array(
			'url' => '/test_blocks',
			'callback' => 'TestBlocks.test_view_elements_delete_form',
		);

		//テスト実施
		$result = $this->BlockForm->displayDeleteForm($options);

		//チェック
		$pattern = '<form action="\/test_blocks" .*?id="BlockDeleteEditForm" method="post" accept-charset="utf-8">';
		$this->assertRegExp($pattern, $result);

		$this->assertInput('input', '_method', 'DELETE', $result);

		$pattern = '/' . preg_quote('View/Elements/test_view_elements_delete_form', '/') . '/';
		$this->assertRegExp($pattern, $result);
	}

/**
 * displayDeleteForm()のaddアクション時のテスト
 *
 * @return void
 */
	public function testByAddAction() {
		//テストデータ生成
		$resultVars = array();
		$requestData = array();
		$params = array(
			'action' => 'add'
		);

		//Helperロード
		$this->loadHelper('Blocks.BlockForm', $resultVars, $requestData, $params);

		//データ生成
		$options = array(
			'callback' => 'TestBlocks.test_view_elements_delete_form',
		);

		//テスト実施
		$result = $this->BlockForm->displayDeleteForm($options);

		//チェック
		$this->assertEmpty($result);
	}

}
