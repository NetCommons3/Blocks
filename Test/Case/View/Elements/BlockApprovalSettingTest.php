<?php
/**
 * View/Elements/block_approval_settingのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/block_approval_settingのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\View\Elements\BlockApprovalSetting
 */
class BlocksViewElementsBlockApprovalSettingTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestBlocks.TestViewElementsBlockApprovalSetting');
	}

/**
 * View/Elements/block_approval_settingのテスト用DataProvider
 *
 * ### 戻り値
 *  - approvalType 承認タイプ
 *  - useComment コメント有無
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('approvalType' => '2', 'useComment' => '1'),
			array('approvalType' => '1', 'useComment' => '0'),
			array('approvalType' => '1', 'useComment' => '1'),
			array('approvalType' => '0', 'useComment' => '0'),
			array('approvalType' => '0', 'useComment' => '1'),
		);
	}

/**
 * View/Elements/block_approval_settingのテスト
 *
 * @param int $approvalType 承認タイプ
 * @param int $useComment コメント有無
 * @dataProvider dataProvider
 * @return void
 */
	public function testBlockApprovalSetting($approvalType, $useComment) {
		//テスト実行
		$this->_testGetAction(
				'/test_blocks/test_view_elements_block_approval_setting/block_approval_setting/2?frame_id=6' .
								'&use_comment=' . $useComment . '&approval_type=' . $approvalType,
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/block_approval_setting', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertTextContains('ng-controller="BlockRolePermissions"', $this->view);

		$this->__assertWorkflow($approvalType);
		if ($useComment) {
			$this->__assertComment($approvalType);
		}
	}

/**
 * コンテンツ承認有無のチェック
 *
 * @param int $approvalType 承認タイプ
 * @return void
 */
	private function __assertWorkflow($approvalType) {
		// * ワークフロー承認の有無
		if (in_array($approvalType, ['1'], true)) {
			$pattern = '<input type="hidden"' .
								' name="' . preg_quote('data[TestBlockSetting][use_workflow]', '/') . '"' .
								' (value="1" ng-value="useWorkflow"|ng-value="useWorkflow" value="1")';
		} else {
			$pattern = '<input type="hidden"' .
								' name="' . preg_quote('data[TestBlockSetting][use_workflow]', '/') . '"' .
								' (value="0" ng-value="useWorkflow"|ng-value="useWorkflow" value="0")';
		}
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		// * 承認設定のラジオボタン
		if ($approvalType === '1') {
			$checked = 'checked="checked" ';
		} else {
			$checked = '';
		}
		$pattern = '<input type="radio" ' .
							'name="' . preg_quote('data[TestBlockSetting][approval_type]', '/') . '" ' .
							'id=".*?" value="1" ' . $checked .
							'ng-click="' . preg_quote('clickApprovalType($event)', '/') . '"';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<label for="TestBlockSettingApprovalType1">Label need_approval</label>';
		$this->assertTextContains($pattern, $this->view);

		if ($approvalType === '0') {
			$checked = 'checked="checked" ';
		} else {
			$checked = '';
		}
		$pattern = '<input type="radio" ' .
							'name="' . preg_quote('data[TestBlockSetting][approval_type]', '/') . '" ' .
							'id=".*?" value="0" ' . $checked .
							'ng-click="' . preg_quote('clickApprovalType($event)', '/') . '"';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<label for="TestBlockSettingApprovalType0">Label not_need_approval</label>';
		$this->assertTextContains($pattern, $this->view);
	}

/**
 * コンテンツ承認有無のチェック
 *
 * @param int $approvalType 承認タイプ
 * @return void
 */
	private function __assertComment($approvalType) {
		// * コメント承認の有無
		if (in_array($approvalType, ['1', '2'], true)) {
			$pattern = '<input type="hidden"' .
								' name="' . preg_quote('data[TestBlockSetting][use_comment_approval]', '/') . '"' .
								' (value="1" ng-value="useCommentApproval"|ng-value="useCommentApproval" value="1")';
		} else {
			$pattern = '<input type="hidden"' .
								' name="' . preg_quote('data[TestBlockSetting][use_comment_approval]', '/') . '"' .
								' (value="0" ng-value="useCommentApproval"|ng-value="useCommentApproval" value="0")';
		}
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		// * 承認設定のラジオボタン
		if ($approvalType === '2') {
			$checked = 'checked="checked" ';
		} else {
			$checked = '';
		}
		$pattern = '<input type="radio" ' .
							'name="' . preg_quote('data[TestBlockSetting][approval_type]', '/') . '" ' .
							'id=".*?" value="2" ' . $checked .
							'ng-click="' . preg_quote('clickApprovalType($event)', '/') . '"';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<label for="TestBlockSettingApprovalType2">Label comment_approval</label>';
		$this->assertTextContains($pattern, $this->view);

		//コメント承認権限の設定
		$pattern = '<label for="BlockRolePermissionContentCommentPublishable">Label content_comment_publishable</label>';
		$this->assertTextContains($pattern, $this->view);

		$pattern = 'data[BlockRolePermission][content_comment_publishable][room_administrator][value]';
		$this->assertTextContains($pattern, $this->view);
	}

}
