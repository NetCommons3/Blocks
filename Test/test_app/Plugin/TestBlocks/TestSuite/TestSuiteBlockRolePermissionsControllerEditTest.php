<?php
/**
 * BlockRolePermissionsControllerEditTestテスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockRolePermissionsControllerEditTest', 'Blocks.TestSuite');

/**
 * BlockRolePermissionsControllerEditTestテスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\TestSuite
 */
class TestSuiteBlockRolePermissionsControllerEditTest extends BlockRolePermissionsControllerEditTest {

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
	protected $_controller = 'TestSuiteBlockRolePermissionsControllerEditTest';

/**
 * Controller name
 *
 * @var string
 */
	protected $_asserts = array();

/**
 * $this->asserts()のチェック用メソッド
 *
 * @param array $asserts テストAssert
 * @param string $result Result data
 * @return void
 */
	public function asserts($asserts, $result) {
		$this->_asserts[] = $asserts;
	}

/**
 * setUp method
 *
 * @return mixed テスト結果
 */
	public function setUp() {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlockRolePermissionsControllerEditTest');
		parent::setUp();
	}

/**
 * ロールチェックdataProvider
 *
 * ### 戻り値
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
 * @param string $role ロール名
 * @param string $exception Exception
 * @dataProvider dataProviderRoleAccess
 * @return mixed テスト結果
 */
	public function testAccessPermission($role, $exception) {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlockRolePermissionsControllerEditTest');
		parent::testAccessPermission($role, $exception);
		return $this;
	}

/**
 * editアクションのGETテスト
 *
 * @param array $approvalFields コンテンツ承認の利用有無のフィールド
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGet
 * @return mixed テスト結果
 */
	public function testEditGet($approvalFields, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlockRolePermissionsControllerEditTest');
		parent::testEditGet($approvalFields, $exception, $return);
		return $this->_asserts;
	}

/**
 * editアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditPost
 * @return mixed テスト結果
 */
	public function testEditPost($data, $exception = null, $return = 'view') {
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestSuiteBlockRolePermissionsControllerEditTest');
		parent::testEditPost($data, $exception, $return);
		return $this;
	}

}
