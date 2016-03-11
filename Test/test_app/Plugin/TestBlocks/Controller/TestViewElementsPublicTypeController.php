<?php
/**
 * View/Elements/public_typeテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/public_typeテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestViewElementsPublicTypeController extends AppController {

/**
 * public_type
 *
 * @return void
 */
	public function public_type() {
		$this->autoRender = true;
		$this->request->data['Block'] = Current::read('Block');
	}

}
