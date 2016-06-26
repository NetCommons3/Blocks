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
 * setup
 *
 * #### サンプルコード
 * ##### Model
 * ```php
 * public $actsAs = array(
 *	'Blocks.BlockSetting' => array(
 *		'fields' => array(
 *			'use_workflow',
 *			'use_comment',
 *			'use_comment_approval',
 *			'use_like',
 *			'use_unlike',
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

		$model->Block = ClassRegistry::init('Blocks.Block', true);
		$model->BlockSetting = ClassRegistry::init('Blocks.BlockSetting', true);
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
		//		$blockSetting['BlockSetting'] = Hash::combine($blockSettings,
		//			'{n}.BlockSetting.field_name',
		//			'{n}.BlockSetting.value');
		// TODO 作成途中

		return $blockSettings;
	}

/**
 * BlockSettingデータ取得
 *
 * @param Model $model モデル
 * @param int $roomId ルームID
 * @param string $blockKey ブロックキー
 * @return array
 */
	public function getBlockSetting(Model $model, $roomId = null, $blockKey = null) {
		if (is_null($roomId)) {
			$roomId = Current::read('Room.id');
		}
		if (is_null($blockKey)) {
			$blockKey = Current::read('Block.key');
		}
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
			$blockSettings = $this->createBlockSetting($model);
		}
		$blockSetting['BlockSetting'] = Hash::combine($blockSettings,
			'{n}.BlockSetting.field_name',
			'{n}.BlockSetting.value');
		// TODO 作成途中

		$conditions = array(
			$model->Block->alias . '.key' => Current::read('Block.key'),
		);

		$block = $model->Block->find('first', array(
			'recursive' => -1,
			//'recursive' => 0,
			'conditions' => $conditions,
			//'order' => $model->Block->alias . '.id DESC'
		));
		if (! $block) {
			$block = $this->createMailSetting($pluginKey);
		}

		// $blockKeyで SELECT する
		$conditions = array(
			'plugin_key' => $pluginKey,
			'block_key' => $blockKey,
		);
		$mailSetting = $this->getMailSetting($conditions);
		if (! $mailSetting) {
			$mailSetting = $this->createMailSetting($pluginKey);
		}


		$blockSetting = array();

		$result = Hash::merge($block, $blockSetting);
		return $result;
	}

/**
 * BlockSettingデータ保存
 *
 * @param Model $model モデル
 * @param array $data received post data
 * @param bool $isBlockSetting ブロック設定画面か
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBlockSetting($data, $isBlockSetting) {
		//トランザクションBegin
		$this->begin();

		if ($isBlockSetting) {
			$this->loadModels(array(
				'Block' => 'Blocks.Block',
			));
			$this->Block->validate = array(
				'name' => array(
					'notBlank' => array(
						'rule' => array('notBlank'),
						'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('videos', 'Channel name')),
						'required' => true,
					),
				)
			);
		}

		// 値をセット
		$this->set($data);
		if (! $this->validates()) {
			$this->rollback();
			return false;
		}

		try {
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}
		return true;
	}

}
