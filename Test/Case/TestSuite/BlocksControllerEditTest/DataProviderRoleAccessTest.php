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
			array( 'add', 'get', 'edit', 'chief_editor', false),
			array( 'add', 'get', 'edit', 'editor', 'ForbiddenException'),
			array( 'add', 'get', 'edit', 'general_user', 'ForbiddenException'),
			array( 'add', 'get', 'edit', 'visitor', 'ForbiddenException'),
			array( 'add', 'get', 'edit', null, 'ForbiddenException'),
			array( 'edit', 'get', 'edit', 'chief_editor', false),
			array( 'edit', 'get', 'edit', 'editor', 'ForbiddenException'),
			array( 'edit', 'get', 'edit', 'general_user', 'ForbiddenException'),
			array( 'edit', 'get', 'edit', 'visitor', 'ForbiddenException'),
			array( 'edit', 'get', 'edit', null, 'ForbiddenException'),
			array( 'delete', 'get', 'delete', 'room_administrator', 'BadRequestException'),
			array( 'delete', 'get', 'delete', 'chief_editor', 'BadRequestException'),
			array( 'delete', 'get', 'delete', 'editor', 'ForbiddenException'),
			array( 'delete', 'get', 'delete', 'general_user', 'ForbiddenException'),
			array( 'delete', 'get', 'delete', 'visitor', 'ForbiddenException'),
			array( 'delete', 'get', 'delete', null, 'ForbiddenException')
		);
		$this->assertEquals($expected, $result);
	}

}
