<?php
/**
 *
 * Topic Prefixes extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\topicprefixes\migrations;

/**
 * Class install_schema
 */
class install_schema extends \phpbb\db\migration\migration
{
	/**
	 * @inheritdoc
	 */
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'topic_prefixes');
	}

	/**
	 * @inheritdoc
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v31x\v314'];
	}

	/**
	 * Add the topic prefixes schema to the database:
	 *    topic_prefixes:
	 *        prefix_id       Prefix identifier
	 *        prefix_tag      Prefix tag
	 *        prefix_enabled  Prefix enabled/disabled state
	 *        forum_id        The forum identifier associated with the prefix
	 *    topics:
	 *        topic_prefix_id The prefix identifier associated with the topic
	 *
	 * @return array Array of table schema
	 */
	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'topic_prefixes'	=> [
					'COLUMNS'     => [
						'prefix_id'			=> ['UINT', null, 'auto_increment'],
						'prefix_tag'		=> ['VCHAR_UNI', ''],
						'prefix_enabled'	=> ['BOOL', 1],
						'forum_id'			=> ['UINT', 0],
					],
					'PRIMARY_KEY'			=> 'prefix_id',
				],
			],
			'add_columns'	=> [
				$this->table_prefix . 'topics'			=> [
					'topic_prefix_id'		=> ['UINT', 0],
				],
			],
		];
	}

	/**
	 * Drop the topic prefixes schema from the database
	 *
	 * @return array Array of table schema
	 */
	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'topic_prefixes',
			],
			'drop_columns'	=> [
				$this->table_prefix . 'topics'			=> [
					'topic_prefix_id',
				],
			],
		];
	}
}
