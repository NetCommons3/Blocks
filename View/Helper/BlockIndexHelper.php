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
		'NetCommons.MessageFlash',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
		'NetCommons.TableList',
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
		if (in_array($method, ['addLink', 'startTable', 'endTable', 'endTableRow'], true)) {
			$helper = $this->TableList;
		} else {
			$helper = $this->NetCommonsForm;
		}

		return call_user_func_array(array($helper, $method), $params);
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
		$options['url'] = NetCommonsUrl::blockUrl(
			array('plugin' => 'frames', 'controller' => 'frames', 'action' => 'edit')
		);
		$output = $this->NetCommonsForm->create('', $options);
		$output .= $this->NetCommonsForm->hidden('Frame.id');
		return $output;
	}

/**
 * ブロック一覧の画面説明を表示する
 *
 * @param string $addMsg 追加メッセージ
 * @return string HTML
 */
	public function description($addMsg = '') {
		if (!empty($addMsg)) {
			$addMsg = '<br />' . $addMsg;
		}
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
				'</button> '
			) .
			$addMsg .
		'</div>';
		return $this->MessageFlash->description($message);
	}

/**
 * NotFoundの時のブロック一覧の画面説明を表示する
 *
 * @return string HTML
 */
	public function notFoundDescription() {
		$message = '<div class="block-index-desc">' .
			sprintf(
				__d('blocks', 'When you newly created, %s, please click.'),
				'<button class="btn btn-success btn-xs">' .
					'<span class="glyphicon glyphicon-plus"></span>' .
				'</button> '
			) .
		'</div>';
		return $this->MessageFlash->description($message);
	}

/**
 * ブロック一覧の`<tr>`を表示する
 *
 * @param int $blockId ブロックID
 * @param string $fieldName フィールド名(Model.field)
 * @return string HTML
 */
	public function startTableRow($blockId, $fieldName = 'Frame.block_id') {
		$html = $this->TableList->startTableRow($blockId, $fieldName);
		return $html;
	}

/**
 * ブロック一覧の`<th>`を表示する
 *
 * @param string $fieldName フィールド名(Model.field)
 * @param string $title タイトル
 * @param array $options オプション
 * @return string HTML
 */
	public function tableHeader($fieldName, $title = '', $options = array()) {
		if ($fieldName === 'Frame.block_id') {
			$html = '<th></th>';
		} elseif ($fieldName === 'Block.public_type') {
			$options['type'] = 'center';
			$html = $this->TableList->tableHeader($fieldName, $title, $options);
		} else {
			$html = $this->TableList->tableHeader($fieldName, $title, $options);
		}

		return $html;
	}

/**
 * ブロック一覧のデータを表示する
 *
 * @param string $fieldName フィールド名(Model.field)
 * @param string|array $value 値
 * @param array $options オプション
 * @return string HTML
 */
	public function tableData($fieldName, $value = '', $options = array()) {
		$html = '';
		if ($fieldName === 'Frame.block_id') {
			$html .= '<td>';
			$html .= $this->NetCommonsForm->radio($fieldName, array($value => ''), array(
				'hiddenField' => false,
				'onclick' => 'submit()',
				'ng-click' => 'sending=true',
				'ng-disabled' => 'sending',
				'div' => array('class' => 'block-index'),
			));
			$html .= '</td>';

		} elseif ($fieldName === 'Block.public_type') {
			$html .= '<td class="nc-table-center">';

			$now = date('Y-m-d H:i:s');
			$publicType = Hash::get($value, 'Block.public_type');
			if ($publicType === Block::TYPE_PRIVATE) {
				$html .= __d('blocks', 'Private');
			} elseif ($publicType === Block::TYPE_PUBLIC) {
				$html .= __d('blocks', 'Public');
			} elseif ($now < Hash::get($value, 'Block.publish_start')) {
				$html .= __d('blocks', 'Public before');
			} elseif ($now > Hash::get($value, 'Block.publish_end')) {
				$html .= __d('blocks', 'Public end');
			} else {
				$html .= __d('blocks', 'Limited');
			}

			$html .= '</td>';

		} else {
			$html .= $this->TableList->tableData($fieldName, $value, $options);
		}

		return $html;
	}

}
