<?php
/**
 * BlocksControllerTest::testIndexNoneBlock()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerTest::testIndexNoneBlock()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerTest
 */
class TestSuiteBlocksControllerTestTestIndexNoneBlockTest extends NetCommonsControllerTestCase {

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
 * testIndexNoneBlock()のテスト
 *
 * @return void
 */
	public function testTestIndexNoneBlock() {
		//テスト実施
		$result = $this->TestSuite->testIndexNoneBlock();

		//チェック
		$this->assertEquals(array(array('Blocks.Blocks/not_found')), $result);
	}

}
