<?php
/**
 * BlocksControllerTest::testIndex()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerTest::testIndex()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerTest
 */
class TestSuiteBlocksControllerTestTestIndexTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlocksControllerTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlocksControllerTest();
	}

/**
 * testIndex()のテスト
 *
 * @return void
 */
	public function testTestIndex() {
		//テスト実施
		$result = $this->TestSuite->testIndex();

		//チェック
		$expected = array(
			0 => array(
				0 => '/<a href=".*?\/test_blocks\/add\?frame_id\=6.*?".*?>/',
				1 => '/<a href=".*?\/test_blocks\/edit\/2\?frame_id\=6.*?".*?>/'
			),
			1 => array(
				0 => array(
					0 => 'input',
					1 => 'data[Frame][block_id]',
					2 => null
				)
			)
		);
		$this->assertEquals($expected, $result);
	}

}
