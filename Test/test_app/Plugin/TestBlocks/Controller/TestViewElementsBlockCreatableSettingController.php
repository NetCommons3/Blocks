<?php
/**
 * View/Elements/block_creatable_settingテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/block_creatable_settingテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestViewElementsBlockCreatableSettingController extends AppController {

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockRolePermissionForm'
	);

/**
 * block_creatable_setting
 *
 * @return void
 */
	public function block_creatable_setting() {
		$this->autoRender = true;

		$permissions = $this->Workflow->getBlockRolePermissions(
			array('content_creatable', 'content_comment_creatable')
		);
		$this->set('roles', $permissions['Roles']);

		$viewVars['settingPermissions'] = array(
			'content_creatable' => 'Label content_creatable',
			'content_comment_creatable' => 'Label content_comment_creatable',
		);

		$this->set('viewVars', $viewVars);

		$this->request->data['BlockRolePermission'] = $permissions['BlockRolePermissions'];
	}

}
