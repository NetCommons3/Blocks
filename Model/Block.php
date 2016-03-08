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

/**
 * Block Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Model
 */
class Block extends BlocksAppModel {

/**
 * Block type
 *
 * @var int
 */
	const
		TYPE_PRIVATE = '0',
		TYPE_PUBLIC = '1',
		TYPE_LIMITED = '2';

/**
 * Approval type
 *
 * @var int
 */
	const
		NOT_NEED_APPROVAL = '0',
		NEED_APPROVAL = '1',
		NEED_COMMENT_APPROVAL = '2';

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		//'NetCommons.OriginalKey',
		'M17n.M17n'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Language' => array(
			'className' => 'M17n.Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
			'language_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'room_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
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
		switch ($block['Block']['public_type']) {
			case 0:
				// 非表示
				$result = false;
				break;
			case 1:
				// 表示
				break;
			case 2:
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
		}
		return $result;
	}
}
