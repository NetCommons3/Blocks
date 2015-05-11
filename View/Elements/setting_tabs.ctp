<?php
/**
 * Element of setting tabs
 *   - $tabs: Array data is 'block_settings' => URL1 or 'role_permissions' => URL3.
 *       - URL1, URL2, URL3: Array data is array('url' => 'URL', 'label' => 'Label')
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
			<a href="<?php echo $this->Html->url($tabs['block_settings']['url']); ?>">
				<?php echo __d('net_commons', 'Block settings'); ?>
			</a>
		</li>
		<?php
			unset($tabs['block_settings']);
		?>
	<?php endif; ?>

	<?php if (isset($tabs['role_permissions'])) : ?>
		<?php if ($this->request->params['action'] === 'edit') : ?>
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
