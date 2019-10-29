<?php
/**
 * BlocksControllerTestテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * BlocksControllerTestテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestSuiteBlocksControllerTestErrorController extends AppController {

/**
 * index
 *
 * @return void
 * @throws ForbiddenException
 */
	public function index() {
		$this->autoRender = true;
		throw new ForbiddenException();
	}

}
