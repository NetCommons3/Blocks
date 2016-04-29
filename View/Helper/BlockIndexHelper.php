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
class BlockIndexHelper extends AppHelper {

/**
 * 使用するHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml'
	);

/**
 * 各プラグインNetCommonsFormHelperラップ用マジックメソッド
 *
 * 指定されたメソッドにより、各プラグインのNetCommonsFormHelperのメソッドを呼び出します。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		//それ以外
		$helper = $this->NetCommonsForm;
		return call_user_func_array(array($helper, $method), $params);
	}

/**
 * アクションが/frames/frames/editで、NetCommonsForm->create()の結果を出力する
 *
 * @param mixed $model モデル名
 * @param array $options オプション
 * @return string
 * ##### return サンプル
 * ```
 * <form method="post" novalidate="novalidate" ng-submit="submit($event)" action="/frames/frames/edit">
 * ```
 */
	public function create($model = null, $options = array()) {
		$options['url'] = $this->NetCommonsHtml->url(
			array('plugin' => 'frames', 'controller' => 'frames', 'action' => 'edit')
		);
		$output = $this->NetCommonsForm->create('', $options);
		return $output;
	}

/**
 * ブロック一覧の`<tr>`を表示する
 *
 * @param int $blockId ブロックID
 * @param string $fieldName フィールド名(Model.field)
 * @return string HTML
 */
	public function startTableRow($blockId, $fieldName = 'Frame.id') {
		if (Hash::get($this->_View->request->data, $fieldName) === $blockId) {
			$active = ' class="active"';
		} else {
			$active = '';
		}

		$html = '<tr' . $active . '>';
		return $html;
	}

/**
 * ブロック一覧の`</tr>`を表示する
 *
 * @return string HTML
 */
	public function endTableRow() {
		$html = '</tr>';
		return $html;
	}

/**
 * ブロック一覧の`<th>`を表示する
 *
 * @param string $fieldName フィールド名(Model.field)
 * @param string $title タイトル
 * @param string $type タイプによって、文字位置(left,center,right)を調整する
 * - text(デフォルト)
 * - numeric
 * - datetime
 * - center
 * - right
 * @param array $options オプション
 * @return string HTML
 */
	public function tableHeader($fieldName, $title, $type = 'text', $options = array()) {
		if ($fieldName === 'Frame.id') {
			$start = '<th>';
		} elseif ($type === 'text') {
			$start = '<th class="block-index-' . $type . '">';
		} else {
			$start = '<th>';
		}

		$end = '</th>';

		return $start . $end;
	}

/**
 * ブロック一覧のラジオボタン
 *
 * @param int $blockId ブロックID
 * @param string $fieldName フィールド名(Model.field)
 * @return string HTML
 */
	public function settingFrame($blockId, $fieldName = 'Frame.id') {
		$html = '';

		$html .= '<td>';
		$html .= $this->NetCommonsForm->radio($fieldName, array($blockId => ''), array(
			'hiddenField' => false,
			'onclick' => 'submit()',
			'ng-click' => 'sending=true',
			'ng-disabled' => 'sending',
			'div' => array('class' => 'block-index'),
		));
		$html .= '</td>';

		return $html;
	}

}
