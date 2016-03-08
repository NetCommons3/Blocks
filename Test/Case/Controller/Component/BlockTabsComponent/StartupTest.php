<?php
/**
 * BlockTabsComponent::startup()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlockTabsComponent::startup()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Controller\Component\BlockTabsComponent
 */
class BlockTabsComponentStartupTest extends NetCommonsControllerTestCase {

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
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * startup()のテスト(Helperにセットする内容を確認する)
 *
 * @return void
 */
	public function testStartup() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestBlockTabsComponentWarning');

		//ログイン
		TestAuthGeneral::login($this);

		//Warningを無視する
		$no = $str = $file = $line = $context = null;
		set_error_handler(function($no, $str, $file, $line, $context) {}, E_USER_WARNING);

		//テスト実行
		$this->_testGetAction('/test_blocks/test_block_tabs_component_warning/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		set_error_handler(null);

		//チェック
		$pattern = '/' . preg_quote('Controller/Component/TestBlockTabsComponent/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertEquals($this->controller->components['Blocks.BlockTabs'], $this->controller->helpers['Blocks.BlockTabs']);
	}

/**
 * startup()のテスト($controller->helpers[] = 'Blocks.BlockTabs'でセットされているものを削除)
 *
 * @return void
 */
	public function testStartupInArray() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestBlockTabsComponentInArrayHelper');

		//ログイン
		TestAuthGeneral::login($this);

		//Warningを無視する
		$no = $str = $file = $line = $context = null;
		set_error_handler(function($no, $str, $file, $line, $context) {}, E_USER_WARNING);

		//テスト実行
		$this->_testGetAction('/test_blocks/test_block_tabs_component_in_array_helper/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		set_error_handler(null);

		//チェック
		$pattern = '/' . preg_quote('Controller/Component/TestBlockTabsComponent/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertFalse(in_array('Blocks.BlockTabs', $this->controller->helpers, true));
		$this->assertEquals($this->controller->components['Blocks.BlockTabs'], $this->controller->helpers['Blocks.BlockTabs']);
	}

/**
 * startup()のテスト(Warningの内容を確認する)
 *
 * @return void
 * @expectedException PHPUnit_Framework_Error_Warning
 * @expectedExceptionMessage Changed to BlockTabsHelper from BlockTabsComponent.
 */
	public function testStartupWarning() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestBlockTabsComponentWarning');

		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction('/test_blocks/test_block_tabs_component_warning/index',
				array('method' => 'assertNotEmpty'), null, 'view');
	}

}
