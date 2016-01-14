<?php
/**
 * This file is part of the VIP Posts extension package
 *
 * @copyright	(c) 2016, Honza Remes
 * @license		GNU General Public License, version 2 (GPL-2.0)
 *
 * @package		ciakval/vipposts/migrations
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
			array('permission.add', array('u_vip_post')),	// Mark posts as VIP
			array('permission.add', array('m_vip_set')),	// Set VIP to on/off ( = be author or mod/admin

			array('permission.permission_set', array('ADMINISTRATORS', 'u_vip_view', 'group')),
			array('permission.permission_set', array('ADMINISTRATORS', 'u_vip_post', 'group')),
			array('permission.permission_set', array('ADMINISTRATORS', 'm_vip_set', 'group')),

			array('permission.permission_set', array('GLOBAL_MODERATORS', 'u_vip_view', 'group')),
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'u_vip_post', 'group')),
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'm_vip_set', 'group')),

			array('config.add', array('vipposts_highlight', false)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_VIPPOSTS_TITLE'
			)),

			array('module.add', array(
				'acp',
				'ACP_VIPPOSTS_TITLE',
				array(
					'module_basename'	=> '\ciakval\vipposts\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),

			array('permission.role_add', array('VIP_USERS', 'u_', 'VIPPOSTS_VIP_USERS')),


			// Give VIP users STANDARD_USER permissions plus VIP permissions (see down there)
			array('permission.permission_set', array(
				'VIP_USERS',
				array(
					'u_',
					'u_attach',
					'u_chgavatar',
					'u_chgcensors',
					'u_chgemail',
					'u_chgpasswd',
					'u_chgprofileinfo',
					'u_download',
					'u_hideonline',
					'u_masspm',
					'u_masspm_group',
					'u_pm_attach',
					'u_pm_bbcode',
					'u_pm_delete',
					'u_pm_download',
					'u_pm_edit',
					'u_pm_emailpm',
					'u_pm_img',
					'u_pm_printpm',
					'u_pm_smilies',
					'u_readpm',
					'u_savedrafts',
					'u_search',
					'u_sendemail',
					'u_sendim',
					'u_sendpm',
					'u_sig',
					'u_viewprofile',
					'u_vip_view',	// These lines are why we do this
					'u_vip_post',	// ^^
				),
				'role'
			)),
		);
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists(
			$this->table_prefix . 'posts', 'post_vip'
		);
	}

}
