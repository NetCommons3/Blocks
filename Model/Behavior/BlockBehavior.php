<?php
/**
 * Block Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * Block Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Model\Behavior
 */
class BlockBehavior extends ModelBehavior {

/**
 * Max length of content
 *
 * @var int
 */
	const NAME_LENGTH = 50;

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		$this->settings = Hash::merge($this->settings, $config);
		if (! isset($this->settings['loadModels'])) {
			$this->settings['loadModels'] = array();
		}
	}

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
		if (! isset($model->data['Block'])) {
			return true;
		}

		$model->loadModels(array(
			'Block' => 'Blocks.Block',
		));
		$model->Block->set($model->data['Block']);
		$model->Block->validates();
		if ($model->Block->validationErrors) {
			$model->validationErrors = Hash::merge($model->validationErrors, $model->Block->validationErrors);
			return false;
		}

		return true;
	}

/**
 * Set block field
 *
 * @param Model $model Model using this behavior
 * @param array &$data Model data
 * @param string $field Update field
 * @param string $key Recursive key
 * @param string $value Update value
 * @return void
 */
	private function __setRecursiveBlockField(Model $model, &$data, $field, $key, $value) {
		if (is_string($data[$key])) {
			return;
		}

		if (isset($model->$key)) {
			if ($model->$key->hasField($field)) {
				$data[$key][$field] = $value;
			}
			return;
		}

		foreach (array_keys($data[$key]) as $key2) {
			$this->__setRecursiveBlockField($model, $data[$key], $field, $key2, $value);
		}
	}

/**
 * savePrepare
 *
 * @param Model $model Model using this behavior
 * @param array $frame Frame data
 * @return void
 * @throws InternalErrorException
 */
	private function __saveBlock(Model $model, $frame) {
		$model->data['Block']['room_id'] = $frame['Frame']['room_id'];
		$model->data['Block']['language_id'] = $frame['Frame']['language_id'];

		if (isset($model->data['Block']['name']) && $model->data['Block']['name']) {
			//値があれば、何もしない
		} elseif (isset($this->settings['name'])) {
			list($alias, $filed) = pluginSplit($this->settings['name']);
			$model->data['Block']['name'] = mb_strimwidth(strip_tags($model->data[$alias][$filed]), 0, self::NAME_LENGTH);
		} else {
			$model->data['Block']['name'] = sprintf(__d('blocks', 'Block %s'), date('YmdHis'));
		}

		$model->data['Block']['plugin_key'] = Inflector::underscore($model->plugin);

		//blocksの登録
		if (! $block = $model->Block->save($model->data['Block'], false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		$model->data['Block'] = $block['Block'];
	}

/**
 * beforeSave is called before a model is saved. Returning false from a beforeSave callback
 * will abort the save operation.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False if the operation should abort. Any other result will continue.
 * @see Model::save()
 * @throws InternalErrorException
 */
	public function beforeSave(Model $model, $options = array()) {
		if (! isset($model->data['Frame']['id'])) {
			return parent::beforeSave($model, $options);
		}

		$model->loadModels(array(
			'Block' => 'Blocks.Block',
			'Frame' => 'Frames.Frame',
		));
		if (isset($this->settings['loadModels'])) {
			$model->loadModels($this->settings['loadModels']);
		}

		//frameの取得
		$frame = $model->Frame->findById($model->data['Frame']['id']);
		if (! $frame) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if (! isset($model->data['Block']) && $frame['Frame']['block_id']) {
			return parent::beforeSave($model, $options);
		}

		//blocksの登録
		$this->__saveBlock($model, $frame);

		//framesテーブル更新
		if (! $frame['Frame']['block_id']) {
			$frame['Frame']['block_id'] = (int)$model->data['Block']['id'];
			$model->Frame->save($frame, false);
		}

		//block_id, block_keyのセット
		$keys = array_keys($model->data);
		foreach ($keys as $key) {
			if ($key === 'Frame') {
				continue;
			}

			$this->__setRecursiveBlockField($model, $model->data, 'block_id', $key, $model->data['Block']['id']);

			$this->__setRecursiveBlockField($model, $model->data, 'block_key', $key, $model->data['Block']['key']);
		}

		return parent::beforeSave($model, $options);
	}

/**
 * 後で削除
 *
 * Get Block data
 *
 * @param Model $model Model using this behavior
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @return array Block data
 */
	//public function getBlock(Model $model, $blockId, $roomId) {
	//	$model->Block = ClassRegistry::init('Blocks.Block');
	//
	//	$block = $model->Block->find('first', array(
	//		'recursive' => -1,
	//		'conditions' => array(
	//			'Block.id' => $blockId,
	//			'Block.room_id' => $roomId,
	//		)
	//	));
	//
	//	return $block;
	//}

/**
 * Get conditions
 *
 * @param Model $model Model using this behavior
 * @param array $conditions Model::find conditions default value
 * @return array Conditions data
 */
	public function getBlockConditions(Model $model, $conditions = array()) {
		$conditions = Hash::merge(array(
			'Block.language_id' => Current::read('Language.id'),
			'Block.room_id' => Current::read('Room.id'),
			'Block.plugin_key ' => Current::read('Plugin.key'),
		), $conditions);

		return $conditions;
	}

/**
 * Delete block.
 *
 * @param Model $model Model using this behavior
 * @param string $blockKey blocks.key
 * @return void
 * @throws InternalErrorException
 */
	public function deleteBlock(Model $model, $blockKey) {
		$model->loadModels([
			'Block' => 'Blocks.Block',
			'Frame' => 'Frames.Frame',
		]);

		//Blockデータ取得
		$conditions = array(
			$model->Block->alias . '.key' => $blockKey
		);
		$blocks = $model->Block->find('list', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));

		//Blockデータ削除
		if (! $model->Block->deleteAll($conditions, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$blockIds = array_keys($blocks);
		foreach ($blockIds as $blockId) {
			if (! $model->Frame->updateAll(
					array('Frame.block_id' => null),
					array('Frame.block_id' => (int)$blockId)
			)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		$settings = Hash::merge(
			array('BlockRolePermission' => 'Blocks.BlockRolePermission'),
			$this->settings['loadModels']
		);

		//関連Modelのデータ削除
		$model->loadModels($settings);
		$modelClasses = array_keys($settings);

		foreach ($modelClasses as $class) {
			$result = true;

			if ($model->$class->hasField('block_id')) {
				$result = $model->$class->deleteAll(array($model->$class->alias . '.block_id' => $blockIds), false);
			}
			if ($model->$class->hasField('block_key')) {
				$result = $model->$class->deleteAll(array($model->$class->alias . '.block_key' => $blockKey), false);
			}
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}
	}

}
