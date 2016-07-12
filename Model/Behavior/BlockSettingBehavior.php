<?php
/**
 * BlockSetting Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * BlockSetting Behavior
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Model\Behavior
 */
class BlockSettingBehavior extends ModelBehavior {

/**
 * フィールド名
 *
 * @var string いいねボタンを使用する
 * @var string わるいねボタンも使用する
 * @var string コメントを使用する
 * @var string 承認機能を使用する
 * @var string コメント承認機能を使用する
 */
	const
		FIELD_USE_LIKE = 'use_like',
		FIELD_USE_UNLIKE = 'use_unlike',
		FIELD_USE_COMMENT = 'use_comment',
		FIELD_USE_WORKFLOW = 'use_workflow',
		FIELD_USE_COMMENT_APPROVAL = 'use_comment_approval';

/**
 * フィールド名の種類
 *
 * @var string true or false
 * @var string 数字
 */
	const
		TYPE_BOOLEAN = 'boolean',
		TYPE_NUMERIC = 'numeric';

/**
 * setup
 *
 * #### サンプルコード
 * ##### Model
 * ```php
 * App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');
 *
 * public $actsAs = array(
 *	'Blocks.BlockSetting' => array(
 *		'fields' => array(
 *			BlockSettingBehavior::USE_WORKFLOW,
 *			BlockSettingBehavior::USE_LIKE,
 *			BlockSettingBehavior::USE_UNLIKE,
 *			BlockSettingBehavior::USE_COMMENT,
 *			BlockSettingBehavior::USE_COMMENT_APPROVAL,
 *			'auto_play',
 *		),
 *	),
 * ),
 * ```
 *
 * @param Model $model モデル
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		$this->settings = Hash::merge($this->settings, $config);
		$this->settings['fields'] = Hash::get($this->settings, 'fields', array());

		$model->BlockSetting = ClassRegistry::init('Blocks.BlockSetting', true);
		//$model->Room = ClassRegistry::init('Rooms.Room', true);
	}

/**
 * afterFind
 *
 * @param Model $model Model using this behavior
 * @param mixed $results The results of the find operation
 * @param bool $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed An array value will replace the value of $results - any other value will be ignored.
 */
	public function afterFind(Model $model, $results, $primary = false) {
		// count検索対応。Block.keyが無ければ、何もしない
		if (!Hash::check($results, '0.Block.key')) {
			return $results;
		}
		//		$blockKeys = Hash::extract($results, '{n}.Block.key');
		//		foreach ($blockKeys as $blockKey) {
		foreach ($results as &$result) {
			$blockSetting = $this->getBlockSetting($model, $result['Block']['key']);
			$result = Hash::merge($result, $blockSetting);
		}
		return $results;
	}

/**
 * beforeValidate
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False or null will abort the operation. Any other result will continue.
 * @see Model::save()
 */
	public function beforeValidate(Model $model, $options = array()) {
		return $this->validateBlockSetting($model);
	}

/**
 * beforeSave
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False if the operation should abort. Any other result will continue.
 * @see Model::save()
 */
	public function beforeSave(Model $model, $options = array()) {
		return $this->saveBlockSetting($model);
	}

/**
 * BlockSettingデータ新規作成
 *
 * @param Model $model モデル
 * @return array
 */
	public function createBlockSetting(Model $model) {
		$pluginKey = Current::read('Plugin.key');

		// room_idなし, block_keyなし
		$conditions = array(
			'plugin_key' => $pluginKey,
			'room_id' => null,
			'block_key' => null,
			'field_name' => $this->settings['fields'],
		);
		$blockSettings = $model->BlockSetting->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));

		// use_workflow, use_comment_approval新規作成
		$blockSettings = self::_getDefaultApproval($blockSettings,
			self::FIELD_USE_WORKFLOW, 1);
		$blockSettings = self::_getDefaultApproval($blockSettings,
			self::FIELD_USE_COMMENT_APPROVAL, 1);

		// 縦持ち
		// 新規登録時に不要な部分を除外
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.id');
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.created');
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.created_user');
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.modified');
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.modified_user');

		// indexをfield_nameに変更
		$result['BlockSetting'] = Hash::combine($blockSettings, '{n}.{s}.field_name', '{n}.{s}');
		return $result;
	}

/**
 * BlockSettingデータ取得
 *
 * @param Model $model モデル
 * @param string $blockKey ブロックキー
 * @return array
 */
	public function getBlockSetting(Model $model, $blockKey = null) {
		//$model->BlockSetting = ClassRegistry::init('Blocks.BlockSetting', true);
		if (is_null($blockKey)) {
			$blockKey = Current::read('Block.key');
		}
		$roomId = Current::read('Room.id');
		$pluginKey = Current::read('Plugin.key');

		// room_idあり, block_keyあり
		$conditions = array(
			'plugin_key' => $pluginKey,
			'room_id' => $roomId,
			'block_key' => $blockKey,
			'field_name' => $this->settings['fields'],
		);
		$blockSettings = $model->BlockSetting->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		if (!$blockSettings) {
			//$blockSettings = $this->createBlockSetting($model);
			return $blockSettings;
		}

		// use_workflow, use_comment_approval取得
		$blockSettings = self::_getDefaultApproval($blockSettings, self::FIELD_USE_WORKFLOW);
		$blockSettings = self::_getDefaultApproval($blockSettings, self::FIELD_USE_COMMENT_APPROVAL);

		// [基のモデル] 横持ちに変換 & 基のモデルに付足し
		$result[$model->alias] = Hash::combine($blockSettings,
			'{n}.{s}.field_name',
			'{n}.{s}.value');

		// [BlockSetting] 縦持ちでindexをfield_nameに変更
		$result['BlockSetting'] = Hash::combine($blockSettings, '{n}.{s}.field_name', '{n}.{s}');
		return $result;
	}

