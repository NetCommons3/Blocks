<?php
/**
 * BlocksControllerEditTest::testDelete()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerEditTest::testDelete()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerEditTest
 */
class TestSuiteBlocksControllerEditTestTestDeleteTest extends NetCommonsControllerTestCase {

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
 * testDelete()のテスト
 *
 * @return void
 */
	public function testTestDelete() {
		//データ生成
		$data = array(
			'TestBlock' => array(
				'id' => '1'
			)
		);

		//テスト実施
		$result = $this->TestSuite->testDelete($data);

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

}
