<?php
/**
 * Block::isVisible()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Block::isVisible()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Block
 */
class BlockIsVisibleTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'blocks';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'Block';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'isVisible';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - block ブロックデータ
 *  - expected 期待値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * 非公開
			array(
				'block' => array('Block' => array('public_type' => '0')),
				'expected' => false
			),
			// * 公開
			array(
				'block' => array('Block' => array('public_type' => '1')),
				'expected' => true
			),
			// * 期限付き公開(開始＋終了が指定なし)
			array(
				'block' => array('Block' => array(
					'public_type' => '2', 'publish_start' => null, 'publish_end' => null
				)),
				'expected' => true
			),
			// * 期限付き公開(開始＜現在＜終了)
			array(
				'block' => array('Block' => array(
					'public_type' => '2', 'publish_start' => '2014-01-01 00:00:00', 'publish_end' => '2099-01-01 00:00:00'
				)),
				'expected' => true
			),
			// * 期限付き公開(未来)
			array(
				'block' => array('Block' => array(
					'public_type' => '2', 'publish_start' => '2099-01-01 00:00:00', 'publish_end' => null
				)),
				'expected' => false
			),
			// * 期限付き公開(過去)
			array(
				'block' => array('Block' => array(
					'public_type' => '2', 'publish_start' => null, 'publish_end' => '2014-01-01 00:00:00'
				)),
				'expected' => false
			),
			// * 不正
			array(
				'block' => array('Block' => array('public_type' => '3')),
				'expected' => false
			),
		);
	}

/**
 * isVisible()のテスト
 *
 * @param array $block ブロックデータ
 * @param bool $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testIsVisible($block, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テスト実施
		$result = $this->$model->$methodName($block);

		//チェック
		$this->assertEquals($expected, $result);
	}

}
