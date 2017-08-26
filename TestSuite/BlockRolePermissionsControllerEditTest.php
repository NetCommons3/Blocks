<?php
/**
 * BlockRolePermissionsControllerEditTest
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');
App::uses('RolesRoomFixture', 'Rooms.Test/Fixture');

/**
 * BlockRolePermissionsControllerEditTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\TestSuite
 */
abstract class BlockRolePermissionsControllerEditTest extends NetCommonsControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		if (! $this->_controller) {
			$this->_controller = Inflector::singularize($this->plugin) . '_' . 'block_role_permissions';
		}
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
 * @return array
 */
	public function dataProviderRoleAccess() {
		$data = array(
			array(Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR, null),
			array(Role::ROOM_ROLE_KEY_CHIEF_EDITOR, 'ForbiddenException'),
			array(Role::ROOM_ROLE_KEY_EDITOR, 'ForbiddenException'),
			array(Role::ROOM_ROLE_KEY_GENERAL_USER, 'ForbiddenException'),
			array(Role::ROOM_ROLE_KEY_VISITOR, 'ForbiddenException'),
			array(null, 'ForbiddenException'),
		);
		return $data;
	}

/**
 * アクセス許可テスト
 *
 * @param string $role ロール名
 * @param string $exception Exception
 * @dataProvider dataProviderRoleAccess
 * @return void
 */
	public function testAccessPermission($role, $exception) {
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//アクション実行
		$frameId = '6';
		$blockId = '2';
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		);
		$params = array(
			'method' => 'get',
		);
		$result = $this->_testNcAction($url, $params, $exception, 'viewFile');

		//チェック
		$this->assertTextEquals('edit', $result);

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

/**
 * テストDataの取得
 *
 * @param bool $isPost POSTかどうか
 * @param bool $isCommentApproval コメント承認の有無
 * @return array
 */
	protected function _getPermissionData($isPost, $isCommentApproval) {
		if ($isPost) {
			if ($isCommentApproval) {
				$data = array(
					'content_creatable' => array(
						Role::ROOM_ROLE_KEY_GENERAL_USER,
					),
					'content_comment_creatable' => array(
						Role::ROOM_ROLE_KEY_EDITOR,
						Role::ROOM_ROLE_KEY_GENERAL_USER,
						Role::ROOM_ROLE_KEY_VISITOR,
					),
					'content_comment_publishable' => array(
						Role::ROOM_ROLE_KEY_EDITOR,
					)
				);
			} else {
				$data = array(
					'content_creatable' => array(
						Role::ROOM_ROLE_KEY_GENERAL_USER,
					),
				);
			}
		} else {
			if ($isCommentApproval) {
				$data = array(
					'content_creatable' => array(
						Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
						Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
						Role::ROOM_ROLE_KEY_EDITOR,
						Role::ROOM_ROLE_KEY_GENERAL_USER,
					),
					'content_comment_creatable' => array(
						Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
						Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
						Role::ROOM_ROLE_KEY_EDITOR,
						Role::ROOM_ROLE_KEY_GENERAL_USER,
						Role::ROOM_ROLE_KEY_VISITOR,
					),
					'content_comment_publishable' => array(
						Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
						Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
						Role::ROOM_ROLE_KEY_EDITOR,
					)
				);
			} else {
				$data = array(
					'content_creatable' => array(
						Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
						Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
						Role::ROOM_ROLE_KEY_EDITOR,
						Role::ROOM_ROLE_KEY_GENERAL_USER,
					),
				);
			}
		}

		return $data;
	}

/**
 * editアクションのチェック
 *
 * @param array $approvalFields コンテンツ承認の利用有無のフィールド
 * @param array $result 結果HTML
 * @return void
 */
	protected function _assertEditGetPermission($approvalFields, $result) {
		$isCommentApproval = in_array(
			'use_comment_approval', Hash::get(array_values($approvalFields), '0'), true
		);
		$permissions = $this->_getPermissionData(false, $isCommentApproval);

		//チェック
		foreach ($permissions as $permission => $roles) {
			foreach ($roles as $role) {
				$assert = array(
					'name' => 'data[BlockRolePermission][' . $permission . '][' . $role . '][value]',
					'method' => 'assertInput', 'type' => 'input', 'value' => null
				);
				$this->asserts(array($assert), $result);
			}
		}

		foreach ($approvalFields as $model => $fields) {
			foreach ($fields as $field) {
				$assert = array('name' => 'data[' . $model . '][' . $field . ']',
					'method' => 'assertInput', 'type' => 'input', 'value' => null);
				$this->asserts(array($assert), $result);
			}
		}
	}

/**
 * editアクションのGETテスト
 *
 * @param array $approvalFields コンテンツ承認の利用有無のフィールド
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGet
 * @return string Viewの内容
 */
	public function testEditGet($approvalFields, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';

		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		);
		$params = array(
			'method' => 'get',
			'return' => 'view',
		);
		$result = $this->_testNcAction($url, $params, $exception, $return);

		if (! $exception) {
			//チェック
			$assert = array(
				'method' => 'assertInput', 'type' => 'form', 'name' => null,
				'value' => NetCommonsUrl::actionUrl($url)
			);
			$this->asserts(array($assert), $result);

			$assert = array(
				'method' => 'assertInput', 'type' => 'input', 'name' => 'data[Block][id]',
				'value' => $blockId
			);
			$this->asserts(array($assert), $result);

			$this->_assertEditGetPermission($approvalFields, $result);
		}

		//ログアウト
		TestAuthGeneral::logout($this);

		return $result;
	}

/**
 * editアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditPost
 * @return void
 */
	public function testEditPost($data, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';
		$blockKey = 'block_2';
		$roomId = '2';
		$permissions = $this->_getPermissionData(true, Hash::check($data, '{s}.use_comment_approval'));

		$RolesRoomFixture = new RolesRoomFixture();
		$rolesRooms = Hash::extract($RolesRoomFixture->records, '{n}[room_id=' . $roomId . ']');

		$default['Block'] = array('id' => $blockId, 'key' => $blockKey);
		foreach ($permissions as $permission => $roles) {
			foreach ($roles as $role) {
				$rolesRoom = Hash::extract($rolesRooms, '{n}[role_key=' . $role . ']');
				$default['BlockRolePermission'][$permission][$role] = array(
					'roles_room_id' => $rolesRoom[0]['id'],
					'block_key' => $blockKey,
					'permission' => $permission,
					'value' => '1',
				);
			}
		}

		//テスト実施
		$url = array(
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		);
		$result = $this->_testPostAction('post', Hash::merge($default, $data), $url, $exception, $return);

		//正常の場合、リダイレクト
		if (! isset($exception)) {
			$header = $this->controller->response->header();
			$this->assertNotEmpty($header['Location']);
		}

		//ログアウト
		TestAuthGeneral::logout($this);

		return $result;
	}

}
