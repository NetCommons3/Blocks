<?php
/**
 * 後で削除する
 * Element of block role setting
 *   - $roles:
 *       The results `Roles` data of NetCommonsBlockComponent->getBlockRolePermissions(),
 *        and The formatter is camelized data.
 *   - $blockRolePermissions:
 *       The results `BlockRolePermissions` data of NetCommonsBlockComponent->getBlockRolePermissions(),
 *        and The formatter is camelized data.
 *   - $creatablePermissions: Permissions data of creatable panel
 *       - key: permission
 *       - value: label
 *   - $approvalPermissions: Permissions of approval panel
 *       - key: permission
 *       - value: label
 *   - $model: Model name
 *   - $useWorkflow: Field name for use workflow. It is underscore format
 *   - $useCommentApproval: Field name for use comment approval. It is underscore format
 *   - $labels: Labels
 *       - 'creatableSettings'
 *       - 'approvalSettings'
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->Html->script('/blocks/js/block_role_permissions.js', false);

//変数初期化
if (! isset($creatablePermissions)) {
	$creatablePermissions = array();
}
if (! isset($approvalPermissions)) {
	$approvalPermissions = array();
}

//モデルをCamel形式に変換
$variableModel = Inflector::variable($model);

//ラベル
if (! isset($labels)) {
	$labels = array();
}
$labels = Hash::merge(array(
		'creatableSettings' => __d('blocks', 'Creatable settings'),
		'approvalSettings' => __d('blocks', 'Approval settings'),
	), $labels
);

//AngularJSのコントローラにセット
$initializeParams = array(
	'roles' => $roles
);
if (isset($useWorkflow)) {
	$variableUseWorkflow = Inflector::variable($useWorkflow);
	$initializeParams['useWorkflow'] = (int)${$variableModel}[$variableUseWorkflow];
}
if (isset($useCommentApproval)) {
	$variableUseCommentApproval = Inflector::variable($useCommentApproval);
	$initializeParams['useCommentApproval'] = (int)${$variableModel}[$variableUseCommentApproval];
}

//承認ラジオボタンの値セット
if (isset($useWorkflow) && ${$variableModel}[$variableUseWorkflow]) {
	$approvalType = Block::NEED_APPROVAL;
} elseif (isset($useCommentApproval) && ${$variableModel}[$variableUseCommentApproval]) {
	$approvalType = Block::NEED_COMMENT_APPROVAL;
} else {
	$approvalType = Block::NOT_NEED_APPROVAL;
}
?>

<div ng-controller="BlockRolePermissions"
	ng-init="initialize(<?php echo h(json_encode($initializeParams, JSON_FORCE_OBJECT)); ?>)">

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo $labels['creatableSettings']; ?>
		</div>

		<div class="panel-body">
			<?php foreach ($creatablePermissions as $permission => $label) : ?>
				<?php if (isset($blockRolePermissions[$permission])) : ?>
					<div class="form-group">
						<div>
							<strong><?php echo $label; ?></strong>
						</div>
						<div>
							<?php echo $this->element('Blocks.block_role_permission', array(
									'permission' => Inflector::underscore($permission),
									'roles' => $roles,
									'rolePermissions' => $blockRolePermissions[$permission]
								)); ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>

	<?php if ($options) : ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php echo $labels['approvalSettings']; ?>
			</div>

			<div class="panel-body">
				<div class="form-group">
					<?php if (isset($useWorkflow)) : ?>
						<input type="hidden" name="<?php echo 'data[' . $model . '][' . $useWorkflow . ']' ?>" ng-value="useWorkflow">
						<?php $this->Form->unlockField($model . '.' . $useWorkflow); ?>
					<?php endif; ?>

					<?php if (isset($useCommentApproval)) : ?>
						<input type="hidden" name="<?php echo 'data[' . $model . '][' . $useCommentApproval . ']' ?>" ng-value="useCommentApproval">
						<?php $this->Form->unlockField($model . '.' . $useCommentApproval); ?>
					<?php endif; ?>

					<?php echo $this->Form->radio('BbsSetting.approvalType', $options, array(
							'value' => $approvalType,
							'legend' => false,
							'separator' => '<br>',
							'ng-click' => 'clickApprovalType($event)'
						)); ?>
				</div>

				<?php foreach ($approvalPermissions as $permission => $label) : ?>
					<?php if (isset($blockRolePermissions[$permission])) : ?>
						<div class="form-group">
							<div>
								<strong><?php echo $label; ?></strong>
							</div>
							<div>
								<?php echo $this->element('Blocks.block_role_permission', array(
										'permission' => Inflector::underscore($permission),
										'roles' => $roles,
										'rolePermissions' => $blockRolePermissions[$permission]
									)); ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</div>
