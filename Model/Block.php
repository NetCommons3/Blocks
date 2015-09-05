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
		'NetCommons.OriginalKey'
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
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'room_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('blocks', 'Block name')),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		), $this->validate);

		return parent::beforeValidate($options);
	}

/**
 * Get Block data
 *
 * @param string $blockId blocks.id
 * @param int $roomId rooms.id
 * @return array Block data
 */
	//public function getBlock($blockId, $roomId) {
	//	//BlockBehaviorにするため、後で削除
	//	$block = $this->find('first', array(
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
 * Save block data and frame.block_id.
 * Please do the transaction and validation in the caller.
 *
 * @param int $frameId frames.id
 * @param int $block block data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 *
 * @throws InternalErrorException
 */
	//public function saveByFrameId($frameId, $block = null) {
	//	//BlockBehaviorにするため、後で削除
	//	$this->loadModels([
	//		'Frame' => 'Frames.Frame',
	//	]);
	//
	//	//frameの取得
	//	$frame = $this->Frame->findById($frameId);
	//	if (! $frame) {
	//		throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
	//	}
	//
	//	if ($block === false || $block === null && ! $this->data) {
	//		if (isset($frame['Frame']['block_id'])) {
	//			return $this->findById((int)$frame['Frame']['block_id']);
	//		}
	//		$block = array();
	//		$block['Block']['room_id'] = $frame['Frame']['room_id'];
	//		$block['Block']['language_id'] = $frame['Frame']['language_id'];
	//		$block['Block']['name'] = sprintf(__d('blocks', 'New block %s'), date('YmdHis'));
	//	}
	//
	//	//blocksの登録
	//	if (! $block = $this->save($block, false)) {
	//		throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
	//	}
	//
	//	//framesテーブル更新
	//	if (! $frame['Frame']['block_id']) {
	//		$frame['Frame']['block_id'] = (int)$block['Block']['id'];
	//		if (! $this->Frame->save($frame, false)) {
	//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
	//		}
	//	}
	//
	//	return $block;
	//}

/**
 * validate block
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	//public function validateBlock($data) {
	//	//BlockBehaviorにするため、後で削除
	//	$this->set($data);
	//	$this->validates();
	//	if ($this->validationErrors) {
	//		return false;
	//	}
	//	return true;
	//}

/**
 * Delete block.
 * Please do the transaction and validation in the caller.
 *
 * @param string $key blocks.key
 * @return void
 *
 * @throws InternalErrorException
 */
	//public function deleteBlock($key) {
	//	//BlockBehaviorにするため、後で削除
	//	$this->loadModels([
	//		'Frame' => 'Frames.Frame',
	//		'BlockRolePermission' => 'Blocks.BlockRolePermission',
	//	]);
	//
	//	$conditions = array(
	//		$this->alias . '.key' => $key
	//	);
	//
	//	$blocks = $this->find('list', array(
	//			'recursive' => -1,
	//			'conditions' => $conditions,
	//		)
	//	);
	//	if (! $this->deleteAll($conditions, false)) {
	//		throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
	//	}
	//
	//	//BlockRolePermissionデータ削除
	//	if (! $this->BlockRolePermission->deleteAll(array($this->BlockRolePermission->alias . '.block_key' => $key), false)) {
	//		throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
	//	}
	//
	//	$blocks = array_keys($blocks);
	//	foreach ($blocks as $blockId) {
	//		if (! $this->Frame->updateAll(
	//				array('Frame.block_id' => null),
	//				array('Frame.block_id' => (int)$blockId)
	//		)) {
	//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
	//		}
	//	}
	//}
}
