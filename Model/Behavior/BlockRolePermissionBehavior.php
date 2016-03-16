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
 * ブロックモデルにアソシエーションがあるモデルのビヘイビアです。<br>
 * ブロックデータの内、ブロック権限にかかわる項目（コンテンツ作成有無など）を処理します。<br>
 * BlockRolePermissionFormHelperで作成される権限配列を登録します。
 *
 * #### 配列サンプル
 * ```
 * $model->data = array(
 * 	'BlockRolePermission' => array(
 * 		'content_creatable' => array(
 * 			general_user' => array(
 * 				'id' => '999',
 * 				'roles_room_id' => '99',
 * 				'block_key' => 'abcdefg',
 * 				'permission' => 'content_creatable'
 * 				'value' => '0'
 * 			),
 * 		'content_comment_creatable' => array(
 * 			'editor' => array(
 * 				'id' => '998',
 * 				'roles_room_id' =>'98'
 * 				'block_key' =>  'abcdefg',
 * 				'permission' => 'content_comment_creatable'
 * 				'value' => '1'
 * 			),
 * 			'general_user' => array(
 * 				'id' => '997',
 * 				'roles_room_id' =>'97'
 * 				'block_key' =>  'abcdefg',
 * 				'permission' => 'content_comment_creatable'
 * 				'value' => '0'
 * 			),
 * 			'visitor' => array(
 * 				'id' => '996',
 * 				'roles_room_id' =>'96'
 * 				'block_key' =>  'abcdefg',
 * 				'permission' => 'content_comment_creatable'
 * 				'value' => '0'
 * 			),
 * 		),
 * 		'content_comment_publishable' => array(
 * 			'editor' => array(
 * 				'id' => '995',
 * 				'roles_room_id' =>'98'
 * 				'block_key' =>  'abcdefg',
 * 				'permission' => 'content_comment_publishable'
 * 				'value' => '0'
 * 			),
 * 		),
 * 	),
 * )
 * ```
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
			if (! $model->BlockRolePermission->validateMany($permission)) {
				$model->validationErrors = Hash::merge($model->validationErrors, $model->BlockRolePermission->validationErrors);
				return false;
			}
		}

		return true;
	}

/**
 * beforeSave is called before a model is saved. Returning false from a beforeSave callback
 * will abort the save operation.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False if the operation should abort. Any other result will continue.
 * @see Model::save()
 */
	public function beforeSave(Model $model, $options = array()) {
		if (! isset($model->data['BlockRolePermission'])) {
			return true;
		}

		if (! isset($model->data['Block']['approval_type'])) {
			return true;
		}
		$approvalType = $model->data['Block']['approval_type'];

		if (! in_array($approvalType, [Block::NOT_NEED_APPROVAL, Block::NEED_APPROVAL, Block::NOT_NEED_APPROVAL], true)) {
			return true;
		}

		$permission = Hash::get($model->data['BlockRolePermission'], 'content_creatable', array());
		foreach ($permission as $roleKey => $role) {
			$model->data['BlockRolePermission']['content_publishable'][$roleKey] = $role;
			if (in_array($approvalType, [Block::NOT_NEED_APPROVAL], true)) {
				$model->data['BlockRolePermission'] = Hash::insert(
					$model->data['BlockRolePermission'], 'content_publishable.' . $roleKey . '.value', Hash::get($role, 'value')
				);
			} else {
				$model->data['BlockRolePermission'] = Hash::insert(
					$model->data['BlockRolePermission'], 'content_publishable.' . $roleKey . '.value', false
				);
			}
		}

		$permission = Hash::get($model->data['BlockRolePermission'], 'content_comment_creatable', array());
		foreach ($permission as $roleKey => $role) {
			$model->data['BlockRolePermission']['content_comment_publishable'][$roleKey] = $role;
			if (in_array((string)Hash::get($model->data, 'Block.approval_type'),
					[Block::NOT_NEED_APPROVAL, Block::NEED_COMMENT_APPROVAL], true)) {

				$model->data['BlockRolePermission'] = Hash::insert(
					$model->data['BlockRolePermission'], 'content_comment_publishable.' . $roleKey . '.value', Hash::get($role, 'value')
				);

			} else {
				$model->data['BlockRolePermission'] = Hash::insert(
					$model->data['BlockRolePermission'], 'content_comment_publishable.' . $roleKey . '.value', false
				);
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

		$model->loadModels(array(
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
		));

		foreach ($model->data['BlockRolePermission'] as $permission) {
			if (! $model->BlockRolePermission->saveMany($permission, ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return parent::afterSave($model, $created, $options);
	}

}
