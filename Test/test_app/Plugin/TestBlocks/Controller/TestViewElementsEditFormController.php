<?php
/**
 * View/Elements/edit_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/edit_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestViewElementsEditFormController extends AppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'TestBlocks.TestViewElementsEditFormModel',
	);

/**
 * edit_form
 *
 * @return void
 */
	public function edit_form() {
		$this->autoRender = true;
		$this->set('viewVars', array(
			'model' => 'TestViewElementsEditFormModel',
			'callback' => 'TestBlocks.test_view_elements_edit_form',
			'action' => '/test_blocks/test_ctrl/edit'
		));

		$this->request->data['TestViewElementsEditFormModel'] = array('id' => '1');
	}

}
