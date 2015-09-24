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
class BlocksControllerEditTest extends NetCommonsControllerTestCase {

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
 * add()のログインなしテスト
 *
 * @return void
 */
	public function testAddWOLogin() {
		$this->setExpectedException('ForbiddenException');

		//アクション実行
		$frameId = '6';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'add',
			'frame_id' => $frameId
		));
		$this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));
	}

/**
 * add()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testAddWOBlockEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testAddWOLogin();

		AuthGeneralTestSuite::logout($this);
	}

/**
 * add()のGETパラメータテスト
 *
 * @return void
 */
	public function testAddGet($method = 'get') {
		AuthGeneralTestSuite::login($this);

		$frameId = '6';
		$roomId = '1';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'add',
			'frame_id' => $frameId
		));
		$result = $this->testAction($url, array(
			'method' => $method,
			'return' => 'view',
		));

		$this->assertRegExp('/<form.*?action=".*?' . preg_quote($url, '/') . '.*?">/', $result);
		$this->assertRegExp('/<input.*?' . preg_quote('data[Frame][id]', '/') . '.*?value="' . $frameId . '".*?>/', $result);
		$this->assertRegExp('/<input.*?' . preg_quote('data[Block][id]', '/') . '.*?>/', $result);
		$this->assertRegExp('/<input.*?' . preg_quote('data[Block][room_id]', '/') . '.*?value="' . $roomId . '".*?>/', $result);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * add()のPUTパラメータテスト
 *
 * @return void
 */
	public function testAddPut() {
		AuthGeneralTestSuite::login($this);

		$this->testAddGet('put');

		AuthGeneralTestSuite::logout($this);
	}

/**
 * add()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testAddPost() {
		AuthGeneralTestSuite::login($this);

//		$frameId = '6';
//		$url = NetCommonsUrl::actionUrl(array(
//			'plugin' => $this->_plugin,
//			'controller' => $this->_controller,
//			'action' => 'add',
//			'frame_id' => $frameId
//		));
//		$result = $this->testAction($url, array(
//			'method' => 'post',
//			'return' => 'view',
//		));

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のログインなしテスト
 *
 * @return void
 */
	public function testEditWOLogin() {
		$this->setExpectedException('ForbiddenException');

		//アクション実行
		$frameId = '6';
		$blockId = '4';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));
	}

/**
 * edit()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testEditWOBlockEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testEditWOLogin();

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のGETパラメータテスト
 *
 * @return void
 */
	public function testEditGet($method = 'get') {
		AuthGeneralTestSuite::login($this);

		//アクション実行
		$frameId = '6';
		$blockId = '4';
		$roomId = '1';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$result = $this->testAction($url, array(
			'method' => $method,
			'return' => 'view',
		));

		$this->assertRegExp('/<form.*?action=".*?' . preg_quote($url, '/') . '.*?">/', $result);
		$this->assertRegExp('/<input.*?' . preg_quote('data[Frame][id]', '/') . '.*?value="' . $frameId . '".*?>/', $result);
		$this->assertRegExp('/<input.*?' . preg_quote('data[Block][id]', '/') . '.*?value="' . $blockId . '".*?>/', $result);
		$this->assertRegExp('/<input.*?' . preg_quote('data[Block][room_id]', '/') . '.*?value="' . $roomId . '".*?>/', $result);
		$this->assertRegExp('/<button.*?type="submit".*?>/', $result);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のPUTパラメータテスト
 *
 * @return void
 */
	public function testEditPut() {
		AuthGeneralTestSuite::login($this);

//		//アクション実行
//		$frameId = '6';
//		$blockId = '4';
//		$url = NetCommonsUrl::actionUrl(array(
//			'plugin' => $this->_plugin,
//			'controller' => $this->_controller,
//			'action' => 'edit',
//			'frame_id' => $frameId,
//			'block_id' => $blockId
//		));
//		$result = $this->testAction($url, array(
//			'method' => 'put',
//			'return' => 'view',
//		));

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testEditPost() {
		AuthGeneralTestSuite::login($this);

		$this->testEditGet('post');

		AuthGeneralTestSuite::logout($this);
	}

/**
 * delete()のログインなしテスト
 *
 * @return void
 */
	public function testDeleteWOLogin($method = 'delete', $exception = 'ForbiddenException') {
		$this->setExpectedException($exception);

		//アクション実行
		$frameId = '6';
		$blockId = '4';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->_plugin,
			'controller' => $this->_controller,
			'action' => 'delete',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$this->testAction($url, array(
			'method' => $method,
			'return' => 'view',
		));
	}

/**
 * delete()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testDeleteWOBlockEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testDeleteWOLogin();

		AuthGeneralTestSuite::logout($this);
	}

/**
 * delete()のGETパラメータテスト
 *
 * @return void
 */
	public function testDeleteGet() {
		AuthGeneralTestSuite::login($this);

		$this->testDeleteWOLogin('get', 'BadRequestException');

		AuthGeneralTestSuite::logout($this);
	}

/**
 * delete()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testDeletePost() {
		AuthGeneralTestSuite::login($this);

//		//アクション実行
//		$frameId = '6';
//		$blockId = '4';
//		$url = NetCommonsUrl::actionUrl(array(
//			'plugin' => $this->_plugin,
//			'controller' => $this->_controller,
//			'action' => 'delete',
//			'frame_id' => $frameId,
//			'block_id' => $blockId
//		));
//		$result = $this->testAction($url, array(
//			'method' => 'delete',
//			'return' => 'view',
//		));


		AuthGeneralTestSuite::logout($this);
	}

}
