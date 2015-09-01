<?php
/**
 * BlockRolePermission Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * BlockRolePermission Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Model\Behavior
 */
class BlockRolePermissionBehavior extends ModelBehavior {

/**
 * beforeValidate is called before a model is validated, you can use this callback to
 * add behavior validation rules into a models validate array. Returning false
 * will allow you to make the validation fail.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False or null will abort the operation. Any other result will continue.
 * @see Model::save()
 */
	public function beforeValidate(Model $model, $options = array()) {
		if (! isset($model->data['BlockRolePermission'])) {
			return true;
		}

		$model->loadModels(array(
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
		));

		foreach ($model->data[$model->BlockRolePermission->alias] as $permission) {
			$model->BlockRolePermission->validateMany($permission);
			if ($model->BlockRolePermission->validationErrors) {
				$model->validationErrors = Hash::merge($model->validationErrors, $model->BlockRolePermission->validationErrors);
				return false;
			}
		}

		return true;
	}

/**
 * afterSave is called after a model is saved.
 *
 * @param Model $model Model using this behavior
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return bool
 * @throws InternalErrorException
 * @see Model::save()
 */
	public function afterSave(Model $model, $created, $options = array()) {
		if (! isset($model->data['BlockRolePermission'])) {
			return true;
		}

		foreach ($model->data['BlockRolePermission'] as $permission) {
			if (! $model->BlockRolePermission->saveMany($permission, ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return parent::afterSave($model, $created, $options);
	}

}
