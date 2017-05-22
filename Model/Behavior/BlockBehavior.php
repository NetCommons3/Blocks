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
App::uses('Block', 'Blocks.Model');

/**
 * Block Behavior
 *
 * ブロックモデルにアソシエーションがあるモデルのビヘイビアです。<br>
 * ブロックデータの内、ブロック編集にかかわる項目（名称、公開期限）を処理します。<br>
 *
 * #### 設定項目
 * ##### name
 * ブロック名称フィールドを指定すると、ブロックモデルの名称として登録されます。<br>
 * お知らせなど名称がない場合でも名称となり得るフィールドを指定してください。
 * [NAME_LENGTH](#name_length)の長さで登録されます。<br>
 *
 * ##### loadModels
 * 他にアソシエーションがあるモデルがある場合は、loadModelsに指定してください。<br>
 * ブロックデータ登録後、指定されたモデルのblock_id、block_keyに値がセットされます。<br>
 * ブロック削除時には指定されたモデルから削除されます。<br>
 *
 * #### サンプルコード
 * ```
 * public $actsAs = array(
 * 	'Blocks.Block' => array(
 * 		'name' => 'Faq.name',
 * 		'loadModels' => array(
 * 			'Category' => 'Categories.Category',
 * 			'CategoryOrder' => 'Categories.CategoryOrder',
 * 			'WorkflowComment' => 'Workflow.WorkflowComment',
 * 		)
 * 	)
 * )
 * ```
 *
 * ブロックデータを取得する場合の条件<br>
 * [getBlockConditions](https://github.com/kteraguchi/test/blob/master/README.md#getblockconditions)<br>
 * [getBlockConditionById](https://github.com/kteraguchi/test/blob/master/README.md#getblockconditionbyid)<br>
 *
 * 登録時は自動的に登録しますが、削除は明示的に呼び出してください。<br>
 * [deleteBlock](https://github.com/kteraguchi/test/blob/master/README.md#deleteblock)<br>
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Model\Behavior
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class BlockBehavior extends ModelBehavior {

/**
 * Max length of content
 *
 * 名称が長い場合に切り取る文字数
 *
 * @var int
 */
	const NAME_LENGTH = 255;

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		parent::setup($model, $config);

		$this->settings = Hash::merge($this->settings, $config);
		$this->settings['loadModels'] = Hash::get($this->settings, 'loadModels', array());

		//ビヘイビアの優先順位
		$this->settings['priority'] = 6;
	}

/**
 * beforeValidate is called before a model is validated, you can use this callback to
 * add behavior validation rules into a models validate array. Returning false
 * will allow you to make the validation fail.
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param array $options Options passed from Model::save().
 * @return mixed False or null will abort the operation. Any other result will continue.
 * @see Model::save()
 */
	public function beforeValidate(Model $model, $options = array()) {
		if (! isset($model->data['Block'])) {
			return true;
		}

		if (Hash::get($model->data, 'Block.public_type') !== Block::TYPE_LIMITED) {
			$model->data = Hash::remove($model->data, 'Block.publish_start');
			$model->data = Hash::remove($model->data, 'Block.publish_end');
		}

		$model->loadModels(array(
			'Block' => 'Blocks.Block',
			'BlocksLanguage' => 'Blocks.BlocksLanguage',
		));
		$model->Block->set($model->data['Block']);
		if (! $model->Block->validates()) {
			$model->validationErrors = Hash::merge(
				$model->validationErrors, $model->Block->validationErrors
			);
			return false;
		}

		return true;
	}

/**
 * beforeSave is called before a model is saved. Returning false from a beforeSave callback
 * will abort the save operation.
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param array $options Options passed from Model::save().
 * @return mixed False if the operation should abort. Any other result will continue.
 * @see Model::save()
 */
	public function beforeSave(Model $model, $options = array()) {
		if ($this->saveBlock($model)) {
			return parent::beforeSave($model, $options);
		} else {
			return false;
		}
	}

