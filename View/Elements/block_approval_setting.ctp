<?php
/**
 * Element of block role setting
 *   - $roles:
 *       The results `Roles` data of NetCommonsBlockComponent->getBlockRolePermissions().
 *   - $settingPermissions: Permissions of approval panel
 *       - key: permission
 *       - value: label
 *   - $model: Model name
 *   - $useWorkflow: Field name for use workflow. It is underscore format
 *   - $useCommentApproval: Field name for use comment approval. It is underscore format
 *   - $panelLabel: Panel Label
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/blocks/js/block_role_permissions.js');

//変数初期化
if (! isset($settingPermissions)) {
	$settingPermissions = array();
}
if (! isset($panelLabel)) {
	$panelLabel = __d('blocks', 'Approval settings');
}

//AngularJSのコントローラにセット
$initializeParams = array(
	'roles' => $roles
);
if (isset($useWorkflow)) {
	$initializeParams['useWorkflow'] = (int)$this->request->data[$model][$useWorkflow];
}
if (isset($useCommentApproval)) {
	$initializeParams['useCommentApproval'] = (int)$this->request->data[$model][$useCommentApproval];
}

//承認ラジオボタンの値セット
if (isset($useWorkflow) && $this->request->data[$model][$useWorkflow]) {
	$approvalType = Block::NEED_APPROVAL;
} elseif (isset($useCommentApproval) && $this->request->data[$model][$useCommentApproval]) {
	$approvalType = Block::NEED_COMMENT_APPROVAL;
} else {
	$approvalType = Block::NOT_NEED_APPROVAL;
}
$this->request->data[$model]['approval_type'] = $approvalType;
?>

<div ng-controller="BlockRolePermissions"
	ng-init="initializeApproval(<?php echo h(json_encode($initializeParams, JSON_FORCE_OBJECT)); ?>)">

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo $panelLabel; ?>
		</div>

		<div class="panel-body">
			<div class="form-group">
				<?php if (isset($useWorkflow)) : ?>
					<?php echo $this->Form->hidden($model . '.' . $useWorkflow, array('ng-value' => 'useWorkflow')); ?>
					<?php $this->Form->unlockField($model . '.' . $useWorkflow); ?>
				<?php endif; ?>

				<?php if (isset($useCommentApproval)) : ?>
					<?php echo $this->Form->hidden($model . '.' . $useCommentApproval, array('ng-value' => 'useCommentApproval')); ?>
					<?php $this->Form->unlockField($model . '.' . $useCommentApproval); ?>
				<?php endif; ?>

				<?php echo $this->Form->radio($model . '.approval_type', $options, array(
						'legend' => false,
						'separator' => '<br>',
						'ng-click' => 'clickApprovalType($event)'
					)); ?>
			</div>

			<?php foreach ($settingPermissions as $permission => $label) : ?>
				<div class="form-group">
					<?php echo $this->Form->label('BlockRolePermission.' . $permission, h($label)); ?>
					<?php echo $this->BlockRolePermissionForm->checkboxBlockRolePermission('BlockRolePermission.' . $permission); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
