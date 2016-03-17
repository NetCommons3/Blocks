<?php
/**
 * View/Elements/public_typeのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/public_typeのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Elements\PublicType
 */
class BlocksViewElementsPublicTypeTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestBlocks.TestViewElementsPublicType');
	}

/**
 * View/Elements/public_typeのテスト
 *
 * @return void
 */
	public function testPublicType() {
		//テスト実行
		$this->_testGetAction('/test_blocks/test_view_elements_public_type/public_type/6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/public_type', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '<input type="radio" name="data\[Block\]\[public_type\]" id="BlockPublicType0" value="0"';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<input type="radio" name="data\[Block\]\[public_type\]" id="BlockPublicType1" value="1"';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<input type="radio" name="data\[Block\]\[public_type\]" id="BlockPublicType2" value="2" checked="checked"';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		// DOMDocument使ってViewのテスト
		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->loadHtml($this->view);
		$xPath = new DOMXPath($dom);

		$inputPublishStart = $xPath->query('//input[@id="BlockPublishStart"]')->item(0);

		$this->assertEquals('yyyy-mm-dd hh:nn', $inputPublishStart->getAttribute('placeholder'));
		$this->assertContains('=\'2014-01-01 09:00:00\'', $inputPublishStart->getAttribute('ng-init'));
		$this->assertEquals('text', $inputPublishStart->getAttribute('type'));
		$this->assertEquals('2014-01-01 09:00:00', $inputPublishStart->getAttribute('value'));
		$this->assertEquals('data[Block][publish_start]', $inputPublishStart->getAttribute('name'));

		$inputPublishEnd = $xPath->query('//input[@id="BlockPublishEnd"]')->item(0);

		$this->assertEquals('yyyy-mm-dd hh:nn', $inputPublishEnd->getAttribute('placeholder'));
		$this->assertContains('=\'2035-12-31 09:00:00\'', $inputPublishEnd->getAttribute('ng-init'));
		$this->assertEquals('text', $inputPublishEnd->getAttribute('type'));
		$this->assertEquals('2035-12-31 09:00:00', $inputPublishEnd->getAttribute('value'));
		$this->assertEquals('data[Block][publish_end]', $inputPublishEnd->getAttribute('name'));

		//$pattern = '<input name="data\[Block\]\[publish_start\]".*?' .
		//				'placeholder="' . preg_quote('yyyy-mm-dd hh:nn', '/') . '".*?' .
		//				'ng-init=".*?' . preg_quote('=&#039;2014-01-01 09:00:00&#039;', '/') . '" ' .
		//				'type="text" value="' . preg_quote('2014-01-01 09:00:00', '/') . '"';
		//$this->assertRegExp('/' . $pattern . '/', $this->view);
		//
		//$pattern = '<input name="data\[Block\]\[publish_end\]".*?' .
		//				'placeholder="' . preg_quote('yyyy-mm-dd hh:nn', '/') . '".*?' .
		//				'ng-init=".*?' . preg_quote('=&#039;2035-12-31 09:00:00&#039;', '/') . '" ' .
		//				'type="text" value="' . preg_quote('2035-12-31 09:00:00', '/') . '"'; //←これ正しい？？
		//$this->assertRegExp('/' . $pattern . '/', $this->view);
	}

}
