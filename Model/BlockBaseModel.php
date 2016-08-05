<?php
/**
 * BlockBase Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * BlockBase Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Model
 */
class BlockBaseModel extends AppModel {

/**
 * Custom database table name
 *
 * @var string
 */
	public $useTable = false;

/**
 * Called before each save operation, after validation. Return a non-true result
 * to halt the save.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if the operation should continue, false if it should abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforesave
 * @throws InternalErrorException
 * @see Model::save()
 */
	public function beforeSave($options = array()) {
		return parent::beforeSave($options);
	}

/**
 * Saves model data (based on white-list, if supplied) to the database. By
 * default, validation occurs before save. Passthrough method to _doSave() with
 * transaction handling.
 *
 * @param array $data Data to save.
 * @param bool|array $validate Either a boolean, or an array.
 *   If a boolean, indicates whether or not to validate before saving.
 *   If an array, can have following keys:
 *
 *   - atomic: If true (default), will attempt to save the record in a single transaction.
 *   - validate: Set to true/false to enable or disable validation.
 *   - fieldList: An array of fields you want to allow for saving.
 *   - callbacks: Set to false to disable callbacks. Using 'before' or 'after'
 *     will enable only those callbacks.
 *   - `counterCache`: Boolean to control updating of counter caches (if any)
 *
 * @param array $fieldList List of fields to allow to be saved
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws Exception
 * @throws PDOException
 * @triggers Model.beforeSave $this, array($options)
 * @triggers Model.afterSave $this, array($created, $options)
 * @link http://book.cakephp.org/2.0/en/models/saving-your-data.html
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function save($data = null, $validate = true, $fieldList = array()) {
		if ($this->useTable) {
			return parent::save($data, $validate, $fieldList);
		}

		$defaults = array(
			'validate' => true, 'fieldList' => array(),
			'callbacks' => true, 'counterCache' => true,
			'atomic' => true
		);

		if (!is_array($validate)) {
			$options = compact('validate', 'fieldList') + $defaults;
		} else {
			$options = $validate + $defaults;
		}

		if ($options['callbacks'] === true || $options['callbacks'] === 'before') {
			$event = new CakeEvent('Model.beforeSave', $this, array($options));
			list($event->break, $event->breakOn) = array(true, array(false, null));
			$this->getEventManager()->dispatch($event);
			if (!$event->result) {
				//$this->whitelist = $_whitelist;
				return false;
			}
		}

		if ($options['callbacks'] === true || $options['callbacks'] === 'after') {
			$event = new CakeEvent('Model.afterSave', $this, array(false, $options));
			$this->getEventManager()->dispatch($event);
		}
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 */
	public function afterSave($created, $options = array()) {
		parent::afterSave($created, $options);
	}

}
