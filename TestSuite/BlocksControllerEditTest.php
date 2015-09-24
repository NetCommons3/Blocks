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
 * Plugin name
 *
 * @var string
 */
	public $plugin = null;

/**
 * Controller name
 *
 * @var string
 */
	public $controller = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->generate(Inflector::camelize($this->plugin) . '.' . Inflector::camelize($this->controller), array(
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

	}

/**
 * add()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testAddWOBlockEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);


		AuthGeneralTestSuite::logout($this);
	}

/**
 * add()のGETパラメータテスト
 *
 * @return void
 */
	public function testAddGet() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * add()のPUTパラメータテスト
 *
 * @return void
 */
	public function testAddPut() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * add()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testAddPost() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のログインなしテスト
 *
 * @return void
 */
	public function testEditWOLogin() {

	}

/**
 * edit()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testEditWOBlockEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);


		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のGETパラメータテスト
 *
 * @return void
 */
	public function testEditGet() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のPUTパラメータテスト
 *
 * @return void
 */
	public function testEditPut() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testEditPost() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * delete()のログインなしテスト
 *
 * @return void
 */
	public function testDeleteWOLogin() {

	}

/**
 * delete()のブロック編集権限なしテスト
 *
 * @return void
 */
	public function testDeleteWOBlockEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);


		AuthGeneralTestSuite::logout($this);
	}

/**
 * delete()のGETパラメータテスト
 *
 * @return void
 */
	public function testDeleteGet() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * delete()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testDeletePost() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

}
