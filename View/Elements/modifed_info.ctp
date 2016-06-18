<?php
/**
 * ブロック編集情報Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

if (! isset($displayModified)) {
	$displayModified = false;
}
?>

<?php if ($this->params['action'] === 'edit' && $displayModified) : ?>
	<div class="text-right clearfix small text-muted">
		<?php
			echo '<label>' . __d('blocks', 'Created:') . '</label> ';
			echo $this->NetCommonsHtml->handleLink($this->request->data, ['avatar' => true], [], 'TrackableCreator');
			echo '<div class="pull-right block-created">' .
					'(' . $this->NetCommonsHtml->dateFormat(Hash::get($this->request->data, 'Block.created')) . ')' .
				'</div>';

			echo $this->NetCommonsForm->hidden('Block.created');
			echo $this->NetCommonsForm->hidden('TrackableCreator.id');
			echo $this->NetCommonsForm->hidden('TrackableCreator.handlename');
		?>
	</div>

	<div class="text-right clearfix small text-muted">
		<?php
			echo '<label>' . __d('blocks', 'Modified:') . '</label> ';
			echo $this->NetCommonsHtml->handleLink($this->request->data, ['avatar' => true], [], 'TrackableUpdater');
			echo '<div class="pull-right block-modified">' .
					'(' . $this->NetCommonsHtml->dateFormat(Hash::get($this->request->data, 'Block.modified')) . ')' .
				'</div>';

			echo $this->NetCommonsForm->hidden('Block.modified');
			echo $this->NetCommonsForm->hidden('TrackableUpdater.id');
			echo $this->NetCommonsForm->hidden('TrackableUpdater.handlename');
		?>
	</div>
<?php endif;