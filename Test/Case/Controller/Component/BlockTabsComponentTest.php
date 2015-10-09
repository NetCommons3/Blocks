<?php
/**
 * BlockTabsComponentテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Controller', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');

App::uses('BlockTabsComponent', 'Blocks.Controller/Component');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('Current', 'NetCommons.Utility');
App::uses('NetCommonsUrl', 'NetCommons.Utility');

/**
 * BlockTabsComponentテスト用のコントローラ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Controller
 */
class TestBlockTabsController extends Controller {

}

/**
 * BlockTabsComponentテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Controller
 */
class BlockTabsComponentTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Controller for BlockTabs component test
 *
 * @var mixed Controller
 */
	private $__controller = null;

/**
 * Component for BlockTabs component test
 *
 * @var mixed Component
 */
	private $__component = null;

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		//テストコントローラ読み込み
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->__controller = new TestBlockTabsController($CakeRequest, $CakeResponse);
		//コンポーネント読み込み
		$Collection = new ComponentCollection();
		$this->__component = new BlockTabsComponent($Collection);

		//カレントデータセット
		Current::initialize($this->__controller->request);

		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->__component);
		unset($this->__controller);
	}

/**
 * Componentname::startup()テスト
 *
 * @return void
 */
	public function testStartup() {
		$this->__component->startup($this->__controller);
		$this->assertTrue(in_array('Blocks.BlockTabs', $this->__controller->helpers, true));
	}

/**
 * Componentname::beforeRender()のmainTabsなしテスト
 *
 * @return void
 */
	public function testBeforeRenderWOMainTabs() {
		$this->__component->beforeRender($this->__controller);
		$this->assertFalse(isset($this->__controller->viewVars['settingTabs']));
	}

/**
 * Componentname::beforeRender()のmainTabsテスト
 *
 * @return void
 */
	public function testBeforeRenderMainTabs() {
		$this->__component->settings['mainTabs'] = array(
			BlockTabsComponent::MAIN_TAB_BLOCK_INDEX => array(
				'url' => array('plugin' => 'test', 'controller' => 'test', 'action' => 'test')
			),
			BlockTabsComponent::MAIN_TAB_FRAME_SETTING,
			'original' => array(
				'url' => array('plugin' => 'test2', 'controller' => 'test2', 'action' => 'test2')
			),
		);

		$this->__component->beforeRender($this->__controller);
		$this->assertTrue(isset($this->__controller->viewVars['settingTabs']));
	}

/**
 * Componentname::beforeRender()のblockTabsなしテスト
 *
 * @return void
 */
	public function testBeforeRenderWOBlockTabs() {
		$this->testBeforeRenderMainTabs();
		$this->assertFalse(isset($this->__controller->viewVars['blockSettingTabs']));
	}

/**
 * Componentname::beforeRender()のblockTabsテスト
 *
 * @return void
 */
	public function testBeforeRenderBlockTabs() {
		$this->__component->settings['blockTabs'] = array(
			BlockTabsComponent::BLOCK_TAB_SETTING => array(
				'url' => array('plugin' => 'test', 'controller' => 'test', 'action' => 'test')
			),
			BlockTabsComponent::BLOCK_TAB_PERMISSION,
			'original' => array(
				'url' => array('plugin' => 'test2', 'controller' => 'test2', 'action' => 'test2')
			),
		);

		$this->testBeforeRenderMainTabs();

		$this->assertTrue(isset($this->__controller->viewVars['blockSettingTabs']));
	}

}
