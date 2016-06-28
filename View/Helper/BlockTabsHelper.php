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
 * メインタブの定数(一覧表示)
 *
 * @var string
 */
	const MAIN_TAB_BLOCK_INDEX = 'block_index';

/**
 * メインタブの定数(表示方法変更)
 *
 * @var string
 */
	const MAIN_TAB_FRAME_SETTING = 'frame_settings';

/**
 * メインタブの定数(メール通知)
 *
 * @var string
 */
	const MAIN_TAB_MAIL_SETTING = 'mail_settings';

/**
 * メインタブの定数(権限設定)
 *
 * @var string
 */
	const MAIN_TAB_PERMISSION = 'role_permissions';

/**
 * ブロック設定タブ(ブロック設定)
 *
 * @var string
 */
	const BLOCK_TAB_SETTING = 'block_settings';

/**
 * ブロック設定タブ(メール通知)
 *
 * @var string
 */
	const BLOCK_TAB_MAIL_SETTING = 'mail_settings';

/**
 * ブロック設定タブ(権限設定)
 *
 * @var string
 */
	const BLOCK_TAB_PERMISSION = 'role_permissions';

/**
 * 使用ヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsHtml',
	);

/**
 * ブロックタブの設定
 *
 * ### サンプル1
 * ```
 *	public $helpers = array(
 *		'Blocks.BlockTabs' => array(
 *			'mainTabs' => array('block_index', 'frame_settings'),
 *			'blockTabs' => array('block_settings', 'mail_settings', 'role_permissions'),
 *		)
 *	);
 * ```
 *
 * ### サンプル2（urlを指定する場合）
 * ```
 *	public $helpers = array(
 *		'Blocks.BlockTabs' => array(
 *			'mainTabs' => array(
 *				'block_index' => array('url' => array('controller' => 'blog_blocks')),
 *				'frame_settings' => array('url' => array('controller' => 'blog_frame_settings')),
 *			),
 *			'blockTabs' => array(
 *				'block_settings' => array('url' => array('controller' => 'blog_blocks')),
 *				'mail_settings',
 *				'role_permissions' => array('url' => array('controller' => 'blog_block_role_permissions')),
 *			),
 *		),
 *	);
 * ```
 *
 * ### サンプル3（labelを指定する場合）
 * ```
 *	public $helpers = array(
 *		'Blocks.BlockTabs' => array(
 *			'mainTabs' => array(
 *				'block_index' => array('label' => array('blocks' => 'Block list')),
 *				'frame_settings',
 *			),
 *			'blockTabs' => array(
 *				'block_settings', 'mail_settings', 'role_permissions',
 *			),
 *		),
 *	);
 * ```
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		parent::beforeRender($viewFile);

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
		$plugin = $this->_View->params['plugin'];

		$defaultUrls = array(
			self::MAIN_TAB_BLOCK_INDEX => array(
				'url' => array(
					'plugin' => $plugin,
					'controller' => Inflector::singularize($plugin) . '_blocks',
					'action' => 'index',
					'frame_id' => Current::read('Frame.id'),
				),
				'label' => array('net_commons', 'List'),
			),
			self::MAIN_TAB_FRAME_SETTING => array(
				'url' => array(
					'plugin' => $plugin,
					'controller' => Inflector::singularize($plugin) . '_frame_settings',
					'action' => 'edit',
					'frame_id' => Current::read('Frame.id'),
				),
				'label' => array('net_commons', 'Frame settings'),
			),
			self::MAIN_TAB_MAIL_SETTING => array(
				'url' => array(
					'plugin' => $plugin,
					'controller' => Inflector::singularize($plugin) . '_mail_settings',
					'action' => 'edit',
					'frame_id' => Current::read('Frame.id'),
					'block_id' => Current::read('Block.id'),
				),
				'label' => array('mails', 'Mail settings'),
			),
			self::MAIN_TAB_PERMISSION => array(
				'url' => array(
					'plugin' => $plugin,
					'controller' => Inflector::singularize($plugin) . '_block_role_permissions',
					'action' => 'edit',
					'frame_id' => Current::read('Frame.id'),
					'block_id' => Current::read('Block.id'),
				),
				'label' => array('net_commons', 'Role permission settings'),
				'permission' => 'block_permission_editable',
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

			$settings[$key] = Hash::merge($defaultUrls[$key], $settings[$key]);
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
		$plugin = $this->_View->params['plugin'];

		//ブロック設定のタブ
		$defaultUrls = array(
			self::BLOCK_TAB_SETTING => array(
				'url' => array(
					'plugin' => $plugin,
					'controller' => Inflector::singularize($plugin) . '_blocks',
					'action' => $this->_View->params['action'],
					'frame_id' => Current::read('Frame.id'),
					'block_id' => Current::read('Block.id'),
				),
				'label' => array('blocks', 'Block settings'),
			),
			self::BLOCK_TAB_MAIL_SETTING => array(
				'url' => array(
					'plugin' => $plugin,
					'controller' => Inflector::singularize($plugin) . '_mail_settings',
					'action' => 'edit',
					'frame_id' => Current::read('Frame.id'),
					'block_id' => Current::read('Block.id'),
				),
				'label' => array('mails', 'Mail settings'),
			),
			self::BLOCK_TAB_PERMISSION => array(
				'url' => array(
					'plugin' => $plugin,
					'controller' => Inflector::singularize($plugin) . '_block_role_permissions',
					'action' => 'edit',
					'frame_id' => Current::read('Frame.id'),
					'block_id' => Current::read('Block.id'),
				),
				'label' => array('net_commons', 'Role permission settings'),
				'permission' => 'block_permission_editable',
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

			$settings[$key] = Hash::merge($defaultUrls[$key], $settings[$key]);
		}
		$this->_View->viewVars['blockSettingTabs'] = $settings;
	}

/**
 * メインタブの出力
 *
 * @param string $activeTab Active tab
 * @return string HTML tags
 */
	public function main($activeTab) {
		$tabs = $this->_View->viewVars['settingTabs'];

		$html = '';
		$html .= '<ul class="nav nav-tabs" role="tablist">';

		//一覧表示
		if (isset($tabs[self::MAIN_TAB_BLOCK_INDEX])) {
			$html .= $this->__listTag(
				$activeTab, self::MAIN_TAB_BLOCK_INDEX, $tabs[self::MAIN_TAB_BLOCK_INDEX]
			);
			unset($tabs[self::MAIN_TAB_BLOCK_INDEX]);
		}
		//表示方法変更
		if (isset($tabs[self::MAIN_TAB_FRAME_SETTING])) {
			$html .= $this->__listTag(
				$activeTab, self::MAIN_TAB_FRAME_SETTING, $tabs[self::MAIN_TAB_FRAME_SETTING]
			);
			unset($tabs[self::MAIN_TAB_FRAME_SETTING]);
		}
		//メール通知
		if (isset($tabs[self::MAIN_TAB_MAIL_SETTING])) {
			$html .= $this->__listTag(
				$activeTab, self::MAIN_TAB_MAIL_SETTING, $tabs[self::MAIN_TAB_MAIL_SETTING]
			);
			unset($tabs[self::MAIN_TAB_MAIL_SETTING]);
		}
		//権限設定
		if (isset($tabs[self::MAIN_TAB_PERMISSION])) {
			$html .= $this->__listTag(
				$activeTab, self::MAIN_TAB_PERMISSION, $tabs[self::MAIN_TAB_PERMISSION]
			);
			unset($tabs[self::MAIN_TAB_PERMISSION]);
		}
		//その他のタブ
		if ($tabs) {
			foreach ($tabs as $key => $tab) {
				$html .= $this->__listTag($activeTab, $key, $tab);
			}
		}

		$html .= '</ul>';
		return $html;
	}

