<?php
/**
 * BlocksHelper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');
App::uses('Block', 'Blocks.Model');

/**
 * BlocksHelper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\View\Helper
 */
class BlocksHelper extends AppHelper {

/**
 * 使用ヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'Html',
		'NetCommons.NetCommonsHtml',
	);

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
 * タイトル（ブロックタイトル）の出力
 *
 * #### サンプル
 * ```
 * echo $this->NetCommonsHtml->blockTitle($bbs['name'])
 * ```
 * ##### 出力結果
 * ```
 * <h1>新しい掲示板 20160513074815</h1>
 * ```
 *
 * @param string $text タイトル
 * @param string $titleIcon タイトルアイコン
 * @param array $options HTML属性オプション
 * @return string `<h1>`タグ
 */
	public function blockTitle($text = '', $titleIcon = null, $options = array()) {
		$output = '';

		$escape = Hash::get($options, 'escape', true);
		if ($escape) {
			$text = h($text);
		}
		$options = Hash::insert($options, 'escape', false);

		if ($titleIcon) {
			$text = $this->NetCommonsHtml->titleIcon($titleIcon) . ' ' . $text;
		}
		if (Hash::get($options, 'status')) {
			$text = Hash::get($options, 'status') . ' ' . $text;
			$options = Hash::remove($options, 'status');
		}

		$output .= $this->Html->tag('h1', $text, $options);
		return $output;
	}

/**
 * ブロックのステータスラベルを表示
 *
 * @param null|bool $isSetting 強制的にセッティングモード
 * @return string HTML
 */
	public function getBlockStatus($isSetting = null) {
		if (! Current::permission('block_editable')) {
			return '';
		}

		if (! isset($isSetting)) {
			$isSetting = Current::isSettingMode();
		}

		if (! $isSetting || ! Current::read('Block.id')) {
			return '';
		}

		$block = Current::read('Block', array());

		$publicType = Hash::get($block, 'public_type');
		if ($publicType === Block::TYPE_PUBLIC) {
			return '';
		}

		$html = $this->__getBlockStatus();
		return $html;
	}

/**
 * ブロックのステータスラベルを表示
 *
 * @return string HTML
 */
	private function __getBlockStatus() {
		$html = '';

		$block = Current::read('Block', array());

		$publicType = Hash::get($block, 'public_type', false);
		if ($publicType === false || $publicType === Block::TYPE_PUBLIC) {
			return $html;
		}

		$now = date('Y-m-d H:i:s');
		$html .= '<span class="block-style-label label label-default">';

		if ($publicType === Block::TYPE_PRIVATE) {
			$html .= __d('blocks', 'Private');
		} elseif ($publicType === Block::TYPE_LIMITED) {
			if ($now <= Hash::get($block, 'publish_start', '0000-00-00 00:00:00')) {
				$html .= __d('blocks', 'Public before');
			} elseif ($now > Hash::get($block, 'publish_end', '9999-99-99 99:99:99')) {
				$html .= __d('blocks', 'Public end');
			} else {
				$html .= __d('blocks', 'Limited');
			}
		}

		$html .= '</span>';

		return $html;
	}

}
