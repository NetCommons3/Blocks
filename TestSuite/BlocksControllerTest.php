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
 * @codeCoverageIgnore
 */
class BlocksControllerTest extends NetCommonsControllerTestCase {

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
 * ページネーションDataProvider
 *
 * ### 戻り値
 *  - page: ページ番号
 *  - isFirst: 最初のページかどうか
 *  - isLast: 最後のページかどうか
 *
 * @return array
 */
	public function dataProviderPaginator() {
		//$page, $isFirst, $isLast
		$data = array(
			array(1, true, false),
			array(3, false, false),
			array(5, false, true),
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
		$addLink['action'] = 'add';
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote(NetCommonsUrl::actionUrl($addLink), '/') . '.*?".*?>/', $result
		);

		//--編集ボタンチェック
		$blockId = '2';
		$editLink = $url;
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

/**
 * index()のページネーションテスト
 *
 * @param int $page ページ番号
 * @param bool $isFirst 最初のページかどうか
 * @param bool $isLast 最後のページかどうか
 * @dataProvider dataProviderPaginator
 * @return void
 */
	public function testIndexPaginator($page, $isFirst, $isLast) {
		TestAuthGeneral::login($this);

		//テスト実施
		$frameId = '16';
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId,
		);
		if (! $isFirst) {
			$url[] = 'page:' . $page;
		}
		$result = $this->_testNcAction($url, array('method' => 'get'));

		//チェック
		$this->assertRegExp(
			'/' . preg_quote('<ul class="pagination">', '/') . '/', $result
		);
		if ($isFirst) {
			$this->assertNotRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $result);
		} else {
			$this->assertRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $result);
		}
		$this->assertRegExp('/<li class="active"><a>' . $page . '<\/a><\/li>/', $result);
		if ($isLast) {
			$this->assertNotRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $result);
		} else {
			$this->assertRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $result);
		}

		TestAuthGeneral::logout($this);
	}

}
