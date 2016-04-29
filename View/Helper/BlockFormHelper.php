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
 * ブロック編集のForm出力
 *
 * @param array $options オプション
 * - `model` モデル名
 * - `callback` コールバックするelement
 * - `cancelUrl` キャンセルURL
 * - `callbackOptions` コールバックのオプション
 * - `options` Form->create()のオプション
 * @return string HTML
 */
	public function displayEditForm($options = array()) {
		return $this->_View->element('Blocks.edit_form', $options);
	}

/**
 * ブロック削除のForm出力
 *
 * @param array $options オプション
 * - `model` モデル名
 * - `callback` コールバックするelement
 * - `callbackOptions` コールバックのオプション
 * - `url` 削除アクション(省略可)
 * - `options` Form->create()のオプション
 * @return string HTML
 */
	public function displayDeleteForm($options = array()) {
		$html = '';

		if ($this->_View->request->params['action'] === 'edit') {
			if (Hash::get($options, 'url')) {
				$options['options']['url'] = Hash::get($options, 'url');
				$options = Hash::remove($options, 'url');
			}
			if (! Hash::get($options, 'options.url')) {
				$options['options']['url'] = NetCommonsUrl::actionUrl(array(
					'controller' => $this->_View->request->params['controller'],
					'action' => 'delete',
					'block_id' => Current::read('Block.id'),
					'frame_id' => Current::read('Frame.id')
				));
			}
			if (! Hash::get($options, 'model')) {
				$options['model'] = 'BlockDelete';
			}
			$html .= $this->_View->element('Blocks.delete_form', $options);
		}
		return $html;
	}

/**
 * ブロック一覧のラジオボタン
 * 後で削除
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
