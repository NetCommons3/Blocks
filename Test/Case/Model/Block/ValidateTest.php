<?php
/**
 * Block::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('BlockFixture', 'Blocks.Test/Fixture');

/**
 * Block::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\Block
 */
class BlockValidateTest extends NetCommonsValidateTest {

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
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['Block'] = (new BlockFixture())->records[0];

		return array(
			// * language_id
			array('data' => $data, 'field' => 'language_id', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'language_id', 'value' => 'aaa',
				'message' => __d('net_commons', 'Invalid request.')),
			// * room_id
			array('data' => $data, 'field' => 'room_id', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'room_id', 'value' => 'aaa',
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
