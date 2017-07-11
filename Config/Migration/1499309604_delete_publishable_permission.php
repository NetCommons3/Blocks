<?php
/**
 * DeletePublishablePermission
 *
 */

/**
 * DeletePublishablePermission
 *
 */
class DeletePublishablePermission extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'delete_publishable_permission';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		/* @var $DefaultRolePermission AppModel */
		/* @var $RolesRoom AppModel */
		/* @var $Block AppModel */
		$DefaultRolePermission = $this->generateModel('DefaultRolePermission');
		$RolesRoom = $this->generateModel('RolesRoom');
		$Block = $this->generateModel('BlockRolePermission');

		$query = [
			'fields' => 'role_key',
			'conditions' => [
				'permission' => 'content_comment_publishable',
				'fixed' => '1'
			],
			'recursive' => -1
		];
		$roleKeyList = $DefaultRolePermission->find('list', $query);

		$query = [
			'fields' => 'id',
			'conditions' => [
				'role_key' => $roleKeyList,
			],
			'recursive' => -1
		];
		$roleRoomIdList = $RolesRoom->find('list', $query);

		$conditions = [
			'OR' => [
				'permission' => 'content_publishable',
				[
					'permission' => 'content_comment_publishable',
					'roles_room_id' => $roleRoomIdList
				]
			]
		];
		if (!$Block->deleteAll($conditions, false)) {
			return false;
		}

		return true;
	}
}
