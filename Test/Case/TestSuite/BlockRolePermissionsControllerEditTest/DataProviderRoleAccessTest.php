<?php
/**
 * BlockRolePermissionsControllerEditTest::dataProviderRoleAccess()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlockRolePermissionsControllerEditTest::dataProviderRoleAccess()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlockRolePermissionsControllerEditTest
 */
class TestSuiteBlockRolePermissionsControllerEditTestDataProviderRoleAccessTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlockRolePermissionsControllerEditTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlockRolePermissionsControllerEditTest();
	}

/**
 * dataProviderRoleAccess()のテスト
 *
 * @return void
 */
	public function testDataProviderRoleAccess() {
		//テスト実施
		$result = $this->TestSuite->dataProviderRoleAccess();

		//チェック
		$expected = array(
			0 => array('room_administrator', null),
			1 => array('chief_editor', 'ForbiddenException'),
			2 => array('editor', 'ForbiddenException'),
			3 => array('general_user', 'ForbiddenException'),
			4 => array('visitor','ForbiddenException'),
			5 => array(null, 'ForbiddenException')
		);
		$this->assertEquals($expected, $result);
	}

}
