<?php
/**
 * Comment Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Comment', 'Blocks.Model');

/**
 * Comment Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Test\Case\Model
 */
class CommentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.comment',
		'plugin.blocks.user_attributes_user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Comment = ClassRegistry::init('Blocks.Comment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Comment);

		parent::tearDown();
	}

/**
 * testCreateSave
 *
 * @return  void
 */
	public function testSave() {
		CakeSession::write('Auth.User.id', 1);

		$comment['Comment'] = array(
			'plugin_key' => 'blocks',
			'content_key' => 'content',
			'comment' => 'testSave',
		);
		$result = $this->Comment->save($comment);
		unset($result['Comment']['created']);
		unset($result['Comment']['modified']);

		$expected = array(
			'Comment' => array(
				'id' => '2',
				'plugin_key' => 'blocks',
				'content_key' => 'content',
				'comment' => 'testSave',
				'created_user' => 1,
				'modified_user' => 1
			)
		);
		$this->assertEquals($expected, $result, 'Error Equals Comment');

		CakeSession::write('Auth.User.id', null);
	}

}
