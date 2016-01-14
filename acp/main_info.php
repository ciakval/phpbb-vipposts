<?php

/**
 * This file is part of the VIP Posts extension package
 *
 * @copyright	(c) 2016, Honza Remes
 * @license		GNU General Public License, version 2 (GPL-2.0)
 *
 * @package 	ciakval/vipposts/acp
 */

namespace ciakval\vipposts\acp;

/**
 * Information class for the extension's ACP module
 */
class main_info
{
	/**
	 * Return array with module description
	 */
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