/**
 * Blockの登録処理
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @return bool
 * @throws InternalErrorException
 */
	public function saveBlock(Model $model) {
		$model->loadModels(array(
			'Block' => 'Blocks.Block',
			'BlocksLanguage' => 'Blocks.BlocksLanguage',
			'Frame' => 'Frames.Frame',
		));
		$model->loadModels(Hash::get($this->settings, 'loadModels', array()));

		if (isset($model->data['Frame']['id'])) {
			//frameの取得
			$frame = $model->Frame->findById($model->data['Frame']['id']);
			if (! $frame) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! isset($model->data['Block']) && $frame['Frame']['block_id']) {
				return true;
			}
		} else {
			$frame = array();
		}

		//blocksの登録
		$this->__saveBlock($model, $frame);

		//framesテーブル更新
		if ($frame && ! $frame['Frame']['block_id']) {
			$frame['Frame']['block_id'] = (int)$model->data['Block']['id'];
			$model->Frame->save($frame, false);
		}

		//block_id, block_keyのセット
		$this->__setBlockFields($model);

		return true;
	}

/**
 * $model->dataのblock_idとblock_keyに値をセットする
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @return void
 */
	private function __setBlockFields(Model $model) {
		if ($model->hasField('block_id')) {
			$model->data[$model->alias]['block_id'] = $model->data['Block']['id'];
		}
		if ($model->hasField('block_key')) {
			$model->data[$model->alias]['block_key'] = $model->data['Block']['key'];
		}

		$modelData = Hash::remove($model->data, 'Frame');
		$keys = array_keys($modelData);
		foreach ($keys as $key) {
			$this->__setRecursiveBlockField(
				$model, $model->data, 'block_id', $key, $model->data['Block']['id']
			);
			$this->__setRecursiveBlockField(
				$model, $model->data, 'block_key', $key, $model->data['Block']['key']
			);
		}
	}

/**
 * $model->dataのblock_idとblock_keyに値をセットする
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param array &$data セットするデータ
 * @param string $field フィールド名
 * @param string $key 再帰処理するKey
 * @param string $value 更新する値
 * @return void
 */
	private function __setRecursiveBlockField(Model $model, &$data, $field, $key, $value) {
		if (!is_array($data[$key])) {
			return;
		}
		if (is_object($model->$key)) {
			if (! $model->$key->hasField($field)) {
				return;
			}
		}

		if (array_key_exists($field, $data[$key])) {
			$data[$key][$field] = $value;
			return;
		}

		foreach (array_keys($data[$key]) as $key2) {
			if (is_numeric($key2) && isset($data[$key][$key2][$field])) {
				$data[$key][$key2][$field] = $value;
				continue;
			}
			$this->__setRecursiveBlockField($model, $data[$key], $field, $key2, $value);
		}
	}

