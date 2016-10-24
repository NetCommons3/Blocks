<?php
/**
 * BlocksControllerEditTest::testAdd()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerEditTest::testAdd()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerEditTest
 */
class TestSuiteBlocksControllerEditTestTestAddTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlocksControllerEditTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlocksControllerEditTest();
	}

/**
 * testAdd()のテスト(GETのテスト)
 *
 * @return void
 */
	public function testTestAddGet() {
		//データ生成
		$method = 'get';
		$data = null;
		$validationError = false;

		//テスト実施
		$result = $this->TestSuite->testAdd($method, $data, $validationError);

		//チェック
		$expected = $this->__expectedByGet();
		$this->assertEquals($expected, $result);
	}

/**
 * GETのテストのexpected
 *
 * @return array 期待値データ
 */
	private function __expectedByGet() {
		$expected = array(
			0 => array(
				0 => array(
					'method' => 'assertInput',
					'type' => 'form',
					'name' => null,
					'value' => '/test_blocks/TestSuiteBlocksControllerEditTest/add?frame_id=6'
				),
				1 => array(
					'method' => 'assertInput',
					'type' => 'input',
					'name' => 'data[Frame][id]',
					'value' => '6'
				),
				2 => array(
					'method' => 'assertInput',
					'type' => 'input',
					'name' => 'data[Block][id]',
					'value' => null
				),
				3 => array(
					'method' => 'assertInput',
					'type' => 'input',
					'name' => 'data[Block][room_id]',
					'value' => '2'
				)
			)
		);
		return $expected;
	}

/**
 * testAdd()のテスト(POSTのテスト)
 *
 * @return void
 */
	public function testTestAddPost() {
		//データ生成
		$method = 'post';
		$data = array(
			'TestBlocks' => array(
				'id' => '1',
				'key' => 'test_key',
			),
		);
		$validationError = false;

		//テスト実施
		$result = $this->TestSuite->testAdd($method, $data, $validationError);

		//チェック
		$expected = array(
			0 => array(
				0 => array(
					'method' => 'assertNotEmpty',
					'value' => '/test_blocks/test_suite_blocks_controller_edit_test/index'
				),
			)
		);
		$this->assertEquals($expected, $result);
	}

/**
 * testAdd()のテスト(ValidationErrorのテスト)
 *
 * @return void
 */
	public function testTestAddPostOnValidationError() {
		//データ生成
		$method = 'post';
		$data = array(
			'TestBlocks' => array(
				'id' => '1',
				'key' => 'test_key',
			),
		);
		$validationError = array(
			'field' => 'key',
			'value' => null,
			'message' => 'Validation error message'
		);

		//テスト実施
		$result = $this->TestSuite->testAdd($method, $data, $validationError);

		//チェック
		$expected = $this->__expectedByGet();
		$expected[0][4] = array(
			'method' => 'assertNotEmpty',
			'value' => 'Validation error message'
		);
		$expected[0][5] = array(
			'method' => 'assertTextContains',
			'expected' => 'Validation error message'
		);
		$this->assertEquals($expected, $result);
	}

}
