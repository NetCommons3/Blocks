<?php
/**
 * Element of public type form
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

ClassRegistry::init('Blocks.Block');
?>

<div class="form-group">
	<?php echo $this->NetCommonsForm->label('Block.public_type', __d('blocks', 'Publishing setting')); ?>

	<div class="form-input-outer">
		<?php
			$options = array(
				Block::TYPE_PRIVATE => __d('blocks', 'Private'),
				Block::TYPE_PUBLIC => __d('blocks', 'Public'),
				Block::TYPE_LIMITED => __d('blocks', 'Limited'),
			);
			echo $this->NetCommonsForm->radio('Block.public_type', $options);

			$publicTypePeriod = Hash::get($this->data, 'Block.public_type') === Block::TYPE_LIMITED;
		?>

		<div class="input-group inline-block input-indent">
			<div class="input-group">
				<?php echo $this->NetCommonsForm->input('Block.publish_start', array(
					'type' => 'datetime',
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn',
					'div' => false,
					'error' => false,
				)); ?>

				<span class="input-group-addon">
					<span class="glyphicon glyphicon-minus"></span>
				</span>

				<?php echo $this->NetCommonsForm->input('Block.publish_end', array(
					'type' => 'datetime',
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn',
					'div' => false,
					'error' => false,
				)); ?>
			</div>
		</div>
	</div>
</div>
