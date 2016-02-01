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

class release_0_1_1 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array(
			'\ciakval\vipposts\migrations\release_0_1_0'
		);
	}

	public function update_data()
	{
		return array(
			array('config_text.add', array('vipposts_text', 'text')),
		);
	}
}
