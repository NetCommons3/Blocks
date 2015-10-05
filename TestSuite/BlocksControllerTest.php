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
 * Action name
 *
 * @var string
 */
	protected $_action = 'index';

/**
 * index()のテスト
 *
 * @return void
 */
	public function testIndex() {
		TestAuthGeneral::login($this);

		//アクション実行
		$frameId = '6';
		$this->_testNcAction(
			array('frame_id' => $frameId)
		);

		$editUrl = $this->_getActionUrl(array('action' => 'edit'));
		$this->assertRegExp('/<a href=".*?' . preg_quote($editUrl, '/') . '.*?".*?>/', $this->contents);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Frame][block_id]', '/') . '".*?>/', $this->contents
		);

		TestAuthGeneral::logout($this);
	}

/**
 * index()のテスト
 *
 * @return void
 */
	public function testIndexNoBlock() {
		TestAuthGeneral::login($this);

		//アクション実行
		$frameId = '18';
		$this->_testNcAction(
			array('frame_id' => $frameId)
		);

		//評価
		$this->assertTextEquals('Blocks.Blocks/not_found', $this->controller->view);

		TestAuthGeneral::logout($this);
	}

/**
 * index()のログインなしテスト
 *
 * @return void
 */
	public function testIndexWOLogin() {
		$this->setExpectedException('ForbiddenException');

		//アクション実行
		$frameId = '6';
		$this->_testNcAction(
			array('frame_id' => $frameId)
		);
	}

/**
 * index()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testIndexWOBlockEditable() {
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testIndexWOLogin();

		TestAuthGeneral::logout($this);
	}

/**
 * index()の複数ページの最初のページテスト
 *
 * @return void
 */
	public function testIndexFirstPageOnMultiplePages() {
		TestAuthGeneral::login($this);

		//アクション実行
		$frameId = '16';
		$page = '1';
		$this->_testNcAction(
			array('frame_id' => $frameId)
		);

		//評価
		$this->assertRegExp('/' . preg_quote('<ul class="pagination">', '/') . '/', $this->contents);
		$this->assertNotRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $this->contents);
		$this->assertRegExp('/<li class="active"><a>' . $page . '<\/a><\/li>/', $this->contents);
		$this->assertRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $this->contents);

		TestAuthGeneral::logout($this);
	}

/**
 * index()の複数ページのテスト
 *
 * @return void
 */
	public function testIndexOnMultiplePages() {
		TestAuthGeneral::login($this);

		//アクション実行
		$frameId = '16';
		$page = '3';
		$this->_testNcAction(
			array('frame_id' => $frameId, 'page:' . $page)
		);

		//評価
		$this->assertRegExp('/<ul class="pagination">/', $this->contents);
		$this->assertRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $this->contents);
		$this->assertRegExp('/<li class="active"><a>' . $page . '<\/a><\/li>/', $this->contents);
		$this->assertRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $this->contents);

		TestAuthGeneral::logout($this);
	}

/**
 * index()の複数ページの最後のページテスト
 *
 * @return void
 */
	public function testIndexLastPageOnMultiplePages() {
		TestAuthGeneral::login($this);

		//アクション実行
		$frameId = '16';
		$page = '5';
		$this->_testNcAction(
			array('frame_id' => $frameId, 'page:' . $page)
		);

		//評価
		$this->assertRegExp('/<ul class="pagination">/', $this->contents);
		$this->assertRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $this->contents);
		$this->assertRegExp('/<li class="active"><a>' . $page . '<\/a><\/li>/', $this->contents);
		$this->assertNotRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $this->contents);

		TestAuthGeneral::logout($this);
	}

}
