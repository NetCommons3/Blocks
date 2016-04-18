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

App::uses('AppHelper', 'View/Helper');

/**
 * BlockForm Helper
 *
 * @package NetCommons\Blocks\View\Helper
 */
class BlockFormHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsForm'
	);

/**
 * ブロック一覧のラジオボタン
 *
 * @param string $fieldName フィールド名(Model.field)
 * @param int $blockId ブロックID
 * @return string ラジオボタン
 */
	public function displayFrame($fieldName, $blockId) {
		return $this->NetCommonsForm->radio($fieldName, array($blockId => ''), array(
			'hiddenField' => false,
			'onclick' => 'submit()',
			'ng-click' => 'sending=true',
			'ng-disabled' => 'sending',
			'div' => array('class' => 'block-index'),
		));
	}

}
