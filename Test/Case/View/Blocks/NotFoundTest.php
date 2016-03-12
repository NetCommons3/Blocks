<?php
/**
 * View/Elements/form_hiddenのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/form_hiddenのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Elements\FormHidden
 */
class BlocksViewBlocksNotFoundTest extends NetCommonsControllerTestCase {

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
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestViewBlocksNotFound');
	}

/**
 * View/Blocks/form_hiddenのテスト
 *
 * @return void
 */
	public function testNotFound() {
		//テスト実行
		$this->_testGetAction('/test_blocks/test_view_blocks_not_found/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertTextContains('/test_blocks/test_view_blocks_not_found/add', $this->view);
		$this->assertTextContains(__d('net_commons', 'Not found.'), $this->view);
	}

}
