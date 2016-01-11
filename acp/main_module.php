<?php

namespace ciakval\vipposts\acp;

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

		$this->tpl_name = 'acp_body';
		$this->page_title = $user->lang('ACP_VIPPOSTS_TITLE');

		add_form_key('ciakval/vipposts');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('ciakval/vipposts'))
			{
				$user->add_lang('acp/common');
				trigger_error('FORM_INVALID');
			}

			// Configuration for highlighting only, others may be added here
			$config->set('vipposts_highlight', $request->variable('vipposts_highlight', false));

			trigger_error($user->lang('ACP_VIPPOSTS_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action,
			'S_HIGHLIGHT'	=> $config['vipposts_highlight'],
		));
	}
}



