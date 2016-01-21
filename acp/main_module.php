<?php
/**
 * This file is part of the VIP Posts extension package
 *
 * @copyright	(c) 2016, Honza Remes
 * @license		GNU General Public License, version 2 (GPL-2.0)
 *
 * @package		ciakval/vipposts/acp
 */

namespace ciakval\vipposts\acp;

/**
 * Module class for the extension's ACP page
 *
 * Support for more settings - check out lines designated with // @more
 */
class main_module
{
	/* @var string	Action -- this variable is required */
	public $u_action;
	/* @var string	Page title */
	public $page_title;
	/* @var string	Template file name */
	public $tpl_name;


	public function main($id, $mode)
	{
		global $request, $user, $config, $template;

		$this->tpl_name = 'acp_body';	// Set template name
		$this->page_title = $user->lang('ACP_VIPPOSTS_TITLE');	// Set page title

		add_form_key('ciakval/vipposts');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('ciakval/vipposts'))
			{
				$user->add_lang('acp/common');
				trigger_error('FORM_INVALID');
			}

			// Configuration for highlighting only, others may be added here
			$config->set('vipposts_highlight', $request->variable('vipposts_highlight', 0));
			$db->sql_query("UPDATE ". CONFIG_TEXT_TABLE ."
			SET config_value = \"".$request->variable('vipposts_text', '', true)."\"
			WHERE config_name = 'vipposts_text'");
			// @more	Save configuration values from the form

			trigger_error($user->lang('ACP_VIPPOSTS_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$query = $db->sql_query("SELECT config_value FROM ". CONFIG_TEXT_TABLE ."
WHERE config_name = 'vipposts_text'");
		$ris = $db->sql_fetchrow($query);
		$text = $ris['config_value'];
		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action,
			'S_HIGHLIGHT'	=> $config['vipposts_highlight'],
			'S_TEXT'	=> $text,
			// @more	Specify template variables corresponding to current settings
		));
	}
}


