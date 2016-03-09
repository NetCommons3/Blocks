<?php
/**
 * View/Elements/form_hiddenテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/form_hiddenテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestViewElementsFormHiddenController extends AppController {

/**
 * form_hidden
 *
 * @return void
 */
	public function form_hidden() {
		$this->autoRender = true;

		$this->request->data['Frame'] = array(
			'id' => '6'
		);
		$this->request->data['Block'] = array(
			'id' => '2',
			'key' => 'block_1',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_blocks'
		);
	}

}
