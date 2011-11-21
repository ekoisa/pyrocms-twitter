<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Plugin_Twitter extends Plugin
{
	/**
	 * Twitter connect button
	 * 
	 * insert button image of twitter connect button
	 * 
	 * {pyro:twitter:connect_button width="" height=""}
	 *
	 * @param	int
	 * @param	int
	 * @return	string
	 */
	function connect_button()
	{
		$width	= $this->attribute('width', '');
		$height	= $this->attribute('height', '');
		
		return "<a href='".site_url(twitter/login)."'>Twitter Connect</a>";
	}
}