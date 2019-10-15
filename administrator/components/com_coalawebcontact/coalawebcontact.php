<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Contact
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL, see /assets/en-GB.license.txt
 * @copyright   Copyright (c) 2018 Steven Palmer All rights reserved.
 *
 * CoalaWeb Contact is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/gpl.html>.
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
jimport( 'joomla.plugin.helper' );

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_coalawebcontact')) {
    throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Lets make sure CoalaWeb Gears is loaded
if (JPluginHelper::isEnabled('system', 'cwgears', true) == false) {
    $msg = JText::_('COM_CWCONTACT_NOGEARSPLUGIN_GENERAL_MESSAGE');
    JFactory::getApplication()->enqueueMessage($msg, 'error');
    return;
}

$jlang = JFactory::getLanguage();

$jlang->load('com_coalawebcontact', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_coalawebcontact', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_coalawebcontact', JPATH_ADMINISTRATOR, null, true);

// Load version.php
$version_php = JPATH_COMPONENT_ADMINISTRATOR . '/version.php';
if (!defined('COM_CWCONTACT_VERSION') && JFile::exists($version_php)) {
    require_once $version_php;
}

JLoader::register('CoalawebcontactHelper', dirname(__FILE__) . '/helpers/coalawebcontact.php');

$controller = JControllerLegacy::getInstance('Coalawebcontact');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
?>

<div class="cw-powerby-back">
    <span class="cw-powerby-back">
        <span class="icon-cogs"></span><?php echo JTEXT::_('COM_CWCONTACT_POWEREDBY_MSG'); ?>
        <a href="https://www.coalaweb.com" target="_blank" title="CoalaWeb">CoalaWeb</a> -
        <?php echo JTEXT::_('COM_CWCONTACT_FIELD_RELEASE_VERSION_LABEL');
        echo COM_CWCONTACT_PRO == 1 ? ' ' . COM_CWCONTACT_VERSION . ' ' . JTEXT::_('COM_CWCONTACT_RELEASE_TYPE_PRO') : ' ' . COM_CWCONTACT_VERSION . ' ' . JTEXT::_('COM_CWCONTACT_RELEASE_TYPE_CORE')?>
    </span>
</div>
