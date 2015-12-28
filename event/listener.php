<?php

namespace ciakval\vipposts\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/* @var \phpbb\template\template */
	protected $template;

	/**
	 * Constructor
	 *
	 * @param	\phpbb\template\template	$template	Template object
	 */
	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}


	static public function getSubscribedEvents()
	{
		return array(
			'core.phpbb_content_visibility_get_visibility_sql_before'	=> 'limit_vip_posts',
			'core.permissions'	=> 'add_permissions',
			'core.posting_modify_template_vars'	=> 'set_vip_button_visibility',
			//'core.posting_modify_submit_post_before'	=> 'dump_post',
		);
	}

	public function limit_vip_posts($event)
	{
		global $auth;

		if ($event['mode'] == 'post')
		{
			if ($auth->acl_get('!u_vip_view'))
			{
				$event['where_sql'] = 'p.post_vip = 0 AND ';
			}
		}

		return $event;
	}

	public function add_permissions($event)
	{
		$permissions = $event['permissions'];

		$permissions['u_vip_view']	= array('lang'	=> 'ACL_U_VIP_VIEW',	'cat'	=> 'post');
		$permissions['u_vip_set']	= array('lang'	=> 'ACL_U_VIP_SET',		'cat'	=> 'post');

		$event['permissions'] = $permissions;
	}

	public function set_vip_button_visibility($event)
	{
		global $auth;
		global $user;

		$user->add_lang_ext('ciakval/vipposts', 'common');

		if ($auth->acl_get('u_vip_view'))
		{
			$this->template->assign_var('VIP_BUTTON_ENABLED', true);
		}
	}

	public function dump_post($event)
	{
		var_dump($event['data']);
	}

}
