<?php
/**
 * BlocksControllerEditTest::testEdit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerEditTest::testEdit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerEditTest
 */
class TestSuiteBlocksControllerEditTestTestEditTest extends NetCommonsControllerTestCase {

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
 * testEdit()のテスト(GETのテスト)
 *
 * @return void
 */
	public function testTestEditGet() {
		//データ生成
		$method = 'get';
		$data = null;
		$validationError = false;

		//テスト実施
		$this->TestSuite->testEdit($method, $data, $validationError);

		//チェック
		$expected = $this->__expectedByGet();
		$this->assertEquals($expected, $this->TestSuite->asserts);
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
					'value' => '/test_blocks/TestSuiteBlocksControllerEditTest/edit/4?frame_id=6'
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
					'value' => '4'
				),
				3 => array(
					'method' => 'assertInput',
					'type' => 'input',
					'name' => 'data[Block][room_id]',
					'value' => '1'
				),
				4 => array(
					'method' => 'assertInput',
					'type' => 'form',
					'name' => null,
					'value' => '/test_blocks/TestSuiteBlocksControllerEditTest/delete/4?frame_id=6'
				),
				5 => array(
					'method' => 'assertInput',
					'type' => 'button',
					'name' => 'delete',
					'value' => null
				)
			)
		);
		return $expected;
	}

/**
 * testEdit()のテスト(POSTのテスト)
 *
 * @return void
 */
	public function testTestEditPost() {
		//データ生成
		$method = 'put';
		$data = array(
			'TestBlocks' => array(
				'id' => '1',
				'key' => 'test_key',
			),
		);
		$validationError = false;

		//テスト実施
		$result = $this->TestSuite->testEdit($method, $data, $validationError);

		//チェック
		$expected = array(
			0 => array(
				0 => array(
					'method' => 'assertNotEmpty',
					'value' => '/test_blocks/test_suite_blocks_controller_edit_test/index'
				),
			)
		);
		$this->assertEquals($expected, $this->TestSuite->asserts);
		$this->assertEquals($data, $result->controller->data);
	}

/**
 * testEdit()のテスト(ValidationErrorのテスト)
 *
 * @return void
 */
	public function testTestEditEditOnValidationError() {
		//データ生成
		$method = 'put';
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
		$this->TestSuite->testEdit($method, $data, $validationError);

		//チェック
		$expected = $this->__expectedByGet();
		$expected[0][6] = array(
			'method' => 'assertNotEmpty',
			'value' => 'Validation error message'
		);
		$expected[0][7] = array(
			'method' => 'assertTextContains',
			'expected' => 'Validation error message'
		);
		$this->assertEquals($expected, $this->TestSuite->asserts);
	}

}
