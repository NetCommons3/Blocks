<?php
/**
 * Block Model
 *
 * @property Language $Language
 * @property Room $Room
 * @property Frame $Frame
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksAppModel', 'Blocks.Model');
App::uses('NetCommonsTime', 'NetCommons.Utility');
App::uses('Current', 'NetCommons.Utility');

/**
 * Block Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Model
 */
class Block extends BlocksAppModel {

/**
 * ブロック公開のタイプ(非公開)
 *
 * @var int
 */
	const TYPE_PRIVATE = '0';

/**
 * ブロック公開のタイプ(公開)
 *
 * @var int
 */
	const TYPE_PUBLIC = '1';

/**
 * ブロック公開のタイプ(期限付き公開)
 *
 * @var int
 */
	const TYPE_LIMITED = '2';

/**
 * 承認フラグ(承認不要)
 *
 * @var int
 */
	const NOT_NEED_APPROVAL = '0';

/**
 * 承認フラグ(コンテンツ、コメントの承認必要)
 *
 * @var int
 */
	const NEED_APPROVAL = '1';

/**
  * 承認フラグ(コメントのみ承認必要)
 *
 * @var int
 */
	const NEED_COMMENT_APPROVAL = '2';

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Room' => array(
			'className' => 'Rooms.Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Frame' => array(
			'className' => 'Frames.Frame',
			'foreignKey' => 'block_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array();

/**
 * Called before each find operation. Return false if you want to halt the find
 * call, otherwise return the (modified) query data.
 *
 * @param array $query Data used to execute this query, i.e. conditions, order, etc.
 * @return mixed true if the operation should continue, false if it should abort; or, modified
 *  $query to continue with new $query
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforefind
 */
	public function beforeFind($query) {
		if (Hash::get($query, 'recursive') > -1) {
			$this->bindModel(array(
				'belongsTo' => array(
					'Plugin' => array(
						'className' => 'PluginManager.Plugin',
						'foreignKey' => false,
						'conditions' => array(
							'Plugin.key' . ' = ' . $this->alias . '.plugin_key',
							'Plugin.language_id' => Current::read('Language.id', '0'),
						),
						'fields' => '',
						'order' => ''
					),
				)
			), true);

			$belongsTo = $this->bindModelBlockLang();
			$this->bindModel($belongsTo, true);
		}
		return true;
	}

/**
 * ブロック言語テーブルのバインド条件を戻す
 *
 * @return array
 */
	public function bindModelBlockLang() {
		$belongsTo = array(
			'belongsTo' => array(
				//'Block' => array(
				//	'className' => 'Blocks.Block',
				//	'foreignKey' => 'block_id',
				//	'fields' => '',
				//	'order' => ''
				//),
				'BlocksLanguage' => array(
					'className' => 'Blocks.BlocksLanguage',
					'foreignKey' => false,
					'conditions' => array(
						'BlocksLanguage.block_id = Block.id',
						'OR' => array(
							'BlocksLanguage.is_translation' => false,
							'BlocksLanguage.language_id' => Current::read('Language.id', '0'),
						),
					),
					'fields' => array('language_id', 'block_id', 'name', 'is_origin', 'is_translation'),
					'order' => ''
				),
			)
		);

		return $belongsTo;
	}

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge(array(
			'room_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'public_type' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'inList' => array(
					'rule' => array('inList', array(
						self::TYPE_PRIVATE,
						self::TYPE_PUBLIC,
						self::TYPE_LIMITED
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			//'name' => array(
			//	'notBlank' => array(
			//		'rule' => array('notBlank'),
			//		'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('blocks', 'Block name')),
			//		//'allowEmpty' => false,
			//		//'required' => false,
			//		//'last' => false, // Stop validation after this rule
			//		//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//	),
			//),
		), $this->validate);

		return parent::beforeValidate($options);
	}

/**
 * ブロックの公開設定をもとに現在見られるブロックなら trueを返す
 *
 * @param array $block ブロックデータ
 * @return bool
 */
	public function isVisible($block) {
		$result = true;

		switch (Hash::get($block, 'Block.public_type', self::TYPE_PRIVATE)) {
			case self::TYPE_PRIVATE:
				// 非表示
				$result = false;
				break;
			case self::TYPE_PUBLIC:
				// 表示
				break;
			case self::TYPE_LIMITED:
				// 期間限定
				$now = NetCommonsTime::getNowDatetime();
				$start = $block['Block']['publish_start'];
				$end = $block['Block']['publish_end'];
				if ($start !== null && $start > $now) {
					$result = false;
				}
				if ($end !== null && $end < $now) {
					$result = false;
				}
				break;
			default:
				$result = false;
		}
		return $result;
	}

}
