<?php
/**
 * Element of block edit form
 *   - $model: Model for edit request.
 *   - $action: Action for delete request.
 *   - $callback: Callback element for parameters and messages.
 *   - $callbackOptions: Callback options for element.
 *   - $cancelUrl: Cancel url.
 *   - $options: Options array for Form->create()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

if (! isset($options)) {
	$options = array();
}
if (isset($action)) {
	$options['action'] = $action;
}

//後で削除する
if (isset($controller)) {
	$model = $controller;
}
?>

<?php echo $this->Form->create($model, Hash::merge(array('novalidate' => true), $options)); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->element($callback, (isset($callbackOptions) ? $callbackOptions : array())); ?>
		</div>

		<div class="panel-footer text-center">
			<?php echo $this->NetCommonsForm->cancelButton(__d('net_commons', 'Cancel'), $cancelUrl); ?>

			<?php echo $this->NetCommonsForm->saveButton(__d('net_commons', 'OK')); ?>
		</div>
	</div>
<?php echo $this->Form->end();
