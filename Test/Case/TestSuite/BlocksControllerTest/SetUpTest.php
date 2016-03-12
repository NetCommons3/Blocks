<?php
/**
 * BlocksControllerTest::setUp()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerTest::setUp()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerTest
 */
class TestSuiteBlocksControllerTestSetUpTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlocksControllerSetUpTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlocksControllerSetUpTest();
	}

/**
 * setUp()のテスト
 *
 * @return void
 */
	public function testSetUp() {
		//テスト実施
		$result = $this->TestSuite->setUp();

		//チェック
		$this->assertEquals(array('test_block_blocks', 'test_block_blocks'), $result);
	}

}
