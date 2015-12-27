<?php

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

}
