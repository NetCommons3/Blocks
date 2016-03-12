<?php
/**
 * BlockRolePermissionFormHelper::checkboxBlockRolePermission()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * BlockRolePermissionFormHelper::checkboxBlockRolePermission()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Helper\BlockRolePermissionFormHelper
 */
class BlockRolePermissionFormHelperCheckboxBlockRolePermissionTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.room_role',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'blocks';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$RoomRole = ClassRegistry::init('Rooms.RoomRole');
		$Role = ClassRegistry::init('Roles.Role');

		//テストデータ生成
		$viewVars = array();

		$roomRoles = $RoomRole->find('all', array('recursive' => -1));
		$viewVars['roles'] = Hash::combine($roomRoles, '{n}.RoomRole.role_key', '{n}.RoomRole');

		$roles = $Role->find('all', array('recursive' => -1,
			'conditions' => array(
				'Role.type' => Role::ROLE_TYPE_ROOM,
				'Role.language_id' => Current::read('Language.id'),
			),
		));
		$viewVars['roles'] = Hash::merge($viewVars['roles'], Hash::combine($roles, '{n}.Role.key', '{n}.Role'));

		$requestData = array();
		$requestData['BlockRolePermission'] = array('content_creatable' => array(
			'room_administrator' => array(
				'id' => '1',
				'roles_room_id' => '1',
				'value' => '1',
				'block_key' => 'block_1',
				'permission' => 'content_creatable',
				'fixed' => true,
			),
			'chief_editor' => array(
				'id' => '2',
				'roles_room_id' => '2',
				'value' => '1',
				'block_key' => 'block_1',
				'permission' => 'content_creatable',
				'fixed' => true,
			),
			'editor' => array(
				'id' => '3',
				'roles_room_id' => '3',
				'value' => '1',
				'block_key' => 'block_1',
				'permission' => 'content_creatable',
				'fixed' => false,
			),
			'general_user' => array(
				'roles_room_id' => '4',
				'value' => '0',
				'block_key' => 'block_1',
				'permission' => 'content_creatable',
				'fixed' => false,
			),
			'visitor' => array(
				'roles_room_id' => '5',
				'value' => '0',
				'block_key' => 'block_1',
				'permission' => 'content_creatable',
				'fixed' => true,
			),
		));
		$params = array();

		//Helperロード
		$this->loadHelper('Blocks.BlockRolePermissionForm', $viewVars, $requestData, $params);
	}

/**
 * checkboxBlockRolePermission()のテスト
 *
 * @return void
 */
	public function testCheckboxBlockRolePermission() {
		//データ生成
		$fieldName = 'BlockRolePermission.content_creatable';
		$attributes = array();

		//テスト実施
		$result = $this->BlockRolePermissionForm->checkboxBlockRolePermission($fieldName, $attributes);

		//チェック
		$this->__assertInput($result, 'checkbox',
				'data[BlockRolePermission][content_creatable][room_administrator][value]', '1',
				' disabled="disabled"', ' checked="checked"');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][room_administrator][id]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][room_administrator][roles_room_id]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][room_administrator][block_key]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][room_administrator][permission]', false);

		$this->__assertInput($result, 'checkbox',
				'data[BlockRolePermission][content_creatable][chief_editor][value]', '1',
				' disabled="disabled"', ' checked="checked"');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][chief_editor][id]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][chief_editor][roles_room_id]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][chief_editor][block_key]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][chief_editor][permission]', false);

		$this->__assertInput($result, 'checkbox',
				'data[BlockRolePermission][content_creatable][editor][value]', '1',
				'', ' checked="checked"');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][editor][id]', '3');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][editor][roles_room_id]', '3');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][editor][block_key]', 'block_1');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][editor][permission]', 'content_creatable');

		$this->__assertInput($result, 'checkbox',
				'data[BlockRolePermission][content_creatable][general_user][value]', '1');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][general_user][id]', null);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][general_user][roles_room_id]', '4');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][general_user][block_key]', 'block_1');
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][general_user][permission]', 'content_creatable');

		$this->__assertInput($result, 'checkbox',
				'data[BlockRolePermission][content_creatable][visitor][value]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][visitor][id]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][visitor][roles_room_id]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][visitor][block_key]', false);
		$this->__assertInput($result, 'hidden',
				'data[BlockRolePermission][content_creatable][visitor][permission]', false);
	}

/**
 * checkboxBlockRolePermission()のテスト
 *
 * @return void
 */
	public function testCheckboxBlockRolePermissionEmpty() {
		//データ生成
		$fieldName = 'BlockRolePermission.content_aaaaa';
		$attributes = array();

		//テスト実施
		$result = $this->BlockRolePermissionForm->checkboxBlockRolePermission($fieldName, $attributes);
		$this->assertEmpty($result);
	}

/**
 * checkboxBlockRolePermission()のテスト
 *
 * @param string $result 結果
 * @param string $type inputのtype属性
 * @param string $name inputのname属性
 * @param string $value inputのvalue属性
 * @param string $disabled inputのdisabled属性
 * @param string $checked inputのchecked属性
 * @return void
 */
	public function __assertInput($result, $type, $name, $value, $disabled = '', $checked = '') {
		preg_match('/data\[(.+)?]/', preg_replace('/\]\[/', '_', $name), $matches);
		$domId = Inflector::camelize($matches[1]);

		if ($value !== false) {
			if (isset($value)) {
				$value = ' value="' . $value . '"';
			} else {
				$value = '';
			}

			if ($disabled) {
				$ngClick = '';
			} else {
				$ngClick = ' ng-click="clickRole\(.+?\)"';
			}

			if ($type === 'checkbox') {
				$pattern =
					'(' .
						'<input type="' . $type . '" ' .
							'name="' . preg_quote($name, '/') . '"' . $ngClick . $disabled . $value . ' id="' . $domId . '"' . $checked .
					'|' .
						'<input type="' . $type . '" ' .
							'name="' . preg_quote($name, '/') . '"' . $checked . $value . ' id="' . $domId . '"' . $ngClick . $disabled .
					')';
			} else {
				$pattern =
					'<input type="' . $type . '" ' .
						'name="' . preg_quote($name, '/') . '"' . $value . ' id="' . $domId . '"';
			}
			$this->assertRegExp('/' . $pattern . '/', $result);
		} else {
			$this->assertTextNotContains($name, $result);
		}
	}

}
