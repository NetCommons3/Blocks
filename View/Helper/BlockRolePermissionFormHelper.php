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

App::uses('FormHelper', 'View/Helper');

/**
 * BlockRolePermissionForm Helper
 *
 * @package NetCommons\Blocks\View\Helper
 */
class BlockRolePermissionFormHelper extends FormHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array('Form');

/**
 * Outputs room roles radio
 *
 * @param string $fieldName Name attribute of the RADIO
 * @param array $attributes The HTML attributes of the select element.
 * @return string Formatted RADIO element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function checkboxBlockRolePermission($fieldName, $attributes = array()) {
		list($model, $permission) = explode('.', $fieldName);
		$html = '';

		if (! isset($this->_View->request->data[$model][$permission])) {
			return $html;
		}

		$html .= '<div class="form-inline">';
		foreach ($this->_View->request->data[$model][$permission] as $roleKey => $role) {
			if (! $role['value'] && $role['fixed']) {
				continue;
			}

			$html .= '<span class="checkbox-separator"></span>';
			$html .= '<div class="form-group">';
			if (! $role['fixed']) {
				$html .= $this->Form->hidden($fieldName . '.' . $roleKey . '.id');
				$html .= $this->Form->hidden($fieldName . '.' . $roleKey . '.roles_room_id');
				$html .= $this->Form->hidden($fieldName . '.' . $roleKey . '.block_key');
				$html .= $this->Form->hidden($fieldName . '.' . $roleKey . '.permission');
			}

			$options = Hash::merge(array(
				'div' => false,
				'disabled' => (bool)$role['fixed']
			), $attributes);
			if (! $options['disabled']) {
				$options['ng-click'] = 'clickRole($event, \'' . $permission . '\', \'' . Inflector::variable($roleKey) . '\')';
			}
			$html .= $this->Form->checkbox($fieldName . '.' . $roleKey . '.value', $options);

			$html .= $this->Form->label($fieldName . '.' . $roleKey . '.value', h($this->_View->viewVars['roles'][$roleKey]['name']));
			$html .= '</div>';
		}
		$html .= '</div>';

		return $html;
	}

}
