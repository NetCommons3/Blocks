<?php
/**
 * Element of block role setting
 *   - $roles:
 *       The results `Roles` data of NetCommonsBlockComponent->getBlockRolePermissions().
 *   - $settingPermissions: Permissions data of creatable panel
 *       - key: permission
 *       - value: label
 *   - $panelLabel: Panel Label
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/blocks/js/block_role_permissions.js');

//ラベル
if (! isset($panelLabel)) {
	$panelLabel = __d('blocks', 'Creatable settings');
}

//Camel形式に変換
$initializeParams = NetCommonsAppController::camelizeKeyRecursive(array('roles' => $roles));
?>

<div ng-controller="BlockRolePermissions"
	ng-init="initializeRoles(<?php echo h(json_encode($initializeParams, JSON_FORCE_OBJECT)); ?>)">

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo $panelLabel; ?>
		</div>

		<div class="panel-body">
			<?php foreach ($settingPermissions as $permission => $label) : ?>
				<div class="form-group">
					<?php echo $this->Form->label('BlockRolePermission.' . $permission, h($label)); ?>
					<?php echo $this->BlockRolePermissionForm->checkboxBlockRolePermission('BlockRolePermission.' . $permission); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
