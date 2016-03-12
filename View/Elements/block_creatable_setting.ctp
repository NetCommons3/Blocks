<?php
/**
 * コンテンツの作成権限設定Element
 * WorkflowComponent->getBlockRolePermissions())で取得した結果をもとにセットする
 *
 * - settingPermissions: 設定するパーミッションデータ(key: パーミッション名、value: ラベル)
 * - panelLabel: パネルのタイトル
 *
 * ### サンプル
 * ```
 * 	echo $this->element('Blocks.block_creatable_setting', array(
 * 			'settingPermissions' => array(
 * 				'content_creatable' => __d('blocks', 'Content creatable roles'),
 * 				'content_comment_creatable' => __d('blocks', 'Content comment creatable roles'),
 * 			),
 * 			'panelLabel' => __d('blocks', 'Creatable settings')
 * 		));
 * ```
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

//ラベル
if (! isset($panelLabel)) {
	$panelLabel = __d('blocks', 'Creatable settings');
}
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<?php echo $panelLabel; ?>
	</div>

	<div class="panel-body">
		<?php echo $this->element('Blocks.block_permission_setting',
				array('settingPermissions' => $settingPermissions)
			); ?>
	</div>
</div>
