<?php
/**
 * BlockTabs Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * BlockTabs Helper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\View\Helper
 */
class BlockTabsHelper extends AppHelper {

/**
 * Const of main tab
 *
 * @var string
 */
	const MAIN_TAB_BLOCK_INDEX = 'block_index',
			MAIN_TAB_FRAME_SETTING = 'frame_settings',
			MAIN_TAB_PERMISSION = 'role_permissions';

/**
 * Const of main tab
 *
 * @var string
 */
	const BLOCK_TAB_SETTING = 'block_settings',
			BLOCK_TAB_PERMISSION = 'role_permissions',
			BLOCK_TAB_MAIL = 'mail_settings';

/**
 * Default Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		//ブロックのメインタブ
		if (! isset($this->settings['mainTabs'])) {
			return;
		}
		$this->setMainTabs($this->settings['mainTabs']);

		//ブロック設定タブ
		if (! isset($this->settings['blockTabs'])) {
			return;
		}
		$this->setBlockTabs($this->settings['blockTabs']);
	}

/**
 * メインタブのセット
 *
 * @param array $mainTabs メインタブ配列
 * @return void
 */
	public function setMainTabs($mainTabs) {
		$this->settings['mainTabs'] = $mainTabs;

		$defaultUrls = array(
			self::MAIN_TAB_BLOCK_INDEX => array(
				'plugin' => $this->_View->params['plugin'],
				'controller' => Inflector::singularize($this->_View->params['plugin']) . '_blocks',
				'action' => 'index',
				'frame_id' => Current::read('Frame.id'),
			),
			self::MAIN_TAB_FRAME_SETTING => array(
				'plugin' => $this->_View->params['plugin'],
				'controller' => Inflector::singularize($this->_View->params['plugin']) . '_frame_settings',
				'action' => 'edit',
				'frame_id' => Current::read('Frame.id'),
			),
			self::MAIN_TAB_PERMISSION => array(
				'plugin' => $this->_View->params['plugin'],
				'controller' => Inflector::singularize($this->_View->params['plugin']) . '_block_role_permissions',
				'action' => 'edit',
				'frame_id' => Current::read('Frame.id'),
				'block_id' => Current::read('Block.id'),
			),
		);

		$settings = array();
		foreach ($this->settings['mainTabs'] as $key => $tab) {
			if (! is_array($tab) && in_array($tab, $this->settings['mainTabs'], true)) {
				$this->settings['mainTabs'][$tab] = array();
				$key = $tab;
			}

			$settings[$key] = $this->settings['mainTabs'][$key];

			if (! isset($defaultUrls[$key])) {
				continue;
			}

			if (isset($this->settings['mainTabs'][$key]['url']['plugin'])) {
				$defaultUrls[$key]['plugin'] = $this->settings['mainTabs'][$key]['url']['plugin'];
			}
			if (isset($this->settings['mainTabs'][$key]['url']['controller'])) {
				$defaultUrls[$key]['controller'] = $this->settings['mainTabs'][$key]['url']['controller'];
			}
			if (isset($this->settings['mainTabs'][$key]['url']['action'])) {
				$defaultUrls[$key]['action'] = $this->settings['mainTabs'][$key]['url']['action'];
			}

			$settings[$key]['url'] = NetCommonsUrl::actionUrl($defaultUrls[$key]);
		}

		$this->_View->viewVars['settingTabs'] = $settings;
	}

/**
 * ブロック設定タブのセット
 *
 * @param array $blockTabs ブロックタブ配列
 * @return void
 */
	public function setBlockTabs($blockTabs) {
		$this->settings['blockTabs'] = $blockTabs;

		//ブロック設定のタブ
		$defaultUrls = array(
			self::BLOCK_TAB_SETTING => array(
				'plugin' => $this->_View->params['plugin'],
				'controller' => Inflector::singularize($this->_View->params['plugin']) . '_blocks',
				'action' => $this->_View->params['action'],
				'frame_id' => Current::read('Frame.id'),
				'block_id' => Current::read('Block.id'),
			),
			self::BLOCK_TAB_PERMISSION => array(
				'plugin' => $this->_View->params['plugin'],
				'controller' => Inflector::singularize($this->_View->params['plugin']) . '_block_role_permissions',
				'action' => 'edit',
				'frame_id' => Current::read('Frame.id'),
				'block_id' => Current::read('Block.id'),
			),
			self::BLOCK_TAB_MAIL => array(
				'plugin' => $this->_View->params['plugin'],
				'controller' => Inflector::singularize($this->_View->params['plugin']) . '_mail_settings',
				'action' => 'edit',
				'frame_id' => Current::read('Frame.id'),
				'block_id' => Current::read('Block.id'),
			),
		);

		$settings = array();
		foreach ($this->settings['blockTabs'] as $key => $tab) {
			if (! is_array($tab) && in_array($tab, $this->settings['blockTabs'], true)) {
				$this->settings['blockTabs'][$tab] = array();
				$key = $tab;
			}

			$settings[$key] = $this->settings['blockTabs'][$key];

			if (! isset($defaultUrls[$key])) {
				continue;
			}

			if (isset($this->settings['blockTabs'][$key]['url']['plugin'])) {
				$defaultUrls[$key]['plugin'] = $this->settings['blockTabs'][$key]['url']['plugin'];
			}
			if (isset($this->settings['blockTabs'][$key]['url']['controller'])) {
				$defaultUrls[$key]['controller'] = $this->settings['blockTabs'][$key]['url']['controller'];
			}
			if (isset($this->settings['blockTabs'][$key]['url']['action'])) {
				$defaultUrls[$key]['action'] = $this->settings['blockTabs'][$key]['url']['action'];
			}

			$settings[$key]['url'] = NetCommonsUrl::actionUrl($defaultUrls[$key]);
		}
		$this->_View->viewVars['blockSettingTabs'] = $settings;
	}

/**
 * メインタブの出力
 *
 * @param string $active Active tab
 * @return string HTML tags
 */
	public function main($active) {
		return $this->_View->element('Blocks.main_tabs', array(
			'tabs' => $this->_View->viewVars['settingTabs'],
			'active' => $active
		));
	}

/**
 * ブロック設定タブの出力
 *
 * @param string $active Active tab
 * @return string HTML tags
 */
	public function block($active) {
		return $this->_View->element('Blocks.block_tabs', array(
			'tabs' => $this->_View->viewVars['blockSettingTabs'],
			'active' => $active
		));
	}
}
