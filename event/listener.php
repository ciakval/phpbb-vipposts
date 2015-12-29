<?php

/**
 * This file is part of the VIP Posts extension package
 *
 * @copyright (C) 2015, Jan Remes
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * @package ciakval/vipposts/event
 */

namespace ciakval\vipposts\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	/** @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\auth\auth */
	protected $auth;
	/** @var \phpbb\user */
	protected $user;
	/** @var string */
	protected $root_path;
	/** @var string */
	protected $phpEx;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config   		$config             	 Config object
	 * @param \phpbb\db\driver\driver_interface      $db        	 	 DB object
	 * @param \phpbb\template\template    		$template  	 	 Template object
	 * @param \phpbb\auth\auth      			$auth           	 Auth object
	 * @param \phpbb\use		     		$user           	 User object
	 * @param	                		$root_path          	 Root Path object
	 * @param                  	     		$phpEx          	 phpEx object
	 * @return \ciakval\vipposts\event\listener
	 * @access public
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\template\template $template,
		\phpbb\auth\auth $auth,
		\phpbb\user $user,
		$root_path,
		$phpEx)
	{
		$this->config = $config;
		$this->db = $db;
		$this->template = $template;
		$this->auth = $auth;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->phpEx   = $phpEx;
	}

	/**
	 * Link handler functions to subscribed events
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.phpbb_content_visibility_get_visibility_sql_before'	=> 'limit_vip_posts',
			'core.permissions'					=> 'permissions',
			'core.posting_modify_template_vars'	=> 'posting_button',
			'core.submit_post_modify_sql_data'	=> 'posting'
		);
	}

	/**
	 * Filter out VIP posts for non-VIP users
	 *
	 * @param \phpbb\event\data	$event	Visibility SQL manipulating event
	 */
	public function limit_vip_posts($event)
	{
		if ($event['mode'] == 'post')
		{
			if ($this->auth->acl_get('!u_vip_view'))
			{
				$event['where_sql'] = 'p.post_vip = 0 AND ';
			}
		}

	}

	/**
	 * Add extension permissions to the phpBB permission system
	 *
	 * @param \phpbb\event\data	$event	Permission event
	 */
	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_vip_view'] = array('lang' => 'ACL_U_VIP_VIEW', 'cat' => 'misc');
		$permissions['u_vip_set'] = array('lang' => 'ACL_U_VIP_SET', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	/**
	 * Set template variables to control displaying 'mark as VIP' button
	 *
	 * @param \phpbb\event\data	$event	Posting template variables modifying event
	 */
	public function posting_button($event)
	{
		$page_data = $event['page_data'];
		$page_data['S_CAN_VIPPOST'] = $this->auth->acl_get('u_vip_post');
		$page_data['S_VIPPOST'] = ""; //checked
		$event['page_data'] = $page_data;
	}

	/**
	 * Propagate 'mark as VIP' post setting to the database
	 *
	 * @param \phpbb\event\data	$event	Post submission SQL manipulating event
	 */
	public function posting($event)
	{
		$sql_data = $event['sql_data'];
		$sql_data[POSTS_TABLE]['sql'] = array_merge($sql_data[POSTS_TABLE]['sql'], array(
			'post_vip' => $post_vip,
		));

		$event['sql_data'] = $sql_data;
	}
}
