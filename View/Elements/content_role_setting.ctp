<?php
/**
 * The content role permission elements
 *   - $roles: The results `Roles` data of NetCommonsBlockComponent->getBlockRolePermissions(),
 *             and The formatter is camelized data.
 *   - $permissions:
 *             The results `BlockRolePermissions` data of NetCommonsBlockComponent->getBlockRolePermissions(),
 *             and The formatter is camelized data.
 *   - $useWorkflow: Model of use_workflow
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
		<?php echo __d('blocks', 'Content role settings') ?>
	</div>

	<div class="panel-body has-feedback">
		<div class="row form-group">
			<div class="col-xs-12">
				<strong><?php echo __d('blocks', 'Creatable roles'); ?></strong>
			</div>
			<div class="col-xs-12">
				<?php echo $this->element('Blocks.block_role_permission', array(
						'permission' => 'content_creatable',
						'roles' => $roles,
						'rolePermissions' => isset($permissions['contentCreatable']) ? $permissions['contentCreatable'] : null
					)); ?>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-xs-12">
				<strong><?php echo __d('blocks', 'Content approval'); ?></strong>
			</div>
			<div class="col-xs-12">
				<?php
					$options = array(
						BlockRolePermission::VALUE_DISUSE => __d('blocks', 'Disuse'),
						BlockRolePermission::VALUE_USE => __d('blocks', 'Use')
					);
					echo $this->Form->radio($useWorkflow['name'], $options, array(
							'value' => (int)$useWorkflow['value'],
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
						'permission' => 'content_publishable',
						'roles' => $roles,
						'rolePermissions' => isset($permissions['contentPublishable']) ? $permissions['contentPublishable'] : null
					)); ?>
			</div>
		</div>
	</div>
</div>


