<?php
/**
 * 後で削除する
 *
 * Element of BlockRolePermission settings
 *   - $permission:
 *       A key name of permission.
 *   - $roles:
 *       The results `Roles` data of NetCommonsBlockComponent->getBlockRolePermissions(),
 *         and The formatter is camelized data.
 *   - $rolePermissions:
 *       The results `BlockRolePermissions` data of NetCommonsBlockComponent->getBlockRolePermissions(),
 *        and The formatter is camelized data.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php foreach ($roles as $key => $role) : ?>
	<?php if (isset($rolePermissions[$key])) : ?>
		<div class="inline-block">
			<?php
				$name = 'BlockRolePermission.' . $permission . '.' . Inflector::underscore($key);
				$rolesRoomId = (int)$rolePermissions[$key]['rolesRoomId'];

				if (! $rolePermissions[$key]['fixed']) {
					echo $this->Form->checkbox($name . '.value', array(
							'div' => false,
							'checked' => (int)$rolePermissions[$key]['value'],
							'ng-click' => 'clickRole($event, \'' . $permission . '\', \'' . h($key) . '\')'
						));

					echo $this->Form->label($name . '.value', h($role['name']));

					echo $this->Form->hidden($name . '.id', array(
							'value' => isset($rolePermissions[$key]['id']) ? (int)$rolePermissions[$key]['id'] : null,
						));

					echo $this->Form->hidden($name . '.roles_room_id', array(
							'value' => $rolesRoomId,
						));

					echo $this->Form->hidden($name . '.block_key', array(
							'value' => $blockKey,
						));

					echo $this->Form->hidden($name . '.permission', array(
							'value' => $permission,
						));
				}
				if ($rolePermissions[$key]['fixed'] && $rolePermissions[$key]['value']) {
					echo $this->Form->checkbox($name . '.value', array(
							'div' => false,
							'disabled' => true,
							'checked' => (int)$rolePermissions[$key]['value'],
						));

					echo $this->Form->label('', h($role['name']));
				}
			?>
		</div>
	<?php endif; ?>
<?php endforeach;

