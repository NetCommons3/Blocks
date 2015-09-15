<?php
/**
 * Setting tabs template
 *   - $tabs: Array data is 'block_index' => URL1 or 'frame_settings' => URL2 or 'role_permissions' => URL3.
 *       - URL1, URL2, URL3: Array data is array('url' => 'URL', 'label' => 'Label')
 *   - $active: Active tab key. Value is 'block_index or 'frame_settings' or 'role_permissions'.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="nav nav-tabs" role="tablist">
	<?php if (isset($tabs['block_index'])) : ?>
		<li class="<?php echo ($active === 'block_index' ? 'active' : ''); ?>">
			<a href="<?php echo $this->Html->url($tabs['block_index']['url']); ?>">
				<?php echo __d('net_commons', 'List'); ?>
			</a>
		</li>
		<?php
			unset($tabs['block_index']);
		?>
	<?php endif; ?>

	<?php if (isset($tabs['frame_settings'])) : ?>
		<li class="<?php echo ($active === 'frame_settings' ? 'active' : ''); ?>">
			<a href="<?php echo $this->Html->url($tabs['frame_settings']['url']); ?>">
				<?php echo __d('net_commons', 'Frame settings'); ?>
			</a>
		</li>
		<?php
			unset($tabs['frame_settings']);
		?>
	<?php endif; ?>

	<?php if (isset($tabs['role_permissions'])) : ?>
		<?php if ($blockPermissionEditable) : ?>
			<li class="<?php echo ($active === 'role_permissions' ? 'active' : ''); ?>">
				<a href="<?php echo $this->Html->url($tabs['role_permissions']['url']); ?>">
					<?php echo __d('net_commons', 'Role permission settings'); ?>
				</a>
			</li>
		<?php endif; ?>
		<?php
			unset($tabs['role_permissions']);
		?>
	<?php endif; ?>

	<?php if ($tabs) : ?>
		<?php foreach ($tabs as $tabKey => $tab) : ?>
			<li class="<?php echo ($active === $tabKey ? 'active' : ''); ?>">
				<a href="<?php echo $this->Html->url($tab['url']); ?>">
					<?php echo (isset($tab['label']) ? $tab['label'] : $tabKey); ?>
				</a>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<br />
