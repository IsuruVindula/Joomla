<?php
/**
 * @package         Cache Cleaner
 * @version         6.4.0
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2018 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use RegularLabs\Plugin\System\CacheCleaner\Plugin;

// Do not instantiate plugin on install pages
// to prevent installation/update breaking because of potential breaking changes
$input = \Joomla\CMS\Factory::getApplication()->input;
if ($input->get('action') != '' && in_array($input->get('option'), ['com_installer', 'com_regularlabsmanager']))
{
	return;
}

if ( ! is_file(__DIR__ . '/vendor/autoload.php'))
{
	return;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Plugin that cleans cache
 */
class PlgSystemCacheCleaner extends Plugin
{
	public $_alias       = 'cachecleaner';
	public $_title       = 'CACHE_CLEANER';
	public $_lang_prefix = 'CC';

	public $_page_types      = ['html', 'ajax', 'json', 'raw'];
	public $_enable_in_admin = true;

	/*
	 * Below are the events that this plugin uses
	 * All handling is passed along to the parent run method
	 */
	public function onAfterRoute()
	{
		$this->run();
	}

}
