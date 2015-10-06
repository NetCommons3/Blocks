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
		TestAuthGeneral::login($this);

		//アクション実行
		$frameId = '6';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		));
		$this->testAction($url, array('method' => 'get', 'return' => 'view'));

		//チェック
		//--追加ボタンチェック
		$expect = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'add',
			'frame_id' => $frameId
		));
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote($expect, '/') . '.*?".*?>/', $this->contents
		);

		//--編集ボタンチェック
		$blockId = '2';
		$expect = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote($expect, '/') . '.*?".*?>/', $this->contents
		);

		//--カレントブロックラジオボタン
		$this->assertInput('input', 'data[Frame][block_id]', null, $this->contents);

		TestAuthGeneral::logout($this);
	}

/**
 * index()のブロックなしテスト
 *
 * @return void
 */
	public function testIndexNoneBlock() {
		TestAuthGeneral::login($this);

		//アクション実行
		$frameId = '18';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		));
		$this->testAction($url, array('method' => 'get', 'return' => 'view'));

		//チェック
		$this->assertTextEquals($this->controller->view, 'Blocks.Blocks/not_found');

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
		if ($isException) {
			$this->setExpectedException('ForbiddenException');
		}
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//アクション実行
		$frameId = '6';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		));
		$this->testAction($url, array('method' => 'get', 'return' => 'view'));

		//チェック
		$this->assertTextEquals('index', $this->controller->view);
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

		//アクション実行
		$frameId = '16';
		$options = array();
		if (! $isFirst) {
			$options = array('page:' . $page);
		}
		$url = NetCommonsUrl::actionUrl(Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		), $options));
		$this->testAction($url, array('method' => 'get', 'return' => 'view'));

		//チェック
		$this->assertRegExp(
			'/' . preg_quote('<ul class="pagination">', '/') . '/', $this->contents
		);
		if ($isFirst) {
			$this->assertNotRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $this->contents);
		} else {
			$this->assertRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $this->contents);
		}
		$this->assertRegExp('/<li class="active"><a>' . $page . '<\/a><\/li>/', $this->contents);
		if ($isLast) {
			$this->assertNotRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $this->contents);
		} else {
			$this->assertRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $this->contents);
		}

		TestAuthGeneral::logout($this);
	}

}
