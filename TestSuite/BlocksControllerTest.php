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
class BlocksControllerTest extends NetCommonsControllerTestCase {

/**
 * Edit controller name
 *
 * @var string
 */
	protected $_editController;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		if (! $this->_controller) {
			$this->_controller = Inflector::singularize($this->plugin) . '_' . 'blocks';
		}
		if (! $this->_editController) {
			$this->_editController = $this->_controller;
		}
		parent::setUp();
	}

/**
 * ロールチェックDataProvider
 *
 * ### 戻り値
 *  - role: ロール
 *  - isException: Exceptionの有無
 *
 * @return array
 */
	public function dataProviderRoleAccess() {
		//$role, $isException
		$data = array(
			array(Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR, false),
			array(Role::ROOM_ROLE_KEY_CHIEF_EDITOR, false),
			array(Role::ROOM_ROLE_KEY_EDITOR, true),
			array(Role::ROOM_ROLE_KEY_GENERAL_USER, true),
			array(Role::ROOM_ROLE_KEY_VISITOR, true),
			array(null, true),
		);
		return $data;
	}

/**
 * index()のテスト
 *
 * @return void
 */
	public function testIndex() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実施
		$frameId = '6';
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		);
		$result = $this->_testNcAction($url, array('method' => 'get'));

		//チェック
		//--追加ボタンチェック
		$addLink = $url;
		$addLink['controller'] = $this->_editController;
		$addLink['action'] = 'add';
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote(NetCommonsUrl::actionUrl($addLink), '/') . '.*?".*?>/', $result
		);

		//--編集ボタンチェック
		$blockId = '2';
		$editLink = $url;
		$editLink['controller'] = $this->_editController;
		$editLink['action'] = 'edit';
		$editLink['block_id'] = $blockId;
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote(NetCommonsUrl::actionUrl($editLink), '/') . '.*?".*?>/', $result
		);

		//--カレントブロックラジオボタン
		$this->assertInput('input', 'data[Frame][block_id]', null, $result);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * index()のブロックなしテスト
 *
 * @return void
 */
	public function testIndexNoneBlock() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実施
		$frameId = '18';
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId,
		);
		$result = $this->_testNcAction($url, array('method' => 'get'), null, 'viewFile');

		//チェック
		$this->assertTextEquals($result, 'Blocks.Blocks/not_found');

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * index()のアクセス許可テスト
 *
 * @param string $role ロール名
 * @param bool $isException Exceptionの有無
 * @dataProvider dataProviderRoleAccess
 * @return void
 */
	public function testAccessPermission($role, $isException) {
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		if ($isException) {
			$exception = 'ForbiddenException';
		} else {
			$exception = null;
		}

		//テスト実施
		$frameId = '6';
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId,
		);
		$result = $this->_testNcAction($url, array('method' => 'get'), $exception, 'viewFile');

		//チェック
		$this->assertTextEquals('index', $result);
	}

}
