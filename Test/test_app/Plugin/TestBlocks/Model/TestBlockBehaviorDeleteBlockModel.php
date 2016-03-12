<?php
/**
 * BlockBehavior::deleteBlock()テスト用Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * BlockBehavior::deleteBlock()テスト用Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\test_app\Plugin\TestBlocks\Model
 */
class TestBlockBehaviorDeleteBlockModel extends AppModel {

/**
 * 使用ビヘイビア
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.Block' => array(
			'loadModels' => array(
				'TestBlockBehaviorDeleteBlockIdModel' => 'TestBlocks.TestBlockBehaviorDeleteBlockIdModel',
				'TestBlockBehaviorDeleteBlockKeyModel' => 'TestBlocks.TestBlockBehaviorDeleteBlockKeyModel',
			),
		)
	);

}
