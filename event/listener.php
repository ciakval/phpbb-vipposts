<?php

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
	protected $root_path;
	
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
 	* @return \staffit\toptentopics\event\listener 
 	* @access public 
 	*/ 
public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\auth\auth $auth, \phpbb\user $user, $root_path, $phpEx) 
{
   $this->config = $config;
   $this->db = $db;
   $this->template = $template; 
   $this->auth = $auth;
   $this->user = $user;
   $this->root_path = $root_path;
   $this->phpEx   = $phpEx ;
}

	static public function getSubscribedEvents()
	{
		return array(
			'core.phpbb_content_visibility_get_visibility_sql_before'	=> 'limit_vip_posts',
			'core.permissions'						=> 'permissions'
		);
	}

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
	public function permissions($event)
	{
	$permissions = $event['permissions'];
	$permissions['u_vip_view'] = array('lang' => 'ACL_U_VIP_VIEW', 'cat' => 'misc');
	$permissions['u_vip_set'] = array('lang' => 'ACL_U_VIP_SET', 'cat' => 'misc');
	$event['permissions'] = $permissions;
	}
}