/**
 * use_workflow, use_comment_approvalの初期値取得
 * room.need_approvalによって、値変わる
 *
 * @param array $blockSettings ブロックセッティングデータ
 * @param string $fieldName フィールド名
 * @param int $create 新規作成フラグ 0:更新、1:新規作成
 * @return array ブロックセッティングデータ
 */
	protected function _getDefaultApproval($blockSettings, $fieldName, $create = 0) {
		// フィールドに指定なければ、何もしない
		if (!in_array($fieldName, $this->settings['fields'])) {
			return $blockSettings;
		}

		// 新規作成時はデータあっても、データなしとして扱い、use_workflow, use_comment_approvalを新規作成する
		if (!$create) {
			// データありは、何もしない（つまりデータを使う）
			$fields = Hash::extract($blockSettings, '{n}.{s}.field_name');
			if (in_array($fieldName, $fields, true)) {
				return $blockSettings;
			}
		}
		// 以降はデータなし処理

		/** @see BlockFormHelper::blockSettingHidden(); plugin_key,room_id,block_keyは左記でセット */
		$pluginKey = Current::read('Plugin.key');
		$defaultBlockSetting = array(
			'BlockSetting' => array(
				'plugin_key' => $pluginKey,
				'room_id' => null,
				'block_key' => null,
				'field_name' => $fieldName,
				'value' => null,
				'type' => BlockSettingBehavior::TYPE_BOOLEAN,
			)
		);

		$needApproval = Current::read('Room.need_approval');

		// ルーム承認する
		if ($needApproval) {
			$defaultBlockSetting['BlockSetting']['value'] = '1';
			$blockSettings[] = $defaultBlockSetting;
			return $blockSettings;
		}

		// ルーム承認しない
		// TODOO ルーム承認なしにしたら、承認なしデフォルトでOK？
		$defaultBlockSetting['BlockSetting']['value'] = '0';
		$blockSettings[] = $defaultBlockSetting;
		return $blockSettings;
	}

/**
 * BlockSettingデータ保存
 *
 * ### 注意事項
 * この引数$dataは、リクエストの中身そのまま。
 * ```
 * //(例)各プラグインのBlockSettingControllerからの登録処理
 * array(
 * 	'BlockSetting' => array(
 * 		'use_comment' => array(
 * 			'id' => '1',
 * 			'plugin_key' => 'videos',
 * 			'room_id' => '2',
 * 			'block_key' => '2e86eb72e9cbd0ffa87ea23c81d4e3b7',
 * 			'field_name' => 'use_comment',
 * 			'value' => '1',
 * 			'type' => 'boolean',
 * 		),
 * 		'use_like' => array(
 * 			'id' => '1',
 * 			'plugin_key' => 'videos',
 * 			'room_id' => '2',
 * 			'block_key' => '2e86eb72e9cbd0ffa87ea23c81d4e3b7',
 * 			'field_name' => 'use_like',
 * 			'value' => '1',
 * 			'type' => 'boolean',
 * 		),
 * 		'use_unlike' => array(
 * 			'id' => '1',
 * 			'plugin_key' => 'videos',
 * 			'room_id' => '2',
 * 			'block_key' => '2e86eb72e9cbd0ffa87ea23c81d4e3b7',
 * 			'field_name' => 'use_unlike',
 * 			'value' => '0',
 * 			'type' => 'boolean',
 * 		),
 * 		'is_auto_play' => array(
 * 			'id' => '1',
 * 			'plugin_key' => 'videos',
 * 			'room_id' => '2',
 * 			'block_key' => '2e86eb72e9cbd0ffa87ea23c81d4e3b7',
 * 			'field_name' => 'auto_play',
 * 			'value' => '0',
 * 			'type' => 'numeric',
 * 		),
 * 	)
 * )
 * ```
 *
 * @param Model $model モデル
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBlockSetting(Model $model) {
		$saveData = Hash::extract($model->data, 'BlockSetting.{s}');

		if ($saveData &&
			!$model->BlockSetting->saveMany($saveData, ['validate' => false])) {
			throw new InternalErrorException('Failed - BlockSetting ' . __METHOD__);
		}
		return true;
	}

/**
 * ブロック設定のValidate処理
 *
 * @param Model $model モデル
 * @return bool
 */
	public function validateBlockSetting(Model $model) {
		foreach ($model->data['BlockSetting'] as $key => $blockSetting) {
			if (!isset($blockSetting['type'])) {
				// 登録不要なデータを削除 - block_approval_setting.ctpで approval_type がセットされるため
				unset($model->data['BlockSetting'][$key]);
				continue;
			}

			if ($blockSetting['type'] === self::TYPE_BOOLEAN) {
				if (! in_array($blockSetting['value'], ['0', '1'], true)) {
					$fieldName = $blockSetting['field_name'];
					$model->validationErrors['BlockSetting'][$fieldName]['value']
						= array(__d('net_commons', 'Invalid request.'));
				}

			} elseif ($blockSetting['type'] === self::TYPE_NUMERIC) {
				if (! is_numeric($blockSetting['value'])) {
					$fieldName = $blockSetting['field_name'];
					$model->validationErrors['BlockSetting'][$fieldName]['value']
						= array(__d('net_commons', 'Invalid request.'));
				}

			}
		}

		if (! $model->validationErrors) {
			return true;
		} else {
			return false;
		}
	}

}
