<?php
/**
 * BlockRolePermissionsControllerEditTestテスト用Viewファイル
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->create('TestSuiteBlockRolePermissionsControllerEditTestModel', array(
	'url' => '/test_blocks/TestSuiteBlockRolePermissionsControllerEditTest/edit/4?frame_id=6'
)); ?>


TestSuite/BlockRolePermissionsControllerEditTest/edit.ctp


<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>

<?php echo $this->NetCommonsForm->end();