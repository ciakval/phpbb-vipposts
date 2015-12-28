<?php
/**
 * This file is part of the phpBB VIP Posts package.
 *
 * @copyright (c) 2015, Jan Remes
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * @package ciakval/vipposts/migrations
 */


namespace ciakval\vipposts\migrations;

class release_0_1_0 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array(
			'\phpbb\db\migration\data\v310\rc6'
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'posts'	=> array(
					'post_vip'	=> array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'posts'	=> array(
					'post_vip',
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			array('permission.add', array('u_vip_view')),	// View VIP posts ( = be VIP )
			array('permission.add', array('u_vip_set')),	// Set VIP to on/off ( = be author or mod/admin )

			array('permission.permission_set', array('ADMINISTRATORS', 'u_vip_view', 'group')),
			array('permission.permission_set', array('ADMINISTRATORS', 'u_vip_set', 'group')),

			array('permission.permission_set', array('GLOBAL_MODERATORS', 'u_vip_view', 'group')),
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'u_vip_set', 'group'))
		);
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists(
			$this->table_prefix . 'posts', 'post_vip'
		);
	}

}
