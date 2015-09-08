<?php
/**
 * Element of public type form
 *   - $block: Block data.
 *       - publicType: The `public_type` field of blocks table.
 *       - from: The `from` field of blocks table.
 *       - to: The `to` field of blocks table.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->label('Block.public_type', __d('blocks', 'Publishing setting')); ?>
	</div>

	<div class="col-xs-offset-1 col-xs-11">
		<?php
			$options = array(
				Block::TYPE_PRIVATE => __d('blocks', 'Private'),
				Block::TYPE_PUBLIC => __d('blocks', 'Public'),
				Block::TYPE_LIMITED => __d('blocks', 'Limited'),
			);

			echo $this->Form->radio('Block.public_type', $options, array(
				'legend' => false,
				'separator' => '<br />',
			));

			$publicTypePeriod = $this->data['Block']['public_type'] === Block::TYPE_LIMITED;
		?>
	</div>

	<div class="col-xs-offset-1 col-xs-11">
		<div class="input-group inline-block" style="margin-left: 20px;">
			<div class="input-group">
				<?php echo $this->Form->time('Block.from', array(
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn'
				)); ?>

				<span class="input-group-addon">
					<span class="glyphicon glyphicon-minus"></span>
				</span>

				<?php echo $this->Form->time('Block.to', array(
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn'
				)); ?>
			</div>
		</div>
	</div>
</div>
