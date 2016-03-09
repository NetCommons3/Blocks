<?php
/**
 * BlockRolePermissionsControllerEditTestテスト用Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BlockRolePermissionsControllerEditTestテスト用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Fixture
 */
class TestSuiteBlockRolePermissionsControllerEditTestModelFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => ''),
		'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'use_workflow' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => '記事の承認機能 0:使わない 1:使う'),
		'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'コメント機能 0:使わない 1:使う'),
		'use_comment_approval' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'コメントの承認機能 0:使わない 1:使う'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => ''),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => ''),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => ''),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => ''),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'block_key' => 'block_1',
			'use_workflow' => true,
			'use_comment' => true,
			'use_comment_approval' => true,
			'created_user' => '1',
			'created' => '2016-03-08 02:55:52',
			'modified_user' => '1',
			'modified' => '2016-03-08 02:55:52'
		),
		array(
			'id' => '2',
			'block_key' => 'block_2',
			'use_workflow' => false,
			'use_comment' => false,
			'use_comment_approval' => false,
			'created_user' => '1',
			'created' => '2016-03-08 02:55:52',
			'modified_user' => '1',
			'modified' => '2016-03-08 02:55:52'
		),
	);

}
