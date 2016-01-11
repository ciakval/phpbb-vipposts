<?php

namespace ciakval\vipposts\acp;

class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\ciakval\vipposts\acp\main_module',
			'title'		=> 'ACP_VIPPOSTS_TITLE',
			'version'	=> '1.0.0.',
			'modes'		=> array(
				'settings' => array(
					'title'	=> 'ACP_VIPPOSTS',
					'auth'	=> 'ext_ciakval/vipposts && acl_a_board',
					'cat'	=> array('ACP_VIPPOSTS_TITLE'),
				),
			),
		);
	}
}
