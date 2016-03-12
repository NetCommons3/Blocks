<?php
/**
 * View/Elements/block_approval_settingテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/block_approval_settingテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestViewElementsBlockApprovalSettingController extends AppController {

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockRolePermissionForm'
	);

/**
 * サンプル1のテスト
 *
 * @return void
 */
	public function block_approval_setting() {
		$this->autoRender = true;

		$viewVars['model'] = 'TestBlockSetting';
		$viewVars['useWorkflow'] = 'use_workflow';

		if ($this->request->query['use_comment']) {
			$permissions = $this->Workflow->getBlockRolePermissions(
				array('content_publishable', 'content_comment_publishable')
			);
			$viewVars['useCommentApproval'] = 'use_comment_approval';
			$viewVars['settingPermissions'] = array(
				'content_comment_publishable' => 'Label content_comment_publishable'
			);
			$viewVars['options'] = array(
				Block::NEED_APPROVAL => 'Label need_approval',
				Block::NEED_COMMENT_APPROVAL => 'Label comment_approval',
				Block::NOT_NEED_APPROVAL => 'Label not_need_approval',
			);
		} else {
			$permissions = $this->Workflow->getBlockRolePermissions(
				array('content_publishable')
			);
			$viewVars['options'] = array(
				Block::NEED_APPROVAL => 'Label need_approval',
				Block::NOT_NEED_APPROVAL => 'Label not_need_approval',
			);
		}
		$this->set('roles', $permissions['Roles']);
		$this->request->data['BlockRolePermission'] = $permissions['BlockRolePermissions'];
		$this->request->data['TestBlockSetting'] = array(
			'use_workflow' => ($this->request->query['approval_type'] === '1'),
			'use_comment_approval' => in_array($this->request->query['approval_type'], ['1', '2'], true),
			'approval_type' => $this->request->query['approval_type']
		);

		$this->set('viewVars', $viewVars);
	}

}
