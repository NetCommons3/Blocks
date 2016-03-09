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
		return $this;
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
