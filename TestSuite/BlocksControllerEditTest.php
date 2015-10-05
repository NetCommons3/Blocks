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
 * add()のログインなしテスト
 *
 * @return void
 */
	public function testAddWOLogin() {
		$frameId = '6';

		//アクション実行
		$this->setExpectedException('ForbiddenException');
		$this->_testNcAction(
			array(
				'action' => 'add',
				'frame_id' => $frameId,
			)
		);
	}

/**
 * add()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testAddWOBlockEditable() {
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testAddWOLogin();

		TestAuthGeneral::logout($this);
	}

/**
 * add()のGETパラメータテスト
 *
 * @param string $method Request method
 * @return void
 */
	public function testAddGet($method = 'get') {
		TestAuthGeneral::login($this);

		$frameId = '6';
		$roomId = '1';

		//アクション実行
		$url = $this->_getActionUrl(
			array(
				'action' => 'add',
				'frame_id' => $frameId,
			)
		);
		$this->_testNcAction($url, array('method' => $method));

		//評価
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

		TestAuthGeneral::logout($this);
	}

/**
 * add()のPUTパラメータテスト
 *
 * @return void
 */
	public function testAddPut() {
		TestAuthGeneral::login($this);

		$this->testAddGet('put');

		TestAuthGeneral::logout($this);
	}

/**
 * add()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testAddPost() {
		TestAuthGeneral::login($this);

		//アクション実行
		$frameId = '6';
		$this->_testNcAction(
			array(
				'action' => 'add',
				'frame_id' => $frameId,
			)
		);

		//評価
		$this->assertTextEquals('edit', $this->controller->view);

		TestAuthGeneral::logout($this);
	}

/**
 * edit()のログインなしテスト
 *
 * @return void
 */
	public function testEditWOLogin() {
		$frameId = '6';
		$blockId = '4';

		//アクション実行
		$this->setExpectedException('ForbiddenException');
		$this->_testNcAction(
			array(
				'action' => 'edit',
				'frame_id' => $frameId,
				'block_id' => $blockId
			)
		);
	}

/**
 * edit()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testEditWOBlockEditable() {
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testEditWOLogin();

		TestAuthGeneral::logout($this);
	}

/**
 * edit()のGETパラメータテスト
 *
 * @param string $method Request method
 * @return void
 */
	public function testEditGet($method = 'get') {
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';
		$roomId = '1';

		//アクション実行
		$url = $this->_getActionUrl(
			array(
				'action' => 'edit',
				'frame_id' => $frameId,
				'block_id' => $blockId
			)
		);
		$this->_testNcAction($url, array('method' => $method));

		//評価
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
		$this->assertRegExp('/<button.*?type="submit".*?>/', $this->contents);

		TestAuthGeneral::logout($this);
	}

/**
 * edit()のPUTパラメータテスト
 *
 * @return void
 */
	public function testEditPut() {
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';

		//アクション実行
		$this->_testNcAction(
			array(
				'action' => 'edit',
				'frame_id' => $frameId,
				'block_id' => $blockId
			)
		);

		//評価
		$this->assertTextEquals('edit', $this->controller->view);

		TestAuthGeneral::logout($this);
	}

/**
 * edit()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testEditPost() {
		TestAuthGeneral::login($this);

		$this->testEditGet('post');

		TestAuthGeneral::logout($this);
	}

/**
 * delete()のログインなしテスト
 *
 * @return void
 */
	public function testDeleteWOLogin() {
		$frameId = '6';
		$blockId = '4';

		//アクション実行
		$this->setExpectedException('ForbiddenException');
		$this->_testNcAction(
			array(
				'action' => 'delete',
				'frame_id' => $frameId,
				'block_id' => $blockId
			)
		);
	}

/**
 * delete()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testDeleteWOBlockEditable() {
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testDeleteWOLogin();

		TestAuthGeneral::logout($this);
	}

/**
 * delete()のGETパラメータテスト
 *
 * @return void
 */
	public function testDeleteGet() {
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';

		//アクション実行
		$this->setExpectedException('BadRequestException');
		$this->_testNcAction(
			array(
				'action' => 'delete',
				'frame_id' => $frameId,
				'block_id' => $blockId
			),
			array('method' => 'get')
		);

		TestAuthGeneral::logout($this);
	}

/**
 * delete()のGET(json)パラメータテスト
 *
 * @return void
 */
	public function testDeleteGetJson() {
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';

		//アクション実行
		$this->_testNcAction(
			array(
				'action' => 'delete',
				'frame_id' => $frameId,
				'block_id' => $blockId
			),
			array('type' => 'json', 'method' => 'get')
		);

		//評価
		$result = json_decode($this->contents, true);
		$this->assertArrayHasKey('code', $result);
		$this->assertEquals(400, $result['code']);

		TestAuthGeneral::logout($this);
	}

/**
 * delete()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testDeletePost() {
		TestAuthGeneral::login($this);

		$frameId = '6';
		$blockId = '4';

		//アクション実行
		$this->_testNcAction(
			array(
				'action' => 'delete',
				'frame_id' => $frameId,
				'block_id' => $blockId
			)
		);

		//評価
		$this->assertTextEquals('delete', $this->controller->view);

		TestAuthGeneral::logout($this);
	}

}
