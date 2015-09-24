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
		$result = $this->testAction('/' . $this->_plugin . '/' . $this->_controller . '/index/' . $frameId, array(
			'method' => 'get',
			'return' => 'view',
		));

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
		$this->testAction('/' . $this->_plugin . '/' . $this->_controller . '/index/' . $frameId, array(
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
 * index()の複数ページのテスト
 *
 * @return void
 */
	public function testIndexOnMultiplePages() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * index()の複数ページの最初のページテスト
 *
 * @return void
 */
	public function testIndexFirstPageOnMultiplePages() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * index()の複数ページの最後のページテスト
 *
 * @return void
 */
	public function testIndexLastPageOnMultiplePages() {
		AuthGeneralTestSuite::login($this);

		AuthGeneralTestSuite::logout($this);
	}

}
