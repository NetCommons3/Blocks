<?php
/**
 * BlocksControllerPaginatorTest::dataProviderPaginator()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerPaginatorTest::dataProviderPaginator()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerPaginatorTest
 */
class TestSuiteBlocksControllerPaginatorTestDataProviderPaginatorTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlocksControllerPaginatorTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlocksControllerPaginatorTest();
	}

/**
 * dataProviderPaginator()のテスト
 *
 * @return void
 */
	public function testDataProviderPaginator() {
		//テスト実施
		$result = $this->TestSuite->dataProviderPaginator();

		//チェック
		$expected = array(
			array(1, true, false),
			array(3, false, false),
			array(5, false, true),
		);
		$this->assertEquals($expected, $result);
	}

}
