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
 * @package NetCommons\Mails\Config\Migration
 */
class BlockSettingMigration extends NetCommonsMigration {

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
		$this->loadModels(array(
			'BlockSetting' => 'Blocks.BlockSetting',
		));

		foreach ($this->records as $model => $records) {
			$conditions = array(
				'plugin_key' => $pluginKey,
				'room_id' => null,
				'block_key' => null,
			);

			if ($direction == 'up') {
				if (!$this->updateRecords($model, $records)) {
					return false;
				}

			} elseif ($direction == 'down') {
				if (!$this->BlockSetting->deleteAll($conditions, false, false)) {
					return false;
				}
			}
		}
		return true;
	}
}
