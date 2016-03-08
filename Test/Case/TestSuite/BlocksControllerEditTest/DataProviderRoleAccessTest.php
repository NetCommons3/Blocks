<?php
/**
 * BlocksControllerEditTest::dataProviderRoleAccess()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerEditTest::dataProviderRoleAccess()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerEditTest
 */
class TestSuiteBlocksControllerEditTestDataProviderRoleAccessTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlocksControllerEditTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlocksControllerEditTest();
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
			0 => array( 'add', 'get', 'edit', 'chief_editor', false),
			1 => array( 'add', 'get', 'edit', 'editor', 'ForbiddenException'),
			2 => array( 'add', 'get', 'edit', 'general_user', 'ForbiddenException'),
			3 => array( 'add', 'get', 'edit', 'visitor', 'ForbiddenException'),
			4 => array( 'add', 'get', 'edit', null, 'ForbiddenException'),
			5 => array( 'edit', 'get', 'edit', 'chief_editor', false),
			6 => array( 'edit', 'get', 'edit', 'editor', 'ForbiddenException'),
			7 => array( 'edit', 'get', 'edit', 'general_user', 'ForbiddenException'),
			8 => array( 'edit', 'get', 'edit', 'visitor', 'ForbiddenException'),
			9 => array( 'edit', 'get', 'edit', null, 'ForbiddenException'),
			10 => array( 'delete', 'get', 'delete', 'room_administrator', 'BadRequestException'),
			11 => array( 'delete', 'get', 'delete', 'chief_editor', 'BadRequestException'),
			12 => array( 'delete', 'get', 'delete', 'editor', 'ForbiddenException'),
			13 => array( 'delete', 'get', 'delete', 'general_user', 'ForbiddenException'),
			14 => array( 'delete', 'get', 'delete', 'visitor', 'ForbiddenException'),
			15 => array( 'delete', 'get', 'delete', null, 'ForbiddenException')
		);
		$this->assertEquals($expected, $result);
	}

}