/**
 * savePrepare
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param array $frame Frameデータ
 * @return void
 * @throws InternalErrorException
 */
	private function __saveBlock(Model $model, $frame) {
		$roomId = Hash::get(
			$model->data,
			'Block.room_id',
			Hash::get($frame, 'Frame.room_id', Current::read('Room.id'))
		);
		$model->data['Block']['room_id'] = $roomId;

		$langId = Hash::get($model->data, 'BlocksLanguage.language_id');
		if (! $langId) {
			$langId = Current::read('Language.id');
		}

		$model->data['BlocksLanguage']['language_id'] = $langId;

		$model->data['Block'] = Hash::insert($model->data['Block'], 'modified', null);

		$model->data['BlocksLanguage']['name'] = $this->__getBlockName($model);
		$model->data['Block']['plugin_key'] = Inflector::underscore($model->plugin);

		//blocksの登録
		$block = $model->Block->save($model->data['Block'], false);
		if (! $block) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		$model->data['BlocksLanguage']['block_id'] = $block['Block']['id'];
		$model->data['Block'] = $block['Block'];
		Current::$current['Block'] = $block['Block'];

		//blocks_languagesの登録
		if ($model->BlocksLanguage->isM17nGeneralPlugin()) {
			$blockLanguage = $model->BlocksLanguage->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'block_id' => $model->data['BlocksLanguage']['block_id'],
					'language_id' => Current::read('Language.id'),
				),
			));
		} else {
			$blockLanguage = $model->BlocksLanguage->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'block_id' => $model->data['BlocksLanguage']['block_id'],
					'OR' => array(
						'language_id' => Current::read('Language.id'),
						'is_origin' => true,
					)
				),
			));
		}
		$model->data['BlocksLanguage'] = Hash::merge(
			Hash::get($blockLanguage, 'BlocksLanguage', array()),
			Hash::get($model->data, 'BlocksLanguage', array())
		);
		$model->data['BlocksLanguage'] = Hash::insert($model->data['BlocksLanguage'], 'modified', null);

		$blockLanguage = $model->BlocksLanguage->save($model->data['BlocksLanguage'], false);
		if (! $blockLanguage) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		$model->data['BlocksLanguage'] = $blockLanguage['BlocksLanguage'];
		Current::$current['BlocksLanguage'] = $blockLanguage['BlocksLanguage'];

		//Behaviorをセットしているモデルに対してblock_idとblock_keyをセットする
		if ($model->hasField('block_id') && ! Hash::check($model->data, $model->alias . '.block_id')) {
			$model->data[$model->alias]['block_id'] = $model->data['Block']['id'];
		}
		if ($model->hasField('block_key') && ! Hash::check($model->data, $model->alias . '.block_key')) {
			$model->data[$model->alias]['block_key'] = $model->data['Block']['key'];
		}
	}

/**
 * ブロック名取得
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @return string
 */
	private function __getBlockName(Model $model) {
		if (Hash::get($model->data, 'BlocksLanguage.name')) {
			//値があれば、何もしない
			$name = Hash::get($model->data, 'BlocksLanguage.name');
		} elseif (Hash::get($this->settings, 'nameHtml', false)) {
			list($alias, $filed) = pluginSplit($this->settings['name']);
			$name = trim(mb_strimwidth(strip_tags($model->data[$alias][$filed]), 0, self::NAME_LENGTH));
			if (! $name) {
				$name = __d('blocks', '(no text)');
			}
		} elseif (isset($this->settings['name'])) {
			list($alias, $filed) = pluginSplit($this->settings['name']);
			$name = Hash::get($model->data, $alias . '.' . $filed);
		} else {
			$name = sprintf(__d('blocks', 'Block %s'), date('YmdHis'));
		}

		return $name;
	}

/**
 * ブロック一覧データを取得する場合の条件を返します。
 *
 * #### サンプルコード（Faqモデル）
 * ```
 * $this->Paginator->settings = array(
 * 	'Faq' => array(
 * 		'order' => array('Block.id' => 'desc'),
 * 		'conditions' => $this->Faq->getBlockConditions(),
 * 		)
 * 	);
 * ```
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param array $conditions Model::find conditions default value
 * @return array Conditions data
 */
	public function getBlockConditions(Model $model, $conditions = array()) {
		$model->loadModels([
			'Block' => 'Blocks.Block',
		]);

		$conditions = Hash::merge(
			array(
				'Block.room_id' => Current::read('Room.id'),
				'Block.plugin_key' => Current::read('Plugin.key'),
			),
			$this->__getBlockDefaultConditions($model),
			$conditions
		);

		return $conditions;
	}

/**
 * ブロック一覧データを取得する場合のデフォルト条件を返します。
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @return array Conditions data
 */
	private function __getBlockDefaultConditions(Model $model) {
		$model->loadModels([
			'Block' => 'Blocks.Block',
		]);

		//belongsToの定義は、こっちでやる
		$belongsTo = $model->Block->bindModelBlockLang();
		$model->bindModel($belongsTo, false);

		if ($model->hasField('is_translation', true)) {
			$conditions = array(
				'OR' => array(
					$model->alias . '.is_translation' => false,
					$model->alias . '.language_id' => Current::read('Language.id', '0'),
				),
			);
		} elseif ($model->hasField('language_id', true)) {
			$conditions = array(
				$model->alias . '.language_id' => Current::read('Language.id', '0'),
			);
		} else {
			$conditions = array();
		}

		return $conditions;
	}

