<?php
/**
 * Element of setting tabs
 *   - $tabs: Array data is 'block_settings' => URL1 or 'role_permissions' => URL3.
 *   - $active: Active tab key. Value is 'block_edit or 'role_permissions'.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="nav nav-pills" role="tablist">
	<?php if (isset($tabs['block_settings'])) : ?>
		<li class="<?php echo ($active === 'block_settings' ? 'active' : ''); ?>">
			<a href="<?php echo $this->Html->url($tabs['block_settings']); ?>">
				<?php echo __d('net_commons', 'Block settings'); ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if ($this->request->params['action'] === 'edit' && isset($tabs['role_permissions'])) : ?>
		<li class="<?php echo ($active === 'role_permissions' ? 'active' : ''); ?>">
			<a href="<?php echo $this->Html->url($tabs['role_permissions']); ?>">
				<?php echo __d('net_commons', 'Role permission settings'); ?>
			</a>
		</li>
	<?php endif; ?>
</ul>
<br />
