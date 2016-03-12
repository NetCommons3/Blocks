<?php
/**
 * BlocksControllerEditTestテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * BlocksControllerEditTestテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestSuiteBlocksControllerEditTestController extends AppController {

/**
 * edit
 *
 * @return void
 */
	public function add() {
		$this->autoRender = true;
		$this->set('username', Current::read('User.username'));
		$this->redirect('index');

		$this->validationErrors = 'Validation error message';
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->autoRender = true;
		$this->set('username', Current::read('User.username'));
		$this->redirect('index');

		$this->validationErrors = 'Validation error message';
	}

/**
 * edit
 *
 * @return void
 */
	public function delete() {
		$this->autoRender = true;
		$this->set('username', Current::read('User.username'));
		$this->redirect('index');
	}

}
