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
 * Output main tabs
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
 * Output block tabs
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
