<?php
/**
 * BlocksControllerTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksControllerTest', 'Blocks.TestSuite');

/**
 * BlocksControllerTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\TestSuite
 */
class TestSuiteBlocksControllerTest extends BlocksControllerTest {

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
	protected $_controller = 'TestSuiteBlocksControllerTest';

/**
 * assertRegExp()チェック用配列
 *
 * @var string
 */
	protected static $_assertRegExp = array();

/**
 * assertTextEquals()チェック用配列
 *
 * @var string
 */
	protected $_assertTextEquals = array();

/**
 * assertInput()チェック用配列
 *
 * @var string
 */
	protected $_assertInput = array();

/**
 * $this->assertRegExp()のオーバライド
 * ※$this->assertRegExp()のチェック用メソッド
 *
 * @param string $pattern パターン
 * @param string $string 文字列
 * @param string $message メッセージ
 * @return void
 */
	public static function assertRegExp($pattern, $string, $message = '') {
		self::$_assertRegExp[] = $pattern;
	}

/**
 * $this->assertTextEquals()のオーバライド
 * ※$this->assertTextEquals()のチェック用メソッド
 *
 * @param string $expected 期待値
 * @param string $result 結果
 * @param string $message メッセージ
 * @return void
 */
	public function assertTextEquals($expected, $result, $message = '') {
		$this->_assertTextEquals[] = $expected;
	}

/**
 * $this->assertInput()のオーバライド
 * ※$this->assertInput()のチェック用メソッド
 *
 * @param string $tagType タグタイプ(input or textearea or button)
 * @param string $name inputタグのname属性
 * @param string $value inputタグのvalue値
 * @param string $result Result data
 * @param string $message メッセージ
 * @return void
 */
	public function assertInput($tagType, $name, $value, $result, $message = null) {
		$this->_assertInput[] = array($tagType, $name, $value);
	}

/**
 * setUp method
 *
 * @return mixed テスト結果
 */
	public function setUp() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerTest');
		parent::setUp();
	}

/**
 * ロールチェックDataProvider
 *
 * ### 戻り値
 *  - role: ロール
 *  - isException: Exceptionの有無
 *
 * @return mixed テスト結果
 */
	public function dataProviderRoleAccess() {
		return parent::dataProviderRoleAccess();
	}

/**
 * index()のテスト
 *
 * @return mixed テスト結果
 */
	public function testIndex() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerTest');
		parent::testIndex();

		$assertRegExp = self::$_assertRegExp;
		$assertInput = $this->_assertInput;
		$result = array($assertRegExp, $assertInput);

		self::$_assertRegExp = array();
		$this->_assertInput = array();

		return $result;
	}

/**
 * index()のブロックなしテスト
 *
 * @return mixed テスト結果
 */
	public function testIndexNoneBlock() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerTest');
		parent::testIndexNoneBlock();

		$assertTextEquals = $this->_assertTextEquals;
		$result = array($assertTextEquals);

		$this->_assertTextEquals = array();

		return $result;
	}

/**
 * index()のアクセス許可テスト
 *
 * @param string $role ロール名
 * @param bool $isException Exceptionの有無
 * @dataProvider dataProviderRoleAccess
 * @return mixed テスト結果
 */
	public function testAccessPermission($role, $isException) {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerTest');
		parent::testAccessPermission($role, $isException);
		return $this;
	}

/**
 * index()のアクセス許可テスト
 *
 * @param string $role ロール名
 * @param bool $isException Exceptionの有無
 * @dataProvider dataProviderRoleAccess
 * @return mixed テスト結果
 */
	public function testAccessPermissionError($role, $isException) {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerTestError');
		parent::testAccessPermission($role, $isException);
		return $this;
	}

}
