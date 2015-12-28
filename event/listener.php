<?php

namespace ciakval\vipposts\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.phpbb_content_visibility_get_visibility_sql_before'	=> 'limit_vip_posts',
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
}
