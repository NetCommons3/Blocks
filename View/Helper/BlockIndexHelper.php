<?php
/**
 * ブロック一覧用Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * ブロック一覧用Helper
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
		'NetCommons.Button',
		'NetCommons.Date',
		'NetCommons.LinkButton',
		'NetCommons.MessageFlash',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
		'Users.DisplayUser',
	);

/**
 * 各プラグインのHelperラップ用マジックメソッド
 *
 * 指定されたメソッドにより、各プラグインのHelperのメソッドを呼び出します。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		if ($method === 'addLink') {
			$helper = $this->Button;

			$html = '<div class="text-right block-add">';
			$html .= call_user_func_array(array($helper, $method), $params);
			$html .= '</div>';
		} else {
			$helper = $this->NetCommonsForm;
			$html = call_user_func_array(array($helper, $method), $params);
		}

		return $html;
	}

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->NetCommonsHtml->css('/blocks/css/style.css');
		parent::beforeRender($viewFile);
	}

/**
 * アクションが/frames/frames/editで、NetCommonsForm->create()の結果を出力する
 *
 * ##### return サンプル
 * ```
 * <form method="post" novalidate="novalidate" ng-submit="submit($event)" action="/frames/frames/edit">
 * ```
 *
 * @param mixed $model モデル名
 * @param array $options オプション
 * @return string
 */
	public function create($model = null, $options = array()) {
		$options['url'] = $this->NetCommonsHtml->url(
			array('plugin' => 'frames', 'controller' => 'frames', 'action' => 'edit')
		);
		$output = $this->NetCommonsForm->create('', $options);
		$output .= $this->NetCommonsForm->hidden('Frame.id');
		return $output;
	}

/**
 * ブロック一覧の画面説明を表示する
 *
 * @return string HTML
 */
	public function description($message = null) {
		if (! isset($message)) {
			$message = '<div class="block-index-desc">' .
				sprintf(
					__d('blocks', '%sThe highlighted%s target, %s, is currently displayed.'),
					'<table class="table"><tbody><tr class="active"><td>',
					'</td></tr></tbody></table>',
					Current::read('Plugin.name'),
					'<button class="btn btn-success btn-xs">' .
						'<span class="glyphicon glyphicon-plus"></span>' .
					'</button> ',
					'<button class="btn btn-primary btn-xs">' .
						'<span class="glyphicon glyphicon-edit"></span>' .
					'</button> ',
					'<button class="btn btn-primary btn-xs">' .
						'<span class="glyphicon glyphicon-edit"></span>' .
					'</button> '
				) .
			'</div>';
		}
		return $this->MessageFlash->description($message);
	}

/**
 * ブロック一覧の`<table>`を表示する
 *
 * @return string HTML
 */
	public function startTable() {
		$html = '';

		$html .= '<div class="table-responsive">';
		$html .= '<table class="table table-hover">';
		return $html;
	}

/**
 * ブロック一覧の`</table>`を表示する
 *
 * @return string HTML
 */
	public function endTable() {
		$html = '';
		$html .= '</table>';
		$html .= '</div>';
		return $html;
	}

/**
 * ブロック一覧の`<tr>`を表示する
 *
 * @param int $blockId ブロックID
 * @param string $fieldName フィールド名(Model.field)
 * @return string HTML
 */
	public function startTableRow($blockId, $fieldName = 'Frame.block_id') {
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
 * @param array $options オプション
 * - type
 *   - false
 *   - text
 *   - datetime
 *   - numeric
 *   - center
 *   - right
 *   - link
 *   - handle
 * - sort<br>
 * ソートを表示するかどうか
 * @return string HTML
 */
	public function tableHeader($fieldName, $title = '', $options = array()) {
		$type = Hash::get($options, 'type', 'text');

		if ($fieldName === 'Frame.block_id') {
			$start = '<th>';
		} elseif (in_array($type, ['text', 'datetime', 'numeric', 'center', 'right', 'link', 'handle'])) {
			$start = '<th class="block-index-' . $type . '">';
		} else {
			$start = '<th>';
		}

		if (Hash::get($options, 'sort', false)) {
			$title = $this->_View->Paginator->sort($fieldName, $title);
		}

		$end = '</th>';

		return $start . $title . $end;
	}

/**
 * ブロック一覧のデータを表示する
 *
 * @param string $fieldName フィールド名(Model.field)
 * @param string|array $value 値
 * @param array $options オプション
 * - type
 *   - false
 *   - text
 *   - datetime
 *   - numeric
 *   - center
 *   - right
 *   - link リンクを付ける
 *   - handle ハンドルを表示する
 * - escape
 * - block_id<br>
 * ブロックIDを指定した場合、編集ボタンを付与させる
 * - format（数値の場合のみ有効）<br>
 * 出力のフォーマット。詳しくは、[__dn()](http://book.cakephp.org/2.0/ja/core-libraries/global-constants-and-functions.html#__dn)
 *   - domain
 *   - singular
 *   - plural
 * @return string HTML
 */
	public function tableData($fieldName, $value = '', $options = array()) {
		$type = Hash::get($options, 'type', 'text');

		if ($fieldName === 'Frame.block_id') {
			$start = '<td>';
			$value = $this->NetCommonsForm->radio($fieldName, array($value => ''), array(
				'hiddenField' => false,
				'onclick' => 'submit()',
				'ng-click' => 'sending=true',
				'ng-disabled' => 'sending',
				'div' => array('class' => 'block-index'),
			));
			$options = Hash::insert($options, 'escape', false);

		} elseif ($type === 'datetime') {
			$start = '<td class="block-index-' . $type . '">';
			$value = $this->Date->dateFormat($value);

		} elseif ($type === 'link') {
			$start = '<td class="block-index-' . $type . '">';
			$value = $this->NetCommonsHtml->link(
				$value, $value, array('target' => '_blank')
			);
			$options = Hash::insert($options, 'escape', false);

		} elseif ($type === 'handlename') {
			$start = '<td class="block-index-' . $type . '">';
			$value = $this->DisplayUser->handleLink($value, ['avatar' => true], [], $fieldName);
			$options = Hash::insert($options, 'escape', false);

		} elseif (in_array($type, ['text', 'numeric', 'center', 'right'])) {
			$start = '<td class="block-index-' . $type . '">';

		} else {
			$start = '<td>';
		}

		if (Hash::get($options, 'format')) {
			$value = sprintf(
				__dn(
					Hash::get($options, 'format.domain', 'net_commons'),
					Hash::get($options, 'format.singular', '%d'),
					Hash::get($options, 'format.plural', '%d'),
					(int)$value
				),
				(int)$value
			);
		}

		if (Hash::get($options, 'escape', true)) {
			$value = h($value);
		}

		if (Hash::get($options, 'blockId', false)) {
			$value .= '  ' . $this->LinkButton->edit('',
				array('block_id' => Hash::get($options, 'blockId')),
				array('iconSize' => ' btn-xs block-edit')
			);
		}

		$end = '</td>';

		return $start . $value . $end;
	}

}
