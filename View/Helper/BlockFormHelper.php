<?php
/**
 * BlockForm Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FormHelper', 'View/Helper');

/**
 * BlockForm Helper
 *
 * @package NetCommons\Blocks\View\Helper
 */
class BlockFormHelper extends FormHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array('NetCommonsForm');

/**
 * Output setting display frame radio
 *
 * @param string $fieldName Name attribute of the RADIO
 * @param int $blockId Block.id
 * @return string Formatted RADIO element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function displayFrame($fieldName, $blockId) {
		return $this->NetCommonsForm->radio($fieldName, array($blockId => ''), array(
			'hiddenField' => false,
			'onclick' => 'submit()',
			'ng-click' => 'sending=true',
			'ng-disabled' => 'sending'
		));
	}

}
