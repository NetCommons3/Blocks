<?php
/**
 * BlockSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');

/**
 * Summary for BlockSettingFixture
 */
class BlockSettingFixture extends CakeTestFixture {

/**
 * Plugin key
 *
 * @var string
 */
	public $pluginKey = 'dummy';

/**
 * Records
 *
 * ##### フィクスチャーのデータに関連する、Modelのビヘイビア設定
 * ```php
 * public $actsAs = array(
 *	'Blocks.BlockSetting' => array(
 *		'use_workflow',	// rooms.need_approvalによって値決まる。BlockSettingでデフォルト値設定しても無視される。
 *		'use_comment',
 *		'use_comment_approval',	// rooms.need_approvalによって値決まる。BlockSettingでデフォルト値設定しても無視される。
 *		'use_like',
 *		'use_unlike',
 *		'auto_play',
 *		'total_size',
 *	),
 * ),
 * ```
 *
 * @var array
 */
	public $records = array(
		// プラグインデフォルト値 - room_idなし、block_keyなし
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => BlockSettingBehavior::FIELD_USE_COMMENT,
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => BlockSettingBehavior::FIELD_USE_LIKE,
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => BlockSettingBehavior::FIELD_USE_UNLIKE,
			'value' => '0',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => 'auto_play',
			'value' => '0',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => 'total_size',
			'value' => '0',
			'type' => BlockSettingBehavior::TYPE_NUMERIC,
		),
		// use_workflow, use_comment_approvalの初期値は、rooms.need_approvalによって値決まる。
		// BlockSettingでデフォルト値（room_id=null, block_key=nullの値）設定しても無視される。
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => BlockSettingBehavior::FIELD_USE_WORKFLOW,
			'value' => '0',
			'type' => BlockSettingBehavior::TYPE_NUMERIC,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => null,
			'block_key' => null,
			'field_name' => BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL,
			'value' => '0',
			'type' => BlockSettingBehavior::TYPE_NUMERIC,
		),
		// ブロック設定後 - room_idあり、block_keyあり
		array(
			'plugin_key' => 'dummy',
			'room_id' => '2',
			'block_key' => 'block_1',
			'field_name' => BlockSettingBehavior::FIELD_USE_COMMENT,
			'value' => '0',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '2',
			'block_key' => 'block_1',
			'field_name' => BlockSettingBehavior::FIELD_USE_LIKE,
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '2',
			'block_key' => 'block_1',
			'field_name' => BlockSettingBehavior::FIELD_USE_UNLIKE,
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '2',
			'block_key' => 'block_1',
			'field_name' => 'auto_play',
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '2',
			'block_key' => 'block_1',
			'field_name' => 'total_size',
			'value' => '100',
			'type' => BlockSettingBehavior::TYPE_NUMERIC,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '2',
			'block_key' => 'block_1',
			'field_name' => BlockSettingBehavior::FIELD_USE_WORKFLOW,
			'value' => '0',
			'type' => BlockSettingBehavior::TYPE_NUMERIC,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '2',
			'block_key' => 'block_1',
			'field_name' => BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL,
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_NUMERIC,
		),
		// イレギュラーデータ - room_idあり、block_keyあり、USE_WORKFLOW, USE_COMMENT_APPROVALのデータなし
		array(
			'plugin_key' => 'dummy',
			'room_id' => '3',
			'block_key' => 'block_2',
			'field_name' => BlockSettingBehavior::FIELD_USE_COMMENT,
			'value' => '0',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '3',
			'block_key' => 'block_2',
			'field_name' => BlockSettingBehavior::FIELD_USE_LIKE,
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '3',
			'block_key' => 'block_2',
			'field_name' => BlockSettingBehavior::FIELD_USE_UNLIKE,
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '3',
			'block_key' => 'block_2',
			'field_name' => 'auto_play',
			'value' => '1',
			'type' => BlockSettingBehavior::TYPE_BOOLEAN,
		),
		array(
			'plugin_key' => 'dummy',
			'room_id' => '3',
			'block_key' => 'block_2',
			'field_name' => 'total_size',
			'value' => '100',
			'type' => BlockSettingBehavior::TYPE_NUMERIC,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Blocks') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new BlocksSchema())->tables['block_settings'];
		parent::init();

		// 継承先で $this->pluginKey を上書きすれば、そのプラグインに対応したデータになるので
		$this->records = Hash::insert($this->records, '{n}.plugin_key', $this->pluginKey);
	}

}
