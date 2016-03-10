<?php
/**
 * BlocksControllerPaginatorTest::testIndexPaginator()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerPaginatorTest::testIndexPaginator()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerPaginatorTest
 */
class TestSuiteBlocksControllerPaginatorTestTestIndexPaginatorTest extends NetCommonsControllerTestCase {

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
 * testIndexPaginator()のテスト用DataProvider
 *
 * ### 戻り値
 *  - page ページ番号
 *  - isFirst 最初のページかどうか
 *  - isLast 最後のページかどうか
 *  - expected 期待値
 *
 * @return mixed テスト結果
 */
	public function dataProvider() {
		return array(
			array('page' => '1', 'isFirst' => true, 'isLast' => false, 'expected' => array(
				0 => array(
					0 => '/<li><a.*?rel="first".*?<\/a><\/li>/',
				),
				1 => array(
					0 => '/\<ul class\="pagination"\>/',
					1 => '/<li class="active"><a>1<\/a><\/li>/',
					2 => '/<li><a.*?rel="last".*?<\/a><\/li>/'
				)
			)),
			array('page' => '3', 'isFirst' => false, 'isLast' => false, 'expected' => array(
				0 => array(),
				1 => array(
					0 => '/\<ul class\="pagination"\>/',
					1 => '/<li><a.*?rel="first".*?<\/a><\/li>/',
					2 => '/<li class="active"><a>3<\/a><\/li>/',
					3 => '/<li><a.*?rel="last".*?<\/a><\/li>/'
				)
			)),
			array('page' => '5', 'isFirst' => false, 'isLast' => true, 'expected' => array(
				0 => array(
					0=> '/<li><a.*?rel="last".*?<\/a><\/li>/'
				),
				1 => array(
					0 => '/\<ul class\="pagination"\>/',
					1 => '/<li><a.*?rel="first".*?<\/a><\/li>/',
					2 => '/<li class="active"><a>5<\/a><\/li>/',
				)
			)),
		);
	}

/**
 * testIndexPaginator()のテスト
 *
 * @param int $page ページ番号
 * @param bool $isFirst 最初のページかどうか
 * @param bool $isLast 最後のページかどうか
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testTestIndexPaginator($page, $isFirst, $isLast, $expected) {
		//テスト実施
		$result = $this->TestSuite->testIndexPaginator($page, $isFirst, $isLast);

		//チェック
		$this->assertEquals($expected, $result);
	}

}
