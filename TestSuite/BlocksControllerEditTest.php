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
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * BlocksControllerTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\TestSuite
 */
abstract class BlocksControllerEditTest extends NetCommonsControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		if (! $this->_controller) {
			$this->_controller = Inflector::singularize($this->plugin) . '_' . 'blocks';
		}
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
 * @return array
 */
	public function dataProviderRoleAccess() {
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
 * @param string $action アクション名
 * @param string $method リクエストメソッド（get or post or put）
 * @param string $expected 期待するviewファイル
 * @param string $role ロール名
 * @param string $exception Exception
 * @dataProvider dataProviderRoleAccess
 * @return void
 */
	public function testAccessPermission($action, $method, $expected, $role, $exception) {
		if ($exception) {
			$this->setExpectedException($exception);
		}
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//アクション実行
		$frameId = '6';
		$blockId = '2';

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
		$this->assertTextEquals($this->controller->view, $expected);

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

/**
 * add()のテスト
 *
 * @param string $method リクエストメソッド（get or post or put）
 * @param array $data 登録データ
 * @param bool $validationError バリデーションエラー
 * @dataProvider dataProviderAdd
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testAdd($method, $data = null, $validationError = false) {
		//ログイン
		TestAuthGeneral::login($this);

		$frameId = '6';
		$roomId = '2';
		if ($validationError) {
			$data = Hash::insert($data, $validationError['field'], $validationError['value']);
		}

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
			$asserts = array(
				array('method' => 'assertNotEmpty', 'value' => $header['Location'])
			);
		} else {
			$asserts = array(
				array(
					'method' => 'assertInput', 'type' => 'form',
					'name' => null, 'value' => $url
				),
				array(
					'method' => 'assertInput', 'type' => 'input',
					'name' => 'data[Frame][id]', 'value' => $frameId
				),
				array(
					'method' => 'assertInput', 'type' => 'input',
					'name' => 'data[Block][id]', 'value' => null
				),
				array(
					'method' => 'assertInput', 'type' => 'input',
					'name' => 'data[Block][room_id]', 'value' => $roomId
				),
			);
			//バリデーションエラー
			if ($validationError) {
				array_push($asserts, array(
					'method' => 'assertNotEmpty', 'value' => $this->controller->validationErrors
				));
				array_push($asserts, array(
					'method' => 'assertTextContains', 'expected' => $validationError['message']
				));
			}
		}

		//チェック
		$this->asserts($asserts, $this->contents);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * edit()のテスト
 *
 * @param string $method リクエストメソッド（get or post or put）
 * @param array $data 登録データ
 * @param bool $validationError バリデーションエラー
 * @dataProvider dataProviderEdit
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testEdit($method, $data = null, $validationError = false) {
		//ログイン
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';
		$roomId = '2';
		if ($validationError) {
			$data = Hash::remove($data, $validationError['field']);
			$data = Hash::insert($data, $validationError['field'], $validationError['value']);
		}

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
			$asserts = array(
				array('method' => 'assertNotEmpty', 'value' => $header['Location'])
			);
		} else {
			//削除フォームの確認
			$deleteUrl = NetCommonsUrl::actionUrl(array(
				'plugin' => $this->plugin,
				'controller' => $this->_controller,
				'action' => 'delete',
				'frame_id' => $frameId,
				'block_id' => $blockId
			));

			$asserts = array(
				array(
					'method' => 'assertInput', 'type' => 'form',
					'name' => null, 'value' => $url
				),
				array(
					'method' => 'assertInput', 'type' => 'input',
					'name' => 'data[Frame][id]', 'value' => $frameId
				),
				array(
					'method' => 'assertInput', 'type' => 'input',
					'name' => 'data[Block][id]', 'value' => $blockId
				),
				array(
					'method' => 'assertInput', 'type' => 'input',
					'name' => 'data[Block][room_id]', 'value' => $roomId
				),
				array(
					'method' => 'assertInput', 'type' => 'form',
					'name' => null, 'value' => $deleteUrl
				),
				array(
					'method' => 'assertInput', 'type' => 'button',
					'name' => 'delete', 'value' => null
				),
			);

			//バリデーションエラー
			if ($validationError) {
				array_push($asserts, array(
					'method' => 'assertNotEmpty', 'value' => $this->controller->validationErrors
				));
				array_push($asserts, array(
					'method' => 'assertTextContains', 'expected' => $validationError['message']
				));
			}
		}

		//チェック
		$this->asserts($asserts, $this->contents);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * delete()のテスト
 *
 * @param array $data 削除データ
 * @dataProvider dataProviderDelete
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
		$asserts = array(
			array('method' => 'assertNotEmpty', 'value' => $header['Location'])
		);
		$this->asserts($asserts, $this->contents);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
