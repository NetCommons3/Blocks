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
class BlocksViewElementsFormHiddenTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestBlocks.TestViewElementsFormHidden');
	}

/**
 * View/Elements/form_hiddenのテスト
 *
 * @return void
 */
	public function testFormHidden() {
		//テスト実行
		$this->_testGetAction('/test_blocks/test_view_elements_form_hidden/form_hidden',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/form_hidden', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('input', 'data[Frame][id]', '6', $this->view);
		$this->assertInput('input', 'data[Block][id]', '2', $this->view);
		$this->assertInput('input', 'data[Block][key]', 'block_1', $this->view);
		$this->assertInput('input', 'data[Block][language_id]', '2', $this->view);
		$this->assertInput('input', 'data[Block][room_id]', '2', $this->view);
		$this->assertInput('input', 'data[Block][plugin_key]', 'test_blocks', $this->view);
	}

}
