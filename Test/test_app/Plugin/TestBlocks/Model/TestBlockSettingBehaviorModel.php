<?php
/**
 * BlockSettingBehaviorテスト用Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');
App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');

/**
 * BlockSettingBehaviorテスト用Model
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Model
 */
class TestBlockSettingBehaviorModel extends AppModel {

/**
 * テーブル名
 *
 * @var mixed
 */
	public $useTable = false;

/**
 * 使用ビヘイビア
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.BlockSetting' => array(
			BlockSettingBehavior::FIELD_USE_WORKFLOW,
			BlockSettingBehavior::FIELD_USE_LIKE,
			BlockSettingBehavior::FIELD_USE_UNLIKE,
			BlockSettingBehavior::FIELD_USE_COMMENT,
			BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL,
			'auto_play',
			'total_size',
		),
	);

}
