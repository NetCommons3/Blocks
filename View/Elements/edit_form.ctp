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

//後で削除する
if (isset($controller)) {
	$model = $controller;
}
?>

<?php echo $this->Form->create($model, Hash::merge(array('novalidate' => true, 'action' => $action), $options)); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->element($callback, (isset($callbackOptions) ? $callbackOptions : array())); ?>
		</div>

		<div class="panel-footer text-center">
			<button type="button" class="btn btn-default btn-workflow" onclick="location.href = '<?php echo $this->Html->url('/' . $cancelUrl); ?>'">
				<span class="glyphicon glyphicon-remove"></span>
				<?php echo __d('net_commons', 'Cancel'); ?>
			</button>

			<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
					'class' => 'btn btn-primary btn-workflow',
					'name' => 'save',
				)); ?>
		</div>
	</div>
<?php echo $this->Form->end();
