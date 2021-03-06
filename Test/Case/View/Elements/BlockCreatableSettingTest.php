<?php
/**
 * View/Elements/block_creatable_settingのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/block_creatable_settingのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Elements\BlockCreatableSetting
 */
class BlocksViewElementsBlockCreatableSettingTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'blocks';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Blocks', 'TestBlocks');
		//テストコントローラ生成
		$this->generateNc('TestBlocks.TestViewElementsBlockCreatableSetting');
	}

/**
 * View/Elements/block_creatable_settingのテスト
 *
 * @return void
 */
	public function testBlockCreatableSetting() {
		//テスト実行
		$this->_testGetAction('/test_blocks/test_view_elements_block_creatable_setting/block_creatable_setting/2?frame_id=6&panel_label=0',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertView();
		$this->assertTextContains(__d('blocks', 'Creatable settings'), $this->view);
	}

/**
 * View/Elements/block_creatable_settingのテスト(パネルラベル変更)
 *
 * @return void
 */
	public function testBlockCreatableSettingWithPanelLabel() {
		//テスト実行
		$this->_testGetAction('/test_blocks/test_view_elements_block_creatable_setting/block_creatable_setting/2?frame_id=6&panel_label=1',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertView();
		$this->assertTextContains('Modified label', $this->view);
	}

/**
 * View/Elements/block_creatable_settingのチェック
 *
 * @return void
 */
	private function __assertView() {
		$pattern = '/' . preg_quote('View/Elements/block_creatable_setting', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertTextContains('ng-controller="BlockRolePermissions"', $this->view);

		$pattern = 'data[BlockRolePermission][content_creatable][room_administrator][value]';
		$this->assertTextContains($pattern, $this->view);

		$pattern = 'data[BlockRolePermission][content_comment_creatable][room_administrator][value]';
		$this->assertTextContains($pattern, $this->view);
	}

}
