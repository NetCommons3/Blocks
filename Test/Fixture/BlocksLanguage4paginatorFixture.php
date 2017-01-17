<?php
/**
 * BlocksLanguageFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksLanguageFixture', 'Blocks.Test/Fixture');

/**
 * ページネーション用のBlocksLanguageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Fixture
 */
class BlocksLanguage4paginatorFixture extends BlocksLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'BlocksLanguage';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//公開データ
		array(
			'id' => '2',
			'language_id' => '2',
			'block_id' => '2',
			'name' => 'Block name 1',
			'is_origin' => true,
			'is_translation' => false,
			'is_original_copy' => false,
		),
		//非公開データ
		array(
			'id' => '4',
			'language_id' => '2',
			'block_id' => '4',
			'name' => 'Block name 2',
			'is_origin' => true,
			'is_translation' => false,
			'is_original_copy' => false,
		),
		//期間限定公開(範囲内)
		array(
			'id' => '6',
			'language_id' => '2',
			'block_id' => '6',
			'name' => 'Block name 3',
			'is_origin' => true,
			'is_translation' => false,
			'is_original_copy' => false,
		),

		//期間限定公開(過去)
		array(
			'id' => '8',
			'language_id' => '2',
			'block_id' => '8',
			'name' => 'Block name 4',
			'is_origin' => true,
			'is_translation' => false,
			'is_original_copy' => false,
		),

		//期間限定公開(未来)
		array(
			'id' => '10',
			'language_id' => '2',
			'block_id' => '10',
			'name' => 'Block name 5',
			'is_origin' => true,
			'is_translation' => false,
			'is_original_copy' => false,
		),

		//11-20は、各プラグインで設定関係のテストで使う

		//101-200まで、ページ遷移のためのテスト
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		for ($i = 11; $i <= 20; $i++) {
			$this->records[$i] = array(
				'id' => $i,
				'language_id' => '2',
				'block_id' => $i,
				'name' => 'Block name ' . $i,
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
			);
		}
		for ($i = 101; $i <= 200; $i++) {
			$this->records[$i] = array(
				'id' => $i,
				'language_id' => '2',
				'block_id' => $i,
				'name' => 'Block name ' . $i,
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
			);
		}
		parent::init();
	}

}
