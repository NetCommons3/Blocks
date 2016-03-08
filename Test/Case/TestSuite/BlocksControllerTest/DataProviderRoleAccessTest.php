<?php
/**
 * BlocksControllerTest::dataProviderRoleAccess()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BlocksControllerTest::dataProviderRoleAccess()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\TestSuite\BlocksControllerTest
 */
class TestSuiteBlocksControllerTestDataProviderRoleAccessTest extends NetCommonsControllerTestCase {

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
		App::uses('TestSuiteBlocksControllerTest', 'TestBlocks.TestSuite');
		$this->TestSuite = new TestSuiteBlocksControllerTest();
	}

/**
 * dataProviderRoleAccess()のテスト
 *
 * @return void
 */
	public function testDataProviderRoleAccess() {
		//データ生成

		//テスト実施
		$result = $this->TestSuite->dataProviderRoleAccess();

		//チェック
		//TODO:assertを書く
		$expected = array(
			array('room_administrator', false),
			array('chief_editor', false),
			array('editor', true),
			array('general_user', true),
			array('visitor', true),
			array(null, true),
		);
		$this->assertEquals($expected, $result);
	}

}
