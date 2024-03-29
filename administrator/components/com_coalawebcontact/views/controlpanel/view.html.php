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

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');

$latestVersion = JPATH_SITE . '/plugins/system/cwgears/helpers/latestversion.php';
if (JFile::exists($latestVersion) && !class_exists('CwGearsLatestversion')) {
    JLoader::register('CwGearsLatestversion', $latestVersion);
}

/**
 * View class for control panel
 */
class CoalawebcontactViewControlpanel extends JViewLegacy {

    /**
     * Display the view
     *
     * @param string $tpl The name of the template file to parse; automatically searches through the template paths.
     *
     * @return void
     * @throws Exception
     */
    function display($tpl = null) {

        $model = $this->getModel();

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }
        
        CoalawebcontactHelper::addSubmenu('controlpanel');

        // Is this the Pro release
        $isPro = (COM_CWCONTACT_PRO == 1);
        $this->isPro = $isPro;
        
        // The curent version and release date
        $version = (COM_CWCONTACT_VERSION);
        $this->version = $version;
        
        //Release date
        $releaseDate = (COM_CWCONTACT_DATE);
        $this->release_date = $releaseDate;
        
        //Need a download ID?
        $needsDlid = $model->needsDownloadID();
        $this->needsdlid = $needsDlid;
        
        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal') {
            $this->addToolbar();
        }

        // Lets check the current version against the latest
        $type = $isPro ? 'pro' : 'core';
        if (class_exists('CwGearsLatestversion')) {
            $this->current = CwGearsLatestversion::getCurrent('cw-contact-'. $type, $version );
        } else {
            $this->current = [
                'remote' => JText::_('COM_CWCONTACT_NO_FILE'),
                'update' => ''
            ];
        }

        parent::display($tpl);
    }
    
    /**
     * Add the page title and toolbar.
     *
     * @return void
     */
    protected function addToolbar() 
    {
        $canDo = JHelperContent::getActions('com_coalawebcontact');

        if (COM_CWCONTACT_PRO == 1) {
            JToolBarHelper::title(JText::_('COM_CWCONTACT_TITLE_PRO') . ' [ ' . JText::_('COM_CWCONTACT_TITLE_CPANEL') . ' ]', 'cogs');
        } else {
            JToolBarHelper::title(JText::_('COM_CWCONTACT_TITLE_CORE') . ' [ ' . JText::_('COM_CWCONTACT_TITLE_CPANEL') . ' ]', 'cogs');
        }
        
        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_coalawebcontact');
        }

        $help_url = 'https://coalaweb.com/support/documentation/item/coalaweb-contact-guide';
        JToolBarHelper::help('COM_CWCONTACT_TITLE_HELP', false, $help_url);

    }

}
