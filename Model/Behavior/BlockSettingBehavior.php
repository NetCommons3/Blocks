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
App::uses('Current', 'NetCommons.Utility');

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
 * セッティングのキー
 *
 * @var string true or false
 */
	const SETTING_PLUGIN_KEY = 'pluginKey';

/**
 * ビヘイビアの初期設定
 *
 * @var array
 */
	protected $_defaultSettings = array(
		self::SETTING_PLUGIN_KEY => null,
	);

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
 *		BlockSettingBehavior::USE_WORKFLOW,
 *		BlockSettingBehavior::USE_LIKE,
 *		BlockSettingBehavior::USE_UNLIKE,
 *		BlockSettingBehavior::USE_COMMENT,
 *		BlockSettingBehavior::USE_COMMENT_APPROVAL,
 *		'auto_play',
 * 		// 小テスト、アンケート、カレンダーの場合は下記設定。値の例）小テスト
 *		BlockSettingBehavior::SETTING_PLUGIN_KEY => 'quizzes',
 *	),
 * ),
 * ```
 *
 * @param Model $model モデル
 * @param array $settings 設定値
 * @return void
 */
	public function setup(Model $model, $settings = array()) {
		$this->settings[$model->alias] = $settings;

		$this->_defaultSettings[self::SETTING_PLUGIN_KEY] = Current::read('Plugin.key');
		$this->settings[$model->alias] =
			Hash::merge($this->_defaultSettings, $this->settings[$model->alias]);
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
 * @param int $roomId ルームID
 * @param bool $isRow 縦持ちデータ取得するか
 * @return array
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function createBlockSetting(Model $model, $roomId = null, $isRow = false) {
		$model->loadModels(array('BlockSetting' => 'Blocks.BlockSetting'));

		$pluginKey = $this->_getPluginKey($model);
		if (is_null($roomId)) {
			$roomId = Current::read('Room.id');
		}

		// room_idなし, block_keyなし
		$conditions = array(
			'plugin_key' => $pluginKey,
			'room_id' => null,
			'block_key' => null,
			'field_name' => $this->_getFields($model),
		);
		$blockSettings = $model->BlockSetting->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));

		// use_workflow, use_comment_approval新規作成
		$blockSettings = $this->_getDefaultApproval($model, $blockSettings,
			self::FIELD_USE_WORKFLOW, 1);
		$blockSettings = $this->_getDefaultApproval($model, $blockSettings,
			self::FIELD_USE_COMMENT_APPROVAL, 1);

		// 縦持ち
		// 新規登録時に不要な部分を除外
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.id');
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.created');
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.created_user');
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.modified');
		$blockSettings = Hash::remove($blockSettings, '{n}.{s}.modified_user');
		$blockSettings = Hash::insert($blockSettings, '{n}.{s}.plugin_key', $pluginKey);
		$blockSettings = Hash::insert($blockSettings, '{n}.{s}.room_id', $roomId);

		// 横持ち、縦持ちにデータ変換
		return $this->_convertColAndRow($model, $blockSettings, $isRow);
	}

/**
 * フィールド取得
 *
 * @param Model $model モデル
 * @return array フィールド
 */
	protected function _getFields($model) {
		$fields = $this->settings[$model->alias];
		unset($fields[self::SETTING_PLUGIN_KEY]);
		return $fields;
	}

/**
 * プラグインキー取得
 *
 * @param Model $model モデル
 * @return string プラグインキー
 */
	protected function _getPluginKey($model) {
		return $this->settings[$model->alias][self::SETTING_PLUGIN_KEY];
	}

/**
 * BlockSettingデータ取得
 *
 * @param Model $model モデル
 * @param string $blockKey ブロックキー
 * @param int $roomId ルームID
 * @param bool $isRow 縦持ちデータ取得するか
 * @return array
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function getBlockSetting(Model $model, $blockKey = null, $roomId = null,
									$isRow = false) {
		$model->loadModels(array('BlockSetting' => 'Blocks.BlockSetting'));

		if (is_null($blockKey)) {
			$blockKey = Current::read('Block.key');
		}
		if (is_null($roomId)) {
			$roomId = Current::read('Room.id');
		}
		$pluginKey = $this->_getPluginKey($model);

		// room_idあり, block_keyあり
		$conditions = array(
			'plugin_key' => $pluginKey,
			'room_id' => $roomId,
			'block_key' => $blockKey,
			'field_name' => $this->_getFields($model),
		);
		$blockSettings = $model->BlockSetting->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		if (!$blockSettings) {
			// データなければ新規作成
			$blockSettings = $this->createBlockSetting($model, $roomId, $isRow);
			return $blockSettings;
		}

		// use_workflow, use_comment_approval取得
		$blockSettings = $this->_getDefaultApproval($model, $blockSettings,
			self::FIELD_USE_WORKFLOW);
		$blockSettings = $this->_getDefaultApproval($model, $blockSettings,
			self::FIELD_USE_COMMENT_APPROVAL);

		// 横持ち、縦持ちにデータ変換
		return $this->_convertColAndRow($model, $blockSettings, $isRow);
	}

/**
 * BlockSettingデータ存在するか
 *
 * @param Model $model モデル
 * @param string $blockKey ブロックキー
 * @param int $roomId ルームID
 * @return bool
 */
	public function isExsistBlockSetting(Model $model, $blockKey = null, $roomId = null) {
		$model->loadModels(array('BlockSetting' => 'Blocks.BlockSetting'));

		if (is_null($blockKey)) {
			$blockKey = Current::read('Block.key');
		}
		if (is_null($roomId)) {
			$roomId = Current::read('Room.id');
		}
		$pluginKey = $this->_getPluginKey($model);

		// room_idあり, block_keyあり
		$conditions = array(
			'plugin_key' => $pluginKey,
			'room_id' => $roomId,
			'block_key' => $blockKey,
			'field_name' => $this->_getFields($model),
		);
		$blockSettings = $model->BlockSetting->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		return !empty($blockSettings);
	}

/**
 * use_workflow, use_comment_approvalの初期値取得
 * room.need_approvalによって、値変わる
 *
 * @param Model $model モデル
 * @param array $blockSettings ブロックセッティングデータ
 * @param string $fieldName フィールド名
 * @param int $create 新規作成フラグ 0:更新、1:新規作成
 * @return array ブロックセッティングデータ
 */
	protected function _getDefaultApproval(Model $model, $blockSettings, $fieldName, $create = 0) {
		// settingに対象fieldの指定なければ、何もしない
		$fields = $this->_getFields($model);
		if (!in_array($fieldName, $fields)) {
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

		/** @see BlockFormHelper::blockSettingHidden(); block_keyは左記でセット */
		$pluginKey = $this->_getPluginKey($model);
		$roomId = Current::read('Room.id');
		$defaultBlockSetting = array(
			'BlockSetting' => array(
				'plugin_key' => $pluginKey,
				'room_id' => $roomId,
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
		$defaultBlockSetting['BlockSetting']['value'] = '0';
		$blockSettings[] = $defaultBlockSetting;
		return $blockSettings;
	}

/**
 * 横持ち、縦持ちにデータ変換
 *
 * @param Model $model モデル
 * @param array $blockSettings ブロックセッティングデータ
 * @param bool $isRow 縦持ちデータ取得するか
 * @return array
 */
	protected function _convertColAndRow(Model $model, $blockSettings, $isRow) {
		// [基のモデル] 横持ちに変換 & 基のモデルに付足し
		$result[$model->alias] = Hash::combine($blockSettings,
			'{n}.{s}.field_name',
			'{n}.{s}.value');

		if (!$isRow) {
			return $result;
		}

		// [BlockSetting] 縦持ちでindexをfield_nameに変更
		$result['BlockSetting'] = Hash::combine($blockSettings, '{n}.{s}.field_name', '{n}.{s}');
		return $result;
	}

/**
 * BlockSettingデータ保存
 *
 * ### 仕組み
 * 各プラグインの[横]の入力値を、BlockSettingをブロックキーで検索した縦データにセット or
 * データなしなら、新規作成データが取得できるので、ブロックキーをセット
 * して、縦データをsaveManyでまとめて保存します。
 * ```
 * //(例)各プラグインのBlockSettingControllerからの登録処理 [横]データ
 * array(
 * 	'VideoBlockSetting' => array(
 * 		'use_comment' => '1',
 * 		'use_like' => '1',
 * 		'use_unlike' => '0',
 * 		'auto_play' => '0',
 * 		'use_comment' => '1',
 * 	)
 * )
 * ↓
 * ↓ ブロックキーで検索した[縦]データにセット
 * ↓
 * array(
 * 	'use_comment' => array(
 * 		'id' => '1',		// 新規登録時はidない
 * 		'plugin_key' => 'videos',
 * 		'room_id' => '2',
 * 		'block_key' => '2e86eb72e9cbd0ffa87ea23c81d4e3b7',
 * 		'field_name' => 'use_comment',
 * 		'value' => '1',
 * 		'type' => 'boolean',
 * 	),
 * 	'use_like' => array(
 * 		'id' => '1',
 * 		'plugin_key' => 'videos',
 * 		'room_id' => '2',
 * 		'block_key' => '2e86eb72e9cbd0ffa87ea23c81d4e3b7',
 * 		'field_name' => 'use_like',
 * 		'value' => '1',
 * 		'type' => 'boolean',
 * 	),
 * 	'use_unlike' => array(
 * 		'id' => '1',
 * 		'plugin_key' => 'videos',
 * 		'room_id' => '2',
 * 		'block_key' => '2e86eb72e9cbd0ffa87ea23c81d4e3b7',
 * 		'field_name' => 'use_unlike',
 * 		'value' => '0',
 * 		'type' => 'boolean',
 * 	),
 * 	'is_auto_play' => array(
 * 		'id' => '1',
 * 		'plugin_key' => 'videos',
 * 		'room_id' => '2',
 * 		'block_key' => '2e86eb72e9cbd0ffa87ea23c81d4e3b7',
 * 		'field_name' => 'auto_play',
 * 		'value' => '0',
 * 		'type' => 'boolean',
 * 	),
 * )
 * ```
 *
 * @param Model $model モデル
 * @param string $blockKey ブロックキー
 * @param int $roomId ルームID
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBlockSetting(Model $model, $blockKey = null, $roomId = null) {
		$model->loadModels(array('BlockSetting' => 'Blocks.BlockSetting'));

		// 横の入力データを、検索した縦データにセット & 新規登録用にブロックキーをセット
		if (is_null($blockKey)) {
			$blockKey = Current::read('Block.key');
		}
		if (is_null($roomId)) {
			$roomId = Current::read('Room.id');
		}

		$blockSetting = $this->getBlockSetting($model, $blockKey, $roomId, true);
		$inputData = $model->data[$model->alias];
		$saveData = null;
		$fields = $this->_getFields($model);

		// セッティングしたフィールドを基に、入力したフィールドのみsaveDataにする
		foreach ($fields as $field) {
			if (array_key_exists($field, $inputData)) {
				$saveData[$field] = $blockSetting['BlockSetting'][$field];
				$saveData[$field]['value'] = $inputData[$field];
				// 新規登録用にブロックキーをセット
				$saveData[$field]['block_key'] = $blockKey;
			}
		}

		if ($saveData &&
			!$model->BlockSetting->saveMany($saveData, ['validate' => false])) {
			throw new InternalErrorException('Failed - BlockSetting ' . __METHOD__);
		}
		return true;
	}

/**
 * ブロックセッティングのValidate追加処理
 *
 * @param Model $model モデル
 * @param string $blockKey ブロックキー
 * @return bool
 */
	public function validateBlockSetting(Model $model, $blockKey = null) {
		$inputData = $model->data[$model->alias];
		if (is_null($blockKey)) {
			$blockKey = Current::read('Block.key');
		}
		$fields = $this->_getFields($model);
		// 縦データ取得
		$blockSetting = $this->getBlockSetting($model, $blockKey, null, true);

		// セッティングしたフィールドを基に、入力したフィールドのみvalidateする
		foreach ($fields as $field) {
			if (array_key_exists($field, $inputData)) {
				// validate追加
				$rule = $blockSetting['BlockSetting'][$field]['type'];
				$model->validate = Hash::merge($model->validate, array(
					$field => array(
						$rule => array(
							'rule' => $rule,
							'message' => __d('net_commons', 'Invalid request.'),
						),
					)
				));
			}
		}
		return true;
	}

}
