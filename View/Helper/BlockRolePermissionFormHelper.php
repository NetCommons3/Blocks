<?php
/**
 * BlockRolePermissionForm Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * BlockRolePermissionForm Helper
 *
 * @package NetCommons\Blocks\View\Helper
 */
class BlockRolePermissionFormHelper extends AppHelper {

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsForm',
		'Rooms.Rooms',
	);

/**
 * BlockRolePermissionのチェックボックス表示
 *
 * @param string $fieldName フィールド名
 * @param array $attributes Formヘルパーのオプション
 * @return string HTML
 */
	public function checkboxBlockRolePermission($fieldName, $attributes = array()) {
		list($model, $permission) = explode('.', $fieldName);
		$html = '';

		if (! isset($this->_View->request->data[$model][$permission])) {
			return $html;
		}

		$html .= '<div class="form-inline">';
		foreach ($this->_View->request->data[$model][$permission] as $roleKey => $role) {
			if (! $role['default'] && $role['fixed'] || ! Hash::get($role, 'roles_room_id')) {
				continue;
			}
			$html .= $this->__inputBlockRolePermission($model, $permission, $roleKey, $attributes);
		}
		$html .= '</div>';

		return $html;
	}

/**
 * BlockRolePermissionのチェックボックス表示
 *
 * @param string $model モデル名
 * @param string $permission パーミッション
 * @param string $roleKey ロールキー
 * @param array $attributes Formヘルパーのオプション
 * @return string HTML
 */
	private function __inputBlockRolePermission($model, $permission, $roleKey, $attributes = array()) {
		$html = '';
		$html .= '<div class="checkbox checkbox-inline">';

		$fieldName = $model . '.' . $permission . '.' . $roleKey;

		if (! Hash::get($this->_View->request->data, $fieldName . '.fixed')) {
			$html .= $this->NetCommonsForm->hidden($fieldName . '.id');
			$html .= $this->NetCommonsForm->hidden($fieldName . '.roles_room_id');
			$html .= $this->NetCommonsForm->hidden($fieldName . '.block_key');
			$html .= $this->NetCommonsForm->hidden($fieldName . '.permission');
		}

		$options = Hash::merge(array(
			'div' => false,
			'disabled' => (bool)Hash::get($this->_View->request->data, $fieldName . '.fixed'),
		), $attributes);
		if (! $options['disabled']) {
			$options['ng-click'] = 'clickRole($event, ' .
							'\'' . $permission . '\', \'' . Inflector::variable($roleKey) . '\')';
		}

		$options['label'] = $this->Rooms->roomRoleName(
			$roleKey, ['help' => true, 'roles' => $this->_View->viewVars['roles']]
		);
		$options['escape'] = false;

		$html .= $this->NetCommonsForm->checkbox($fieldName . '.value', $options);

		$html .= '</div>';
		return $html;
	}

}
