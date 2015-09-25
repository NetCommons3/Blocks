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
 */
class BlocksControllerTest extends NetCommonsControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->generate(Inflector::camelize($this->_plugin) . '.' . Inflector::camelize($this->_controller), array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
			)
		));
	}

/**
 * index()のテスト
 *
 * @return void
 */
	public function testIndex() {
		AuthGeneralTestSuite::login($this);

		//アクション実行
		$frameId = '6';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		$editUrl = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
		));
		$this->assertRegExp('/<a href=".*?' . preg_quote($editUrl, '/') . '.*?".*?>/', $result);
		$this->assertRegExp('/<input.*?' . preg_quote('data[Frame][block_id]', '/') . '".*?>/', $result);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * index()のテスト
 *
 * @return void
 */
	public function testIndexNoBlock() {
		AuthGeneralTestSuite::login($this);

		//アクション実行
		$frameId = '18';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertTextEquals('Blocks.Blocks/not_found', $this->controller->view);

		AuthGeneralTestSuite::logout($this);
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
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		));
		$this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));
	}

/**
 * index()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testIndexWOBlockEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testIndexWOLogin();

		AuthGeneralTestSuite::logout($this);
	}

/**
 * index()の複数ページの最初のページテスト
 *
 * @return void
 */
	public function testIndexFirstPageOnMultiplePages() {
		AuthGeneralTestSuite::login($this);

		//アクション実行
		$frameId = '16';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertRegExp('/' . preg_quote('<ul class="pagination">', '/') . '/', $result);
		$this->assertNotRegExp('/' . preg_quote('<li><a', '/') . '.*?rel="first".*?' . preg_quote('</a></li>', '/') . '/', $result);
		$this->assertRegExp('/' . preg_quote('<li class="active"><a>1</a></li>', '/') . '/', $result);
		$this->assertRegExp('/' . preg_quote('<li><a', '/') . '.*?rel="last".*?' . preg_quote('</a></li>', '/') . '/', $result);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * index()の複数ページのテスト
 *
 * @return void
 */
	public function testIndexOnMultiplePages() {
		AuthGeneralTestSuite::login($this);

		//アクション実行
		$frameId = '16';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId,
			'page:3'
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertRegExp('/' . preg_quote('<ul class="pagination">', '/') . '/', $result);
		$this->assertRegExp('/' . preg_quote('<li><a', '/') . '.*?rel="first".*?' . preg_quote('</a></li>', '/') . '/', $result);
		$this->assertRegExp('/' . preg_quote('<li class="active"><a>3</a></li>', '/') . '/', $result);
		$this->assertRegExp('/' . preg_quote('<li><a', '/') . '.*?rel="last".*?' . preg_quote('</a></li>', '/') . '/', $result);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * index()の複数ページの最後のページテスト
 *
 * @return void
 */
	public function testIndexLastPageOnMultiplePages() {
		AuthGeneralTestSuite::login($this);

		//アクション実行
		$frameId = '16';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId,
			'page:5'
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertRegExp('/' . preg_quote('<ul class="pagination">', '/') . '/', $result);
		$this->assertRegExp('/' . preg_quote('<li><a', '/') . '.*?rel="first".*?' . preg_quote('</a></li>', '/') . '/', $result);
		$this->assertRegExp('/' . preg_quote('<li class="active"><a>5</a></li>', '/') . '/', $result);
		$this->assertNotRegExp('/' . preg_quote('<li><a', '/') . '.*?rel="last".*?' . preg_quote('</a></li>', '/') . '/', $result);

		AuthGeneralTestSuite::logout($this);
	}

}
