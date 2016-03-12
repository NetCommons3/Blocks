<?php
/**
 * View/Blocks/not_foundテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Blocks/not_foundテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Controller
 */
class TestViewBlocksNotFoundController extends AppController {

/**
 * 使用ヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings', 'mail_settings', 'role_permissions'),
			'blockTabs' => array('block_settings', 'mail_settings', 'role_permissions'),
		)
	);

/**
 * form_hidden
 *
 * @return void
 */
	public function index() {
		$this->autoRender = true;

		$this->view = 'Blocks.Blocks/not_found';
	}

}
