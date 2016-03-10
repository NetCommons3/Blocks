<?php
/**
 * BlocksControllerEditTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksControllerEditTest', 'Blocks.TestSuite');

/**
 * BlocksControllerEditTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\TestSuite
 */
class TestSuiteBlocksControllerEditTest extends BlocksControllerEditTest {

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
	protected $_controller = 'TestSuiteBlocksControllerEditTest';

/**
 * $this->asserts()のチェック用メソッド
 *
 * @param array $asserts テストAssert
 * @param string $result Result data
 * @return void
 */
	public function asserts($asserts, $result) {
		$path = '/test_blocks/test_suite_blocks_controller_edit_test/index';
		if (substr(Hash::get($asserts[0], 'value'), -1 * strlen($path)) === $path) {
			$asserts[0] = Hash::insert($asserts[0], 'value', $path);
		}
		$this->asserts[] = $asserts;
	}

/**
 * setUp method
 *
 * @return mixed テスト結果
 */
	public function setUp() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerEditTest');
		parent::setUp();
	}

/**
 * ロールチェックdataProvider
 *
 * ### 戻り値
 *  - action: アクション名
 *  - method: リクエストメソッド（get or post or put）
 *  - expected: 期待するviewファイル
 *  - role: ロール名
 *  - exception: Exception
 *
 * @return mixed テスト結果
 */
	public function dataProviderRoleAccess() {
		return parent::dataProviderRoleAccess();
	}

/**
 * アクセス許可テスト
 *
 * @param string $action アクション名
 * @param string $method リクエストメソッド（get or post or put）
 * @param string $expected 期待するviewファイル
 * @param string $role ロール名
 * @param string $exception Exception
 * @dataProvider dataProviderRoleAccess
 * @return mixed テスト結果
 */
	public function testAccessPermission($action, $method, $expected, $role, $exception) {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerEditTest');
		parent::testAccessPermission($action, $method, $expected, $role, $exception);
		return $this;
	}

/**
 * delete()のGET(json)パラメータテスト
 *
 * @return mixed テスト結果
 */
	public function testDeleteGetJson() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerEditTest');
		parent::testDeleteGetJson();
		return $this;
	}

/**
 * add()のテスト
 *
 * @param string $method リクエストメソッド（get or post or put）
 * @param array $data 登録データ
 * @param bool $validationError バリデーションエラー
 * @dataProvider dataProviderAdd
 * @return mixed テスト結果
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testAdd($method, $data = null, $validationError = false) {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerEditTest');
		parent::testAdd($method, $data, $validationError);
		return $this;
	}

/**
 * edit()のテスト
 *
 * @param string $method リクエストメソッド（get or post or put）
 * @param array $data 登録データ
 * @param bool $validationError バリデーションエラー
 * @dataProvider dataProviderEdit
 * @return mixed テスト結果
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testEdit($method, $data = null, $validationError = false) {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerEditTest');
		parent::testEdit($method, $data, $validationError);
		return $this;
	}

/**
 * delete()のGET(json)パラメータテスト
 *
 * @return mixed テスト結果
 */
	public function testDelete($data) {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlocksControllerEditTest');
		parent::testDelete($data);
		return $this;
	}

}