/**
 * ブロック一覧データを取得するsettingsを返す。
 *
 * #### サンプルコード（Faqモデル）
 * ```
 * $this->Paginator->settings = array(
 * 	'Faq' => $this->Faq->getBlockIndexSettings();
 * ```
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param array $options Model::find conditions default value
 * @return array Conditions data
 */
	public function getBlockIndexSettings(Model $model, $options = array()) {
		$model->loadModels([
			'Frame' => 'Frames.Frame',
		]);

		$options['order'] = Hash::merge(
			['Frame.block_id' => 'desc', 'Block.id' => 'asc'],
			Hash::get($options, 'order', [])
		);
		$options['conditions'] = $this->getBlockConditions($model, Hash::get($options, 'conditions', []));
		$options['joins'] = array(
			array(
				'table' => $model->Frame->table,
				'alias' => $model->Frame->alias,
				'type' => 'LEFT',
				'conditions' => array(
					'Frame.block_id = Block.id',
					'Frame.id' => Current::read('Frame.id')
				)
			),
		);
		$options['group'] = ['Block.id'];
		return $options;
	}

/**
 * ブロックデータを取得する場合の条件を返します。
 *
 * #### サンプルコード（Faqモデル）
 * ```
 * $faq = $this->find('all', array(
 * 	'recursive' => -1,
 * 	'conditions' => $this->getBlockConditionById(),
 * ));
 * ```
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param array $conditions Model::find conditions default value
 * @return array Conditions data
 */
	public function getBlockConditionById(Model $model, $conditions = array()) {
		$model->loadModels([
			'Block' => 'Blocks.Block',
		]);

		$conditions = Hash::merge(
			array(
				'Block.id' => Current::read('Block.id'),
				'Block.room_id' => Current::read('Room.id'),
			),
			$this->__getBlockDefaultConditions($model),
			$conditions
		);

		return $conditions;
	}

/**
 * ブロックデータを削除します。.
 *
 * #### サンプルコード（Faqモデル）
 * ```
 * public function deleteFaq($data) {
 * 	$this->begin();
 * 	try {
 * 		if (!$this->delete($data[Faq][id])) {
 * 			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
 * 		}
 *
 * 		$this->deleteBlock($data['Block']['key']);
 *
 * 		$this->commit();
 * 	} catch (Exception $ex) {
 *	 	$this->rollback($ex);
 * 	}
 * }
 * ```
 *
 * @param Model $model ビヘイビアの呼び出しのモデル
 * @param string $blockKey blocks.key
 * @return bool 成否
 * @throws InternalErrorException
 */
	public function deleteBlock(Model $model, $blockKey) {
		$model->loadModels([
			'Block' => 'Blocks.Block',
			'BlocksLanguage' => 'Blocks.BlocksLanguage',
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

		$blockIds = array_keys($blocks);
		foreach ($blockIds as $blockId) {
			if (! $model->Frame->updateAll(
					array('Frame.block_id' => null, 'Frame.default_action' => '\'\''),
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
				$model->$class->blockId = $blockIds;
				$model->$class->blockKey = $blockKey;
				$conditions = array($model->$class->alias . '.block_id' => $blockIds);
				$result = $model->$class->deleteAll($conditions, false, true);
			}
			if ($model->$class->hasField('block_key')) {
				$model->$class->blockKey = $blockKey;
				$conditions = array($model->$class->alias . '.block_key' => $blockKey);
				$result = $model->$class->deleteAll($conditions, false, true);
			}
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		//Blockデータ削除
		$conditions = array(
			$model->Block->alias . '.key' => $blockKey
		);
		if (! $model->Block->deleteAll($conditions, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		//BlocksLanguageデータ削除
		$conditions = array(
			$model->BlocksLanguage->alias . '.block_id' => $blockIds
		);
		if (! $model->BlocksLanguage->deleteAll($conditions, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

}
