<?php
/**
 * BlockRolePermission::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('BlockRolePermissionFixture', 'Blocks.Test/Fixture');

/**
 * BlockRolePermission::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model\BlockRolePermission
 */
class BlockRolePermissionValidateTest extends NetCommonsValidateTest {

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
	protected $_modelName = 'BlockRolePermission';

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
		$data['BlockRolePermission'] = (new BlockRolePermissionFixture())->records[0];

		//TODO:テストパタンを書く
		debug($data);
		return array(
			// * roles_room_id
			array('data' => $data, 'field' => 'roles_room_id', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'roles_room_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * block_key
			array('data' => $data, 'field' => 'block_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			// * permission
			array('data' => $data, 'field' => 'permission', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			// * value
			array('data' => $data, 'field' => 'value', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'value', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'value', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
