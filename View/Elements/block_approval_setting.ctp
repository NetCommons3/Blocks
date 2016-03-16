<?php
/**
 * コンテンツの承認権限設定Element
 * WorkflowComponent->getBlockRolePermissions())で取得した結果をもとにセットする
 *
 * - settingPermissions: 設定するパーミッションデータ(key: パーミッション名、value: ラベル)
 * - model: モデル名
 * - useWorkflow: コンテンツ承認使用有無のフィールド名
 * - useCommentApproval: コンテンツコメント承認使用有無のフィールド名
 * - panelLabel: パネルのタイトル名
 *
 * ### サンプル1（コメントあり）
 * ```
 * 	echo $this->element('Blocks.block_approval_setting', array(
 * 			'model' => 'BbsSetting',
 * 			'useWorkflow' => 'use_workflow',
 * 			'useCommentApproval' => 'use_comment_approval',
 * 			'settingPermissions' => array(
 * 				'content_comment_publishable' => __d('blocks', 'Content comment publishable roles'),
 * 			),
 * 			'options' => array(
 * 				Block::NEED_APPROVAL => __d('blocks', 'Need approval in both %s and comments ', __d('bbses', 'articles')),
 * 				Block::NEED_COMMENT_APPROVAL => __d('blocks', 'Need only comments approval'),
 * 				Block::NOT_NEED_APPROVAL => __d('blocks', 'Not need approval'),
 * 			),
 * 		));
 * ```
 *
 * ### サンプル2（コメントなし）
 * ```
 * 	echo $this->element('Blocks.block_approval_setting', array(
 * 			'model' => 'FaqSetting',
 * 			'useWorkflow' => 'use_workflow',
 * 			'options' => array(
 * 				Block::NEED_APPROVAL => __d('blocks', 'Need approval'),
 * 				Block::NOT_NEED_APPROVAL => __d('blocks', 'Not need approval'),
 * 			),
 * 		));
 * ```
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

//承認ラジオボタンの値セット
if (isset($useWorkflow) && $this->request->data[$model][$useWorkflow]) {
	if (Current::read('Room.need_approval')) {
		$approvalType = Block::NEED_APPROVAL;
	} else {
		$approvalType = Block::NOT_NEED_APPROVAL;
	}
} elseif (isset($useCommentApproval) && $this->request->data[$model][$useCommentApproval]) {
	$approvalType = Block::NEED_COMMENT_APPROVAL;
} else {
	$approvalType = Block::NOT_NEED_APPROVAL;
}
$this->request->data[$model]['approval_type'] = $approvalType;

if (isset($useWorkflow)) {
	if ($approvalType === Block::NEED_APPROVAL) {
		$initializeParams['useWorkflow'] = 1;
		$this->request->data[$model][$useWorkflow] = 1;
	} else {
		$initializeParams['useWorkflow'] = 0;
		$this->request->data[$model][$useWorkflow] = 0;
	}
}
if (isset($useCommentApproval)) {
	if ($approvalType === Block::NEED_APPROVAL ||
			$approvalType === Block::NEED_COMMENT_APPROVAL) {
		$initializeParams['useCommentApproval'] = 1;
		$this->request->data[$model][$useCommentApproval] = 1;
	} else {
		$initializeParams['useCommentApproval'] = 0;
		$this->request->data[$model][$useCommentApproval] = 0;
	}
}
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
					<?php echo $this->NetCommonsForm->hidden($model . '.' . $useWorkflow, array('ng-value' => 'useWorkflow')); ?>
					<?php $this->NetCommonsForm->unlockField($model . '.' . $useWorkflow); ?>
				<?php endif; ?>

				<?php if (isset($useCommentApproval)) : ?>
					<?php echo $this->NetCommonsForm->hidden($model . '.' . $useCommentApproval, array('ng-value' => 'useCommentApproval')); ?>
					<?php $this->NetCommonsForm->unlockField($model . '.' . $useCommentApproval); ?>
				<?php endif; ?>


				<?php
					foreach ($options as $key => $label) {
						echo $this->NetCommonsForm->radio($model . '.approval_type', array($key => $label), array(
							'legend' => false,
							'ng-click' => 'clickApprovalType($event)',
							'disabled' => Current::read('Room.need_approval') && $key !== Block::NEED_APPROVAL
						));
						echo '<br>';
					}
				?>
			</div>

			<?php foreach ($settingPermissions as $permission => $label) : ?>
				<div class="form-group">
					<?php echo $this->NetCommonsForm->label('BlockRolePermission.' . $permission, h($label)); ?>
					<?php echo $this->BlockRolePermissionForm->checkboxBlockRolePermission('BlockRolePermission.' . $permission); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
