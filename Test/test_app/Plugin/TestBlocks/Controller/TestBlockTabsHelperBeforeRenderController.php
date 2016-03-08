<?php
/**
 * BlockTabsHelperテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * BlockTabsHelperテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestBlockTabsHelperBeforeRenderController extends AppController {

/**
 * 使用ヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings', 'mail_settings', 'role_permissions'),
			'blockTabs' => array('block_settings', 'role_permissions', 'mail_settings'),
		)
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->autoRender = true;
	}

/**
 * index
 *
 * @return void
 */
	public function index_w_o_main_tabs() {
		$this->autoRender = true;
		$this->view = 'index';
		unset($this->helpers['Blocks.BlockTabs']['mainTabs']);
	}

/**
 * index
 *
 * @return void
 */
	public function index_w_o_block_tabs() {
		$this->autoRender = true;
		$this->view = 'index';
		unset($this->helpers['Blocks.BlockTabs']['blockTabs']);
	}

}