/**
 * ブロック設定タブの出力
 *
 * @param string $activeTab Active tab
 * @return string HTML tags
 */
	public function block($activeTab) {
		$tabs = $this->_View->viewVars['blockSettingTabs'];

		$html = '';
		$html .= '<ul class="nav nav-pills" role="tablist">';

		//ブロック設定
		if (isset($tabs[self::BLOCK_TAB_SETTING])) {
			$html .= $this->__listTag(
				$activeTab, self::BLOCK_TAB_SETTING, $tabs[self::BLOCK_TAB_SETTING]
			);
			unset($tabs[self::BLOCK_TAB_SETTING]);
		}

		if ($this->_View->request->params['action'] === 'edit') {
			//メール通知
			if (isset($tabs[self::BLOCK_TAB_MAIL_SETTING])) {
				$html .= $this->__listTag(
					$activeTab, self::BLOCK_TAB_MAIL_SETTING, $tabs[self::BLOCK_TAB_MAIL_SETTING]
				);
				unset($tabs[self::BLOCK_TAB_MAIL_SETTING]);
			}
			//権限設定
			if (isset($tabs[self::BLOCK_TAB_PERMISSION])) {
				$html .= $this->__listTag(
					$activeTab, self::BLOCK_TAB_PERMISSION, $tabs[self::BLOCK_TAB_PERMISSION]
				);
				unset($tabs[self::BLOCK_TAB_PERMISSION]);
			}
			//その他のタブ
			if ($tabs) {
				foreach ($tabs as $key => $tab) {
					$html .= $this->__listTag($activeTab, $key, $tab);
				}
			}
		}

		$html .= '</ul>';

		$blockName = Current::read('Block.name');
		if ($this->_View->request->params['action'] === 'edit' && $blockName) {
			$html .= $this->NetCommonsHtml->tag('h2', $blockName, ['class' => 'block-title']);
		}
		return $html;
	}

/**
 * <li>の出力
 *
 * @param string $activeTab アクティブタブ
 * @param string $key タブキー
 * @param array $tab タブデータ
 * @return string <li>タグの出力
 */
	private function __listTag($activeTab, $key, $tab) {
		$html = '';

		if ($activeTab === $key) {
			$activeTabCss = 'active';
		} else {
			$activeTabCss = '';
		}

		if (Current::permission(Hash::get($tab, 'permission', 'block_editable'))) {
			$html .= '<li class="' . $activeTabCss . '">';
			$html .= $this->NetCommonsHtml->link(__d($tab['label'][0], $tab['label'][1]), $tab['url']);
			$html .= '</li>';
		}

		return $html;
	}

}
