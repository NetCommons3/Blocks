<?php
/**
 * BlockSettingMigration
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * BlockSettingMigration
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Blocks\Config\Migration
 */
class BlockSettingMigration extends NetCommonsMigration {

/**
 * plugin data
 *
 * @var array $migration
 */
	public $records = array();

/**
 * マイグレーションupの更新と,downの削除
 * [recordsの注意点] BlockSettingのデフォルト値(room_id=null, block_key=null)でfield_name=use_workflow,
 * use_comment_approvalは設定しても、無視される。rooms.need_approval（ルーム承認する）によって値決まるため
 *
 * @param string $direction Direction of migration process (up or down)
 * @param string $pluginKey プラグインキー
 * @return bool Should process continue
 */
	public function updateAndDelete($direction, $pluginKey) {
		$conditions = array(
			'plugin_key' => $pluginKey,
			'room_id' => null,
			'block_key' => null,
		);
		// コールバックoff
		$validate = array(
			'validate' => false,
			'callbacks' => false,
		);

		foreach ($this->records as $model => $records) {
			$Model = $this->generateModel($model);

			if ($direction == 'up') {
				// 登録
				foreach ($records as $record) {
					$Model->create();
					if (!$Model->save($record, $validate)) {
						return false;
					}
				}

			} elseif ($direction == 'down') {
				if (!$Model->deleteAll($conditions, false, false)) {
					return false;
				}
			}
		}
		return true;
	}
}
