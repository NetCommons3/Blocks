<?php
/**
 * BlocksControllerEditTest::setUp()テスト用TestSuite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksControllerEditTest', 'Blocks.TestSuite');

/**
 * BlocksControllerEditTest::setUp()テスト用TestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\TestSuite
 */
class TestSuiteBlocksControllerEditSetUpTest extends BlocksControllerEditTest {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'test_blocks';

/**
 * setUp method
 *
 * @return mixed テスト結果
 */
	public function setUp() {
		parent::setUp();
		return $this->_controller;
	}

}
