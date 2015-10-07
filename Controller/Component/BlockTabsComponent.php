<?php
/**
 * BlockTabs Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('Component', 'Controller');

/**
 * BlockTabs Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Controller\Component
 */
class BlockTabsComponent extends Component {

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
			BLOCK_TAB_PERMISSION = 'role_permissions';

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
		if (! in_array('Blocks.BlockTabs', $controller->helpers)) {
			$controller->helpers[] = 'Blocks.BlockTabs';
		}
	}

/**
 * Called before the Controller::beforeRender(), and before
 * the view class is loaded, and before Controller::render()
 *
 * @param Controller $controller Controller with components to beforeRender
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::beforeRender
 */
	public function beforeRender(Controller $controller) {
		//ブロックのメインタブ
		if (! isset($this->settings['mainTabs'])) {
			return;
		}

		$this->__setMainTabs($controller);

		//ブロック設定タブ
		if (! isset($this->settings['blockTabs'])) {
			return;
		}

		$this->__setBlockTabs($controller);
	}

/**
 * Set main tabs
 *
 * @param Controller $controller Controller with components to beforeRender
 * @return void
 */
	private function __setMainTabs(Controller $controller) {
		$defaultUrls = array(
			self::MAIN_TAB_BLOCK_INDEX => array(
				'plugin' => $controller->params['plugin'],
				'controller' => Inflector::singularize($controller->params['plugin']) . '_blocks',
				'action' => 'index',
				'frame_id' => Current::read('Frame.id'),
			),
			self::MAIN_TAB_FRAME_SETTING => array(
				'plugin' => $controller->params['plugin'],
				'controller' => Inflector::singularize($controller->params['plugin']) . '_frame_settings',
				'action' => 'edit',
				'frame_id' => Current::read('Frame.id'),
			),
			self::MAIN_TAB_PERMISSION => array(
				'plugin' => $controller->params['plugin'],
				'controller' => Inflector::singularize($controller->params['plugin']) . '_block_role_permissions',
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

		$controller->set('settingTabs', $settings);
	}

/**
 * Set block tabs
 *
 * @param Controller $controller Controller with components to beforeRender
 * @return void
 */
	private function __setBlockTabs(Controller $controller) {
		//ブロック設定のタブ
		$defaultUrls = array(
			self::BLOCK_TAB_SETTING => array(
				'plugin' => $controller->params['plugin'],
				'controller' => Inflector::singularize($controller->params['plugin']) . '_blocks',
				'action' => $controller->params['action'],
				'frame_id' => Current::read('Frame.id'),
				'block_id' => Current::read('Block.id'),
			),
			self::BLOCK_TAB_PERMISSION => array(
				'plugin' => $controller->params['plugin'],
				'controller' => Inflector::singularize($controller->params['plugin']) . '_block_role_permissions',
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
		$controller->set('blockSettingTabs', $settings);
	}

}
