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
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'language_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'room_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Language' => array(
			'className' => 'Language',
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
 * before save
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if the operation should continue, false if it should abort
 */
	public function beforeSave($options = array()) {
		if (! isset($this->data[$this->name]['id']) && ! isset($this->data[$this->name]['key'])) {
			$this->data[$this->name]['key'] = Security::hash($this->name . mt_rand() . microtime());
		}
		return true;
	}

/**
 * save block
 *
 * @param int $frameId frames.id
 * @param bool|array $validate Either a boolean, or an array.
 *   If a boolean, indicates whether or not to validate before saving.
 *   If an array, can have following keys:
 *
 *   - validate: Set to true/false to enable or disable validation.
 *   - fieldList: An array of fields you want to allow for saving.
 *   - callbacks: Set to false to disable callbacks. Using 'before' or 'after'
 *      will enable only those callbacks.
 *   - `counterCache`: Boolean to control updating of counter caches (if any)
 * @return mixed On success Model::$data if its not empty or true, false on failure
 *
 * @throws InternalErrorException
 *
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */

	public function saveByFrameId($frameId, $validate = true) {
		$this->loadModels([
			'Block' => 'Blocks.Block',
			'Frame' => 'Frames.Frame',
		]);

		//frameの取得
		$frame = $this->Frame->findById($frameId);
		if (! $frame) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if (isset($frame['Frame']['block_id'])) {
			return $this->findById(is_int($frame['Frame']['block_id']) ? (int)$frame['Frame']['block_id'] : $frame['Frame']['block_id']);
		}

		//blocksテーブル登録
		$block = array();
		$block['Block']['room_id'] = $frame['Frame']['room_id'];
		$block['Block']['language_id'] = $frame['Frame']['language_id'];
		$block = $this->save($block, $validate);
		if (! $block) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		$blockId = (int)$block['Block']['id'];

		//framesテーブル更新
		$frame['Frame']['block_id'] = $blockId;
		if (! $this->Frame->save($frame, $validate)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return $block;
	}

}
