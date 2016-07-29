<?php
/**
 * BlockSetting Model
 *
 * @property Room $Room
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksAppModel', 'Blocks.Model');

/**
 * Summary for BlockSetting Model
 */
class BlockSetting extends BlocksAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * beforeValidate
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/ja/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'plugin_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
			'field_name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
			'type' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * 単一の設定値 ゲット
 *
 * @param string $fieldName 項目名
 * @param Model $pluginKey プラグインキー
 * @param Model $blockKey ブロックキー
 * @return string 設定値
 * @see BlockSettingBehavior::FIELD_USE_WORKFLOW 承認を使う
 * @see BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL コメント承認を使う
 */
	public function getBlockSettingValue($fieldName, $pluginKey = null, $blockKey = null) {
		if (is_null($pluginKey)) {
			$pluginKey = Current::read('Plugin.key');
		}
		if (is_null($blockKey)) {
			$blockKey = Current::read('Block.key');
		}

		$blockSetting = $this->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'BlockSetting.plugin_key' => $pluginKey,
				'BlockSetting.block_key' => $blockKey,
				'BlockSetting.field_name' => $fieldName,
			),
		));
		if (!$blockSetting) {
			return null;
		}
		return $blockSetting['BlockSetting']['value'];
	}

}
