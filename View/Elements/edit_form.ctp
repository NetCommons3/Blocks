<?php
/**
 * Blocks edit template
 *   - $controller: Controller for delete request.
 *   - $action: Action for delete request.
 *   - $callback: Callback element for parameters and messages.
 *   - $callbackOptions: Callback options for element.
 *   - $cancel: Cancel url.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->create($controller, array('novalidate' => true, 'action' => $action)); ?>
	<div class="panel panel-default">
		<div class="panel-body has-feedback">
			<?php echo $this->element($callback, (isset($callbackOptions) ? $callbackOptions : array())); ?>
		</div>

		<div class="panel-footer text-center">
			<button type="button" class="btn btn-default btn-workflow" onclick="location.href = '<?php echo $cancel; ?>'">
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
