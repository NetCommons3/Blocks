<?php
/**
 * Element of comment role permission edit form
 *   - $roles:
 *       The results `Roles` data of NetCommonsBlockComponent->getBlockRolePermissions(),
 *        and The formatter is camelized data.
 *   - $permissions:
 *       The results `BlockRolePermissions` data of NetCommonsBlockComponent->getBlockRolePermissions(),
 *        and The formatter is camelized data.
 *   - $isAutoApproval: Model of is_comment_auto_approval
 *       - name: model name
 *       - value: model value
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<?php echo __d('blocks', 'Comment role settings') ?>
	</div>

	<div class="panel-body">
		<div class="row form-group">
			<div class="col-xs-12">
				<strong><?php echo __d('blocks', 'Creatable roles'); ?></strong>
			</div>
			<div class="col-xs-12">
				<?php echo $this->element('Blocks.block_role_permission', array(
						'permission' => 'comment_creatable',
						'roles' => $roles,
						'rolePermissions' => isset($permissions['commentCreatable']) ? $permissions['commentCreatable'] : null
					)); ?>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-xs-12">
				<strong><?php echo __d('blocks', 'Comment approval'); ?></strong>
			</div>
			<div class="col-xs-12">
				<?php
					$options = array(
						BlockRolePermission::VALUE_DISUSE => __d('blocks', 'Automatic approval'),
						BlockRolePermission::VALUE_USE => __d('blocks', 'Need approval')
					);
					echo $this->Form->radio($isAutoApproval['name'], $options, array(
							'value' => (int)$isAutoApproval['value'],
							'legend' => false,
							'class' => 'form-inline',
							'separator' => '<span class="inline-block"></span>',
						));
				?>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-xs-offset-1 col-xs-11">
				<strong><?php echo __d('blocks', 'Publishable roles'); ?></strong>
			</div>

			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->element('Blocks.block_role_permission', array(
						'permission' => 'comment_publishable',
						'roles' => $roles,
						'rolePermissions' => isset($permissions['commentPublishable']) ? $permissions['commentPublishable'] : null
					)); ?>
			</div>
		</div>
	</div>
</div>
