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
			MAIN_TAB_FRAME_SETTING = 'frame_settings';

/**
 * Const of main tab
 *
 * @var string
 */
	const BLOCK_TAB_SETTING = 'block_settings';

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
		if (! in_array('Blocks.Block', $controller->helpers)) {
			$controller->helpers[] = 'Blocks.Block';
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
		);

		$settings = array();
		foreach ($this->settings['mainTabs'] as $key => $tab) {
			if (in_array($tab, $this->settings['mainTabs'])) {
				$this->settings['mainTabs'][$tab] = array();
				$key = $tab;
			}

			if (isset($this->settings['mainTabs'][$key])) {
				$settings[$key] = $this->settings['mainTabs'][$key];
				if (! isset($this->settings['mainTabs'][$key]['url']) && isset($defaultUrls[$key])) {
					$settings[$key]['url'] = NetCommonsUrl::actionUrl($defaultUrls[$key]);
				}
			}
		}
		$controller->set('settingTabs', $settings);

		//ブロック設定のタブ
		$defaultUrls = array(
			self::BLOCK_TAB_SETTING => array(
				'plugin' => $controller->params['plugin'],
				'controller' => Inflector::singularize($controller->params['plugin']) . '_blocks',
				'action' => $controller->params['action'],
				'frame_id' => Current::read('Frame.id'),
				'block_id' => Current::read('Block.id'),
			),
		);

		$settings = array();
		foreach ($this->settings['blockTabs'] as $key => $tab) {
			if (in_array($tab, $this->settings['blockTabs'])) {
				$this->settings['blockTabs'][$tab] = array();
				$key = $tab;
			}

			if (isset($this->settings['blockTabs'][$key])) {
				$settings[$key] = $this->settings['blockTabs'][$key];
				if (! isset($this->settings['blockTabs'][$key]['url']) && isset($defaultUrls[$key])) {
					$settings[$key]['url'] = NetCommonsUrl::actionUrl($defaultUrls[$key]);
				}
			}
		}
		$controller->set('blockSettingTabs', $settings);

		$this->controler = $controller;
	}
}
