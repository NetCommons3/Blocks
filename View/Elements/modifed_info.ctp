<?php
/**
 * ブロック編集情報Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if ($this->params['action'] !== 'add') : ?>
	<div class="row form-group">
		<div class="col-sm-6 col-xs-12">
			<?php echo $this->NetCommonsForm->input('TrackableCreator', array(
					'type' => 'handle',
					'label' => __d('net_commons', 'Created user'),
					'error' => false,
				)); ?>
		</div>
		<div class="col-sm-6 col-xs-12">
			<?php echo $this->NetCommonsForm->input('Block.created', array(
					'type' => 'label',
					'label' => __d('net_commons', 'Created datetime'),
					'error' => false,
					'div' => false,
				)); ?>
		</div>
	</div>

	<div class="row form-group">
		<div class="col-sm-6 col-xs-12">
			<?php echo $this->NetCommonsForm->input('TrackableUpdater', array(
					'type' => 'handle',
					'label' => __d('net_commons', 'Modified user'),
					'error' => false,
				)); ?>
		</div>
		<div class="col-sm-6 col-xs-12">
			<?php echo $this->NetCommonsForm->input('Block.modified', array(
					'type' => 'label',
					'label' => __d('net_commons', 'Modified datetime'),
					'error' => false,
				)); ?>
		</div>
	</div>
<?php endif;