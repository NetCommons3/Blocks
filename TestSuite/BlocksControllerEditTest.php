<?php
/**
 * BlocksControllerTest
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\TestSuite
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @codeCoverageIgnore
 */
class BlocksControllerEditTest extends NetCommonsControllerTestCase {

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		if (! $this->_controller) {
			$this->_controller = Inflector::singularize($this->plugin) . '_' . 'blocks';
		}
		$this->generateNc(Inflector::camelize($this->_controller));
	}

/**
 * ロールチェックdataProvider
 *
 * @return array
 */
	public function dataProviderByRoleAccess() {
		//$action, $method, $expect, $role, $exception, $data
		$data = array(
			//addアクション
			array('add', 'get', 'edit', Role::ROOM_ROLE_KEY_CHIEF_EDITOR, false),
			array('add', 'get', 'edit', Role::ROOM_ROLE_KEY_EDITOR, 'ForbiddenException'),
			array('add', 'get', 'edit', Role::ROOM_ROLE_KEY_GENERAL_USER, 'ForbiddenException'),
			array('add', 'get', 'edit', Role::ROOM_ROLE_KEY_VISITOR, 'ForbiddenException'),
			array('add', 'get', 'edit', null, 'ForbiddenException'),
			//editアクション
			array('edit', 'get', 'edit', Role::ROOM_ROLE_KEY_CHIEF_EDITOR, false),
			array('edit', 'get', 'edit', Role::ROOM_ROLE_KEY_EDITOR, 'ForbiddenException'),
			array('edit', 'get', 'edit', Role::ROOM_ROLE_KEY_GENERAL_USER, 'ForbiddenException'),
			array('edit', 'get', 'edit', Role::ROOM_ROLE_KEY_VISITOR, 'ForbiddenException'),
			array('edit', 'get', 'edit', null, 'ForbiddenException'),
			//deleteアクション
			array('delete', 'get', 'delete', Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR, 'BadRequestException'),
			array('delete', 'get', 'delete', Role::ROOM_ROLE_KEY_CHIEF_EDITOR, 'BadRequestException'),
			array('delete', 'get', 'delete', Role::ROOM_ROLE_KEY_EDITOR, 'ForbiddenException'),
			array('delete', 'get', 'delete', Role::ROOM_ROLE_KEY_GENERAL_USER, 'ForbiddenException'),
			array('delete', 'get', 'delete', Role::ROOM_ROLE_KEY_VISITOR, 'ForbiddenException'),
			array('delete', 'get', 'delete', null, 'ForbiddenException'),
		);
		return $data;
	}

/**
 * アクセス許可テスト
 *
 * @param string $role ロール名
 * @param bool $exception Exceptionの有無
 * @dataProvider dataProviderByRoleAccess
 * @return void
 */
	public function testAccessPermission($action, $method, $expect, $role, $exception) {
		if ($exception) {
			$this->setExpectedException($exception);
		}
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//アクション実行
		$frameId = '6';
		$blockId = '4';

		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => $action,
			'frame_id' => $frameId
		);
		if ($action === 'edit' || $action === 'delete') {
			$url['block_id'] = $blockId;
		}

		$params = array(
			'method' => $method,
			'return' => 'view'
		);
		$this->testAction(NetCommonsUrl::actionUrl($url), $params);

		//チェック
		$this->assertTextEquals($expect, $this->controller->view);
	}

