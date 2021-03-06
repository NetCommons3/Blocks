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

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->NetCommonsForm->label('Block.public_type', __d('blocks', 'Publishing setting')); ?>
		<?php
			$options = array(
				Block::TYPE_PUBLIC => __d('blocks', 'Setting public'),
				Block::TYPE_PRIVATE => __d('blocks', 'Setting private'),
				Block::TYPE_LIMITED => __d('blocks', 'Setting limited public'),
			);
			echo $this->NetCommonsForm->radio('Block.public_type', $options, array('outer' => true));
		?>
	</div>

	<div class="col-xs-11 col-xs-offset-1">
		<div class="form-inline">
			<div class="input-group">
				<?php echo $this->NetCommonsForm->input('Block.publish_start', array(
					'type' => 'datetime',
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn',
					'div' => false,
					'error' => false,
					'default' => false,
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
					'default' => false,
				)); ?>
			</div>
		</div>
	</div>
</div>
