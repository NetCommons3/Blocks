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
		'NetCommons.NetCommonsForm'
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
			if (! $role['default'] && $role['fixed']) {
				continue;
			}

			$html .= '<span class="checkbox-separator"></span>';
			$html .= '<div class="form-group">';
			$html .= $this->__inputBlockRolePermission($model, $permission, $roleKey, $attributes);
			$html .= '</div>';
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

		$fieldName = $model . '.' . $permission . '.' . $roleKey;
		if ($permission === 'content_creatable') {
			$pubFieldName = $model . '.' . 'content_publishable' . '.' . $roleKey;
		} elseif ($permission === 'content_comment_creatable') {
			$pubFieldName = $model . '.' . 'content_comment_publishable' . '.' . $roleKey;
		} else {
			$pubFieldName = '';
		}

		if (! Hash::get($this->_View->request->data, $fieldName . '.fixed')) {
			$html .= $this->NetCommonsForm->hidden($fieldName . '.id');
			$html .= $this->NetCommonsForm->hidden($fieldName . '.roles_room_id');
			$html .= $this->NetCommonsForm->hidden($fieldName . '.block_key');
			$html .= $this->NetCommonsForm->hidden($fieldName . '.permission');
		}

		$options = Hash::merge(array(
			'div' => false,
			'disabled' => (bool)Hash::get($this->_View->request->data, $fieldName . '.fixed')
		), $attributes);
		if (! $options['disabled']) {
			$options['ng-click'] = 'clickRole($event, \'' . $permission . '\', \'' . Inflector::variable($roleKey) . '\')';
		}
		$html .= $this->NetCommonsForm->checkbox($fieldName . '.value', $options);
		$html .= $this->NetCommonsForm->label($fieldName . '.value', h($this->_View->viewVars['roles'][$roleKey]['name']));

		if (! $pubFieldName) {
			return $html;
		}
		if (Hash::get($this->_View->request->data, $pubFieldName . '.id')) {
			$outputPublishable = true;
		} elseif (! (bool)Hash::get($this->_View->request->data, $fieldName . '.fixed')) {
			$outputPublishable = true;
		} else {
			//作成権限ON固定で、公開権限がOFFの場合、inputタグを表示する
			$outputPublishable = ! Hash::get($this->_View->request->data, $pubFieldName . '.default');
		}
		if (! $outputPublishable) {
			return $html;
		}

		$html .= $this->NetCommonsForm->hidden($pubFieldName . '.id');
		$html .= $this->NetCommonsForm->hidden($pubFieldName . '.roles_room_id');
		$html .= $this->NetCommonsForm->hidden($pubFieldName . '.block_key');
		$html .= $this->NetCommonsForm->hidden($pubFieldName . '.permission');
		//$html .= $this->NetCommonsForm->hidden($pubFieldName . '.value');

		return $html;
	}

}
