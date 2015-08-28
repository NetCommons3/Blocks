<?php
/**
 * Element of block delete form
 *   - $model: Controller for delete request.
 *   - $action: Action for delete request.
 *   - $callback: Callback element for parameters and messages.
 *   - $callbackOptions: Callback options for element.
 *   - $options: Options array for Form->create()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$this->NetCommonsHtml->css('/blocks/css/style.css');

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

<div class="block-danger-zone" ng-init="dangerZone=false;">
	<?php echo $this->Form->create($model, Hash::merge(array('type' => 'delete'), $options)); ?>
		<accordion close-others="false">
			<accordion-group is-open="dangerZone" class="panel-danger">
				<accordion-heading class="clearfix">
					<span style="cursor: pointer">
						<?php echo __d('net_commons', 'Danger Zone'); ?>
					</span>
					<span class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': dangerZone, 'glyphicon-chevron-right': ! dangerZone}"></span>
				</accordion-heading>

				<?php echo $this->element($callback, (isset($callbackOptions) ? $callbackOptions : array())); ?>
			</accordion-group>
		</accordion>
	<?php echo $this->Form->end(); ?>
</div>
