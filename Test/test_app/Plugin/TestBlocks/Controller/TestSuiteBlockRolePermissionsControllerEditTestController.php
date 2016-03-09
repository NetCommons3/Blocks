<?php
/**
 * BlockRolePermissionsControllerEditTestテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * BlockRolePermissionsControllerEditTestテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestSuiteBlockRolePermissionsControllerEditTestController extends AppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'TestBlocks.TestSuiteBlockRolePermissionsControllerEditTestModel',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->autoRender = true;
		$this->set('username', Current::read('User.username'));

		$this->request->data['Block'] = array(
			'id' => '4'
		);
		$this->request->data['BlockRolePermission'] = array(
			'content_creatable' => array(
				'general_user' => array(
					'id' => '1',
					'roles_room_id' => '4',
					'block_key' => 'block_1',
					'permission' => 'content_creatable',
					'value' => true,
				),
			),
			'content_comment_creatable' => array(
				'editor' => array(
					'id' => '',
					'roles_room_id' => '3',
					'block_key' => 'block_1',
					'permission' => 'content_comment_creatable',
					'value' => true,
				),
				'general_user' => array(
					'id' => '',
					'roles_room_id' => '4',
					'block_key' => 'block_1',
					'permission' => 'content_comment_creatable',
					'value' => true,
				),
				'visitor' => array(
					'id' => '',
					'roles_room_id' => '5',
					'block_key' => 'block_1',
					'permission' => 'content_comment_creatable',
					'value' => false,
				),
			),
		);
	}

}
