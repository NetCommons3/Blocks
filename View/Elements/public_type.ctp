<?php
/**
 * public type template
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
				'0' => __d('blocks', 'No display'),
				'1' => __d('blocks', 'Display'),
				'2' => __d('blocks', 'Limited Public'),
			);

			echo $this->Form->radio('Block.public_type', $options, array(
				'value' => isset($block['publicType']) ? $block['publicType'] : '0',
				'legend' => false,
				'separator' => '<br />',
			));

			$publicTypePeriod = $block['publicType'] === '2';
		?>
	</div>

	<div class="col-xs-offset-1 col-xs-11">
		<div class="input-group inline-block" style="margin-left: 20px;">
			<div class="input-group">
				<?php echo $this->Form->time('Block.from', array(
					'value' => (isset($block['from']) ? $block['from'] : null),
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn'
				)); ?>

				<span class="input-group-addon">
					<span class="glyphicon glyphicon-minus"></span>
				</span>

				<?php echo $this->Form->time('Block.to', array(
					'value' => (isset($block['to']) ? $block['to'] : null),
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn'
				)); ?>
			</div>
		</div>
	</div>
</div>
