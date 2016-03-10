<?php
/**
 * BlocksControllerPaginatorTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksControllerPaginatorTest', 'Blocks.TestSuite');

/**
 * BlocksControllerPaginatorTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\TestSuite
 */
class TestSuiteBlocksControllerPaginatorTest extends BlocksControllerPaginatorTest {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'test_blocks';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'TestSuiteBlocksControllerPaginatorTest';

/**
 * assertNotRegExp()チェック用配列
 *
 * @var string
 */
	public static $assertNotRegExp = array();

/**
 * assertRegExp()チェック用配列
 *
 * @var string
 */
	public static $assertRegExp = array();

/**
 * $this->assertNotRegExp()のオーバライド
 * ※$this->assertNotRegExp()のチェック用メソッド
 *
 * @param string $parttern パターン
 * @param string $string 文字列
 * @param string $message メッセージ
 * @return void
 */
	public static function assertNotRegExp($pattern, $string, $message = '') {
		self::$assertNotRegExp[] = $pattern;
	}

/**
 * $this->assertRegExp()のオーバライド
 * ※$this->assertRegExp()のチェック用メソッド
 *
 * @param string $parttern パターン
 * @param string $string 文字列
 * @param string $message メッセージ
 * @return void
 */
	public static function assertRegExp($pattern, $string, $message = '') {
		self::$assertRegExp[] = $pattern;
	}

/**
 * setUp method
 *
 * @return mixed テスト結果
 */
	public function setUp() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerPaginatorTest');
		parent::setUp();
	}

/**
 * ページネーションDataProvider
 *
 * ### 戻り値
 *  - page: ページ番号
 *  - isFirst: 最初のページかどうか
 *  - isLast: 最後のページかどうか
 *
 * @return mixed テスト結果
 */
	public function dataProviderPaginator() {
		return parent::dataProviderPaginator();
	}

/**
 * index()のページネーションテスト
 *
 * @param int $page ページ番号
 * @param bool $isFirst 最初のページかどうか
 * @param bool $isLast 最後のページかどうか
 * @dataProvider dataProviderPaginator
 * @return mixed テスト結果
 */
	public function testIndexPaginator($page, $isFirst, $isLast) {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerPaginatorTest');
		parent::testIndexPaginator($page, $isFirst, $isLast);

		$assertNotRegExp = self::$assertNotRegExp;
		$assertRegExp = self::$assertRegExp;
		$result = array($assertNotRegExp, $assertRegExp);

		self::$assertNotRegExp = array();
		self::$assertRegExp = array();

		return $result;
	}

}
