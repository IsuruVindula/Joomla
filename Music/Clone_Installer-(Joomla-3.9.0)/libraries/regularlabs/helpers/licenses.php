<?php
/**
 * @package         Regular Labs Library
 * @version         18.10.16084
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2018 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

/* @DEPRECATED */

defined('_JEXEC') or die;

use RegularLabs\Library\License as RL_License;

if (is_file(JPATH_LIBRARIES . '/regularlabs/autoload.php'))
{
	require_once JPATH_LIBRARIES . '/regularlabs/autoload.php';
}

class RLLicenses
{
	public static function render($name, $check_pro = false)
	{
		return ! class_exists('RegularLabs\Library\License') ? '' : RL_License::getMessage($name, $check_pro);
	}
}
