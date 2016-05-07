<?php
/**
 * Not found block template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<?php echo $this->MessageFlash->description(
			'<div class="block-index-desc">' .
			sprintf(
				__d('blocks', 'When you newly created, %s, please click.'),
				'<button class="btn btn-success btn-xs">' .
					'<span class="glyphicon glyphicon-plus"></span>' .
				'</button> '
			) .
			'</div>'
		); ?>

	<div class="tab-content">
		<div class="text-right">
			<?php echo $this->Button->addLink(); ?>
		</div>

		<div class="text-left">
			<?php echo __d('net_commons', 'Not found.'); ?>
		</div>
	</div>

</div>
