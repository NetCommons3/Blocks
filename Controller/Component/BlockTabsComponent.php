<?php
/**
 * BlockTabs Component
 * 後で削除
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
			BLOCK_TAB_PERMISSION = 'role_permissions',
			BLOCK_TAB_MAIL = 'mail_settings';

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
		//BlockTabsComponent->BlockTabsHelper一本化するため、Noticeを表示する
		if (! Hash::get($controller->helpers, 'Blocks.BlockTabs')) {
			trigger_error('Changed to BlockTabsHelper from BlockTabsComponent.', E_USER_WARNING);
		}
		if (in_array('Blocks.BlockTabs', $controller->helpers, true)) {
			unset($controller->helpers['Blocks.BlockTabs']);
		}

		if (! Hash::get($controller->helpers, 'Blocks.BlockTabs')) {
			$controller->helpers['Blocks.BlockTabs'] = array(
				'mainTabs' => Hash::get($this->settings, 'mainTabs'),
				'blockTabs' => Hash::get($this->settings, 'blockTabs'),
			);
		}
	}
}