/**
 * delete()のGET(json)パラメータテスト
 *
 * @return void
 */
	public function testDeleteGetJson() {
		//ログイン
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';

		//アクション実行
			$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'delete',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$params = array(
			'method' => 'get',
			'return' => 'view',
			'type' => 'json'
		);
		$this->testAction($url, $params);

		//チェック
		$result = json_decode($this->contents, true);
		$this->assertArrayHasKey('code', $result);
		$this->assertEquals(400, $result['code']);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * add()のテスト
 *
 * @param string $method リクエストメソッド（get or post or put）
 * @param array $data 登録データ
 * @param bool $validationError validationErrorの有無
 * @dataProvider dataProviderByAdd
 * @return void
 */
	public function testAdd($method, $data = null, $validationError = false) {
		//ログイン
		TestAuthGeneral::login($this);

		$frameId = '6';
		$roomId = '1';

		//アクション実行
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'add',
			'frame_id' => $frameId
		));
		$params = array(
			'method' => $method,
			'return' => 'view',
			'data' => $data
		);
		$this->testAction($url, $params);

		//チェック
		if ($method === 'post' && ! $validationError) {
			$header = $this->controller->response->header();
			$this->assertNotEmpty($header['Location']);
		} else {
			$this->assertRegExp('/<form.*?action=".*?' . preg_quote($url, '/') . '.*?">/', $this->contents);
			$this->assertRegExp(
				'/<input.*?name="' . preg_quote('data[Frame][id]', '/') . '".*?value="' . $frameId . '".*?>/', $this->contents
			);
			$this->assertRegExp(
				'/<input.*?name="' . preg_quote('data[Block][id]', '/') . '".*?>/', $this->contents
			);
			$this->assertRegExp(
				'/<input.*?name="' . preg_quote('data[Block][room_id]', '/') . '".*?value="' . $roomId . '".*?>/', $this->contents
			);
			//バリデーションエラー
			if ($validationError) {
				$this->assertNotEmpty($this->controller->validationErrors);
			}
		}

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * edit()のテスト
 *
 * @param string $method リクエストメソッド（get or post or put）
 * @param array $data 登録データ
 * @param bool $validationError validationErrorの有無
 * @dataProvider dataProviderByEdit
 */
	public function testEdit($method, $data = null, $validationError = false) {
		//ログイン
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';
		$roomId = '1';

		//アクション実行
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$params = array(
			'method' => $method,
			'return' => 'view',
			'data' => $data
		);
		$this->testAction($url, $params);

		//チェック
		if ($method === 'put' && ! $validationError) {
			$header = $this->controller->response->header();
			$this->assertNotEmpty($header['Location']);
		} else {
			$this->assertRegExp('/<form.*?action=".*?' . preg_quote($url, '/') . '.*?">/', $this->contents);
			$this->assertRegExp(
				'/<input.*?name="' . preg_quote('data[Frame][id]', '/') . '".*?value="' . $frameId . '".*?>/', $this->contents
			);
			$this->assertRegExp(
				'/<input.*?name="' . preg_quote('data[Block][id]', '/') . '".*?value="' . $blockId . '".*?>/', $this->contents
			);
			$this->assertRegExp(
				'/<input.*?name="' . preg_quote('data[Block][room_id]', '/') . '".*?value="' . $roomId . '".*?>/', $this->contents
			);
			$this->assertRegExp('/<button.*?name="save.*?type="submit".*?>/', $this->contents);

			//削除フォームの確認
			$deleteUrl = NetCommonsUrl::actionUrl(array(
				'plugin' => $this->plugin,
				'controller' => $this->_controller,
				'action' => 'delete',
				'frame_id' => $frameId,
				'block_id' => $blockId
			));
			$this->assertRegExp('/<form.*?action=".*?' . preg_quote($deleteUrl, '/') . '.*?">/', $this->contents);
			$this->assertRegExp('/<button.*?name="delete".*?>/', $this->contents);

			//バリデーションエラー
			if ($validationError) {
				$this->assertNotEmpty($this->controller->validationErrors);
			}
		}

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * delete()のテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderByDelete
 * @return void
 */
	public function testDelete($data) {
		//ログイン
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';

		//アクション実行
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'delete',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$params = array(
			'method' => 'delete',
			'return' => 'view',
			'data' => $data,
		);
		$this->testAction($url, $params);

		//チェック
		$header = $this->controller->response->header();
		$this->assertNotEmpty($header['Location']);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
