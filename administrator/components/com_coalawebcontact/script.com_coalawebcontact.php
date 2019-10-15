<?php
defined('_JEXEC') or die('Restricted access');
/**
 * @package     Joomla
 * @subpackage  com_coalawebcontact
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL, see /assets/en-GB.license.txt
 * @copyright   Copyright (c) 2018 Steven Palmer All rights reserved.
 *
 * This extension is free software: you can redistribute it and/or modify
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
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.log.log');

class com_coalawebcontactInstallerScript
{
    /**
     * @var string The extension name
     */
    private $coalaweb_extension = 'com_coalawebcontact';

    /**
     * @var string Possible duplicate update info
     */
    private $update_remove = array(
        'http://cdn.coalaweb.com/updates/cw-contact-pro.xml',
    );

    /**
     * @var array The list of extra modules and plugins to install
     */
    private $installation_queue = array(
        'modules' => array(
            'admin' => array(
                
            ),
            'site' => array(
                'coalawebcontact' => array('left', 0)
            )
        ),
        'plugins' => array(
            'system' => array(
                'cwmailcheck' => 1, 'cwgears' => 1
            ),
            'content' => array(
                
            ),
            'editors-xtd' => array(
                
            )
        )
    );

    /**
     * @var array The list of extra modules and plugins to uninstall
     */
    private $uninstallation_queue = array(
        'modules' => array(
            'admin' => array(
                
            ),
            'site' => array(
                'coalawebcontact'
            )
        ),
        'plugins' => array(
            'system' => array(
                'cwmailcheck'
            ),
            'content' => array(
                
            ),
            'editors-xtd' => array(
                
            ),
            'installer' => array(
                
            ),
            'quickicon' => array(
                
            )
        )
    );

    /**
     * @var array The list of pro or obsolete plugins to remove
     */
    private $removeProObsoletePlugins = array(
        'plugins' => array(
            'system' => array(
                
            ),
            'content' => array(
                'cwcontact'
            ),
            'editors-xtd' => array(
                'cwbtncontact'
            )
        )
    );

    /**
     * @var array The list of pro or obsolete modules to remove
     */
    private $removeProObsoleteModules = array(
        'modules' => array(
            'admin' => array(
                
            ),
            'site' => array(
                'coalawebcontacttab'
            )
        )
    );

    /**
     * @var array Plugins that should activated automatically
     */
    private $activatePlugins = array(
        'plugins' => array(
            'system' => array(
                
            ),
            'content' => array(
                
            ),
            'editors-xtd' => array(
                
            )
        )
    );

    /**
     * Folders to be moved in format 'from' => 'to'
     * @var array
     */
    private $moveFolders = array(
        'folders' => array(
            
        )
    );

    /**
     * @var array New files and folders to add
     */
    private $addFiles = array(
        'files' => array(
            
        ),
        'folders' => array(
            
        )
    );

    /**
     * @var array Obsolete files and folders to remove
     */
    private $removeFiles = array(
        'files' => array(
            'administrator/components/com_coalawebcontact/controllers/customfield.php','administrator/components/com_coalawebcontact/controllers/customfields.php','administrator/components/com_coalawebcontact/models/customfield.php','administrator/components/com_coalawebcontact/models/customfields.php','administrator/components/com_coalawebcontact/controllers/emailtemplate.php','administrator/components/com_coalawebcontact/controllers/emailtemplates.php','administrator/components/com_coalawebcontact/models/emailtemplate.php','administrator/components/com_coalawebcontact/models/emailtemplates.php','administrator/components/com_coalawebcontact/models/forms/customfield.xml','administrator/components/com_coalawebcontact/models/forms/filter_customfields.xml','administrator/components/com_coalawebcontact/models/forms/emailtemplate.xml','administrator/components/com_coalawebcontact/models/forms/filter_emailtemplates.xml','administrator/components/com_coalawebcontact/models/fields/moduleselect.php','administrator/components/com_coalawebcontact/helpers/attachments.php','administrator/components/com_coalawebcontact/helpers/crypt.php','administrator/components/com_coalawebcontact/helpers/tracking.php','administrator/components/com_coalawebcontact/script.coalawebcontact.php','administrator/components/com_coalawebcontact/tables/customfields.php','administrator/components/com_coalawebcontact/tables/emailtemplates.php'
        ),
        'folders' => array(
            'media/coalawebcontact/components/contact/themes/dark','media/coalawebcontact/components/contact/themes/dark-blue','administrator/components/com_coalawebcontact/views/customfield','administrator/components/com_coalawebcontact/views/customfields','administrator/components/com_coalawebcontact/views/emailtemplate','administrator/components/com_coalawebcontact/views/emailtemplates','administrator/components/com_coalawebcontact/assets/captcha','administrator/components/com_coalawebcontact/assets/captcha-v2','administrator/components/com_coalawebcontact/assets/GMPTracking'
        )
    );

    /**
     * @var array CLI Scripts to install
     */
    private $cliScripts = array(
            
    );

    /**
     * Transfer the current parameter settings from one extension to another
     * Example 'old' => 'new'
     *
     * @var array old and new extension names for param transfer
     */
    private $copyParams = array(
        'extensions' => array(
            
        )
    );

    /**
     * List of old plugin names that don't include a type to fix language string display
     *
     * @var array of old plugin names
     */
    private $oldPluginNames = array(
            'cwgears','cwcontact','cwbtncontact','cwmailcheck'
    );

    /**
     * Joomla! pre-flight event
     *
     * @param string $type Installation type (install, update, discover_install)
     * @param JInstaller $parent
     * @return bool
     */
    public function preflight($type, $parent)
    {
        // Only allow to install on Joomla! 3.7 or later with PHP 5.4 or later
        if (defined('PHP_VERSION')) {
            $version = PHP_VERSION;
        } elseif (function_exists('phpversion')) {
            $version = phpversion();
        } else {
            $version = '5.0.0'; // all bets are off!
        }

        if (!version_compare(JVERSION, '3.7', 'ge')) {
            $msg = "<p>Sorry, you need Joomla! 3.7 or later to install this extension!</p>";

            JLog::add($msg, JLog::WARNING, 'jerror');

            return false;
        }

        if (!version_compare($version, '5.4', 'ge')) {
            $msg = "<p>Sorry, you need PHP 5.4 or later to install this extension!</p>";

            JLog::add($msg, JLog::WARNING, 'jerror');

            return false;
        }

        // Move folders if needed and it's an update
        if ($type == 'update') {
            $this->_moveFolders();
        }

        return true;
    }

    /**
     * Runs after install, update or discover_update
     *
     * @param string $type install, update or discover_update
     * @param JInstaller $parent
     */
    function postflight($type, $parent)
    {
        // Install subextensions
        $status = $this->_installSubextensions($parent);

        // Remove obsolete files and folders
        $this->_removeObsoleteFilesAndFolders($this->removeFiles);

        // Add new files and folders
        $this->_addNewFilesAndFolders($parent);

        // Copy any included CLI scripts into Joomla!'s cli directory
        $this->_copyCliFiles($parent);

        //Activate main plugin and copy params only on install
        if ($type == 'install') {
            $this->_activatePlugin($parent);
            $this->_copyParams($parent);
        }

        // Remove Pro or Obsolete extensions
        $this->_removeProObsoletePlugins($parent);
        $this->_removeProObsoleteModules($parent);

        // Remove duplicate update info
        $this->_removeUpdateSite();

        // Show the post-installation page
        $this->_renderPostInstallation($status, $parent, $type);
    }

    /**
     * Runs on uninstallation
     *
     * @param JInstaller $parent
     */
    function uninstall($parent)
    {
        // Uninstall subextensions
        $status = $this->_uninstallSubextensions($parent);

        // Show the post-uninstallation page
        $this->_renderPostUninstallation($status, $parent);
    }

    /**
     * Renders the post-installation message
     *
     * @param $status
     * @param JInstaller $parent
     * @param string $type
     */
    private function _renderPostInstallation($status, $parent, $type)
    {
        ?>

        <?php
            $rows = 1;
            $typeUpper = strtoupper ('core');
        ?>
        <style type="text/css">
            .coalaweb {
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                font-size: 13px !important;
                font-weight: 400 !important;
                color: #4D4D4D;
                border: solid #ccc 1px;
                background: #fff;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                *border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                margin-bottom: 15px !important
            }

            .coalaweb tr:hover {
                background: #E8F6FE;
                -o-transition: all .1s ease-in-out;
                -webkit-transition: all .1s ease-in-out;
                -moz-transition: all .1s ease-in-out;
                -ms-transition: all .1s ease-in-out;
                transition: all .1s ease-in-out
            }

            .coalaweb tr.row1 {
                background-color: #F0F0EE
            }

            .coalaweb td, .coalaweb th {
                border-left: 1px solid #ccc;
                border-top: 1px solid #ccc;
                padding: 10px !important;
                text-align: left
            }

            .coalaweb th {
                border-top: none;
                color: #333 !important;
                text-shadow: 0 1px 1px #FFF;
                border-bottom: 4px solid #1272a5 !important
            }

            .coalaweb td:first-child, .coalaweb th:first-child {
                border-left: none
            }

            .coalaweb th:first-child {
                -moz-border-radius: 3px 0 0;
                -webkit-border-radius: 3px 0 0 0;
                border-radius: 3px 0 0 0
            }

            .coalaweb th:last-child {
                -moz-border-radius: 0 3px 0 0;
                -webkit-border-radius: 0 3px 0 0;
                border-radius: 0 3px 0 0
            }

            .coalaweb th:only-child {
                -moz-border-radius: 6px 6px 0 0;
                -webkit-border-radius: 6px 6px 0 0;
                border-radius: 6px 6px 0 0
            }

            .coalaweb tr:last-child td:first-child {
                -moz-border-radius: 0 0 0 3px;
                -webkit-border-radius: 0 0 0 3px;
                border-radius: 0 0 0 3px
            }

            .coalaweb tr:last-child td:last-child {
                -moz-border-radius: 0 0 3px;
                -webkit-border-radius: 0 0 3px 0;
                border-radius: 0 0 3px 0
            }

            .coalaweb em, .coalaweb strong {
                color: #1272A5;
                font-weight: 700
            }
        </style>
        <link rel="stylesheet" href="../media/coalaweb/components/generic/css/com-coalaweb-base-v2.css" type="text/css">
        <div class="well well-lg">
            <h3><?php echo JText::_('COM_CWCONTACT_POST_INSTALL_TITLE'); ?></h3>
            <?php if ($type == 'update') : ?>
                
            <?php endif; ?>
            <div class="alert alert-danger">
                <span class="icon-notification"></span>
                <?php echo JText::_('COM_CWCONTACT_POST_INSTALL_MSG'); ?>
            </div>
            <h3><?php echo JText::_('COM_CWCONTACT_INSTALL_DETAILS_TITLE'); ?></h3>
            <table class="coalaweb">
                <thead align="left">
                <tr>
                    <th class="title" align="left">Main</th>
                    <th width="25%">Status</th>
                </tr>
                </thead>
                <tbody>
                <tr class="row0">
                    <td class="key">
                        <?php echo JText::_('COM_CWCONTACT_TITLE_' . $typeUpper . ''); ?>
                    </td>
                    <td>
                        <strong style="color: green">Installed</strong>
                    </td>
                </tr>
                </tbody>
            </table>

            <?php if (count($status->modules)) : ?>
                <table class="coalaweb">
                    <thead align="left">
                    <tr>
                        <th class="title" align="left">Modules</th>
                        <th width="25%">Client</th>
                        <th width="25%">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($status->modules as $module) : ?>
                        <tr class="row<?php echo($rows++ % 2); ?>">
                            <td class="key"><?php echo JText::_($module['name']); ?></td>
                            <td class="key"><?php echo ucfirst($module['client']); ?></td>
                            <td>
                                <strong style="color: <?php echo ($module['result']) ? "green" : "red" ?>"><?php echo ($module['result']) ? 'Installed' : 'Not installed'; ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (count($status->plugins)) : ?>
            <table class="coalaweb">
                <thead align="left">
                <tr>
                    <th class="title" align="left">Plugins</th>
                    <th width="25%">Group</th>
                    <th width="25%">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($status->plugins as $plugin) : ?>
                    <tr class="row<?php echo($rows++ % 2); ?>">
                        <td class="key"><?php echo JText::_($plugin['name']); ?></td>
                        <td class="key"><?php echo ucfirst($plugin['group']); ?></td>
                        <td>
                            <strong style="color: <?php echo ($plugin['result']) ? "green" : "red" ?>"><?php echo ($plugin['result']) ? 'Installed' : 'Not installed'; ?></strong>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Renders the post-uninstallation message
     *
     * @param $status
     * @param JInstaller $parent
     */
    private function _renderPostUninstallation($status, $parent)
    {
        ?>
        <?php
            $rows = 0;
            $typeUpper = strtoupper ('core');
        ?>
        <style type="text/css">
            .coalaweb {
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                font-size: 13px !important;
                font-weight: 400 !important;
                color: #4D4D4D;
                border: solid #ccc 1px;
                background: #fff;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                *border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                margin-bottom: 15px !important
            }

            .coalaweb tr:hover {
                background: #E8F6FE;
                -o-transition: all .1s ease-in-out;
                -webkit-transition: all .1s ease-in-out;
                -moz-transition: all .1s ease-in-out;
                -ms-transition: all .1s ease-in-out;
                transition: all .1s ease-in-out
            }

            .coalaweb tr.row1 {
                background-color: #F0F0EE
            }

            .coalaweb td, .coalaweb th {
                border-left: 1px solid #ccc;
                border-top: 1px solid #ccc;
                padding: 10px !important;
                text-align: left
            }

            .coalaweb th {
                border-top: none;
                color: #333 !important;
                text-shadow: 0 1px 1px #FFF;
                border-bottom: 4px solid #1272a5 !important
            }

            .coalaweb td:first-child, .coalaweb th:first-child {
                border-left: none
            }

            .coalaweb th:first-child {
                -moz-border-radius: 3px 0 0;
                -webkit-border-radius: 3px 0 0 0;
                border-radius: 3px 0 0 0
            }

            .coalaweb th:last-child {
                -moz-border-radius: 0 3px 0 0;
                -webkit-border-radius: 0 3px 0 0;
                border-radius: 0 3px 0 0
            }

            .coalaweb th:only-child {
                -moz-border-radius: 6px 6px 0 0;
                -webkit-border-radius: 6px 6px 0 0;
                border-radius: 6px 6px 0 0
            }

            .coalaweb tr:last-child td:first-child {
                -moz-border-radius: 0 0 0 3px;
                -webkit-border-radius: 0 0 0 3px;
                border-radius: 0 0 0 3px
            }

            .coalaweb tr:last-child td:last-child {
                -moz-border-radius: 0 0 3px;
                -webkit-border-radius: 0 0 3px 0;
                border-radius: 0 0 3px 0
            }

            .coalaweb em, .coalaweb strong {
                color: #1272A5;
                font-weight: 700
            }
        </style>
        <div class="well well-lg">
            <h3><?php echo JText::_('COM_CWCONTACT_TITLE_' . $typeUpper . '') . ' - ' .JText::_('COM_CWCONTACT_UNINSTALL_STATUS_MSG') ?></h3>

            <table class="coalaweb">
                <thead align="left">
                <tr>
                    <th class="title" align="left">Main</th>
                    <th width="25%">Status</th>
                </tr>
                </thead>
                <tbody>
                <tr class="row0">
                    <td class="key">
                        <?php echo JText::_('COM_CWCONTACT_TITLE_' . $typeUpper . ''); ?>
                    </td>
                    <td>
                        <strong style="color: green">Uninstalled</strong>
                    </td>
                </tr>
                </tbody>
            </table>

            <?php if (count($status->modules)) : ?>
                <table class="coalaweb">
                    <thead align="left">
                    <tr>
                        <th class="title" align="left">Modules</th>
                        <th width="25%">Client</th>
                        <th width="25%">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($status->modules as $module) : ?>
                        <tr class="row<?php echo($rows++ % 2); ?>">
                            <td class="key"><?php echo JText::_($module['name']); ?></td>
                            <td class="key"><?php echo ucfirst($module['client']); ?></td>
                            <td>
                                <strong style="color: <?php echo ($module['result']) ? "green" : "red" ?>"><?php echo ($module['result']) ? 'Uninstalled' : 'Not uninstalled'; ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (count($status->plugins)) : ?>
            <table class="coalaweb">
                <thead align="left">
                <tr>
                    <th class="title" align="left">Plugins</th>
                    <th width="25%">Group</th>
                    <th width="25%">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($status->plugins as $plugin) : ?>
                    <tr class="row<?php echo($rows++ % 2); ?>">
                        <td class="key"><?php echo JText::_($plugin['name']); ?></td>
                        <td class="key"><?php echo ucfirst($plugin['group']); ?></td>
                        <td>
                            <strong style="color: <?php echo ($plugin['result']) ? "green" : "red" ?>"><?php echo ($plugin['result']) ? 'Uninstalled' : 'Not uninstalled'; ?></strong>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Removes Pro or Obsolete plugins
     *
     * @param JInstaller $parent
     */
    private function _removeProObsoletePlugins($parent)
    {
        $db = JFactory::getDbo();

        if (count($this->removeProObsoletePlugins['plugins'])) {
            foreach ($this->removeProObsoletePlugins['plugins'] as $folder => $plugins) {
                foreach ($plugins as $plugin) {

                    // Find the plugin ID
                    $query = $db->getQuery(true);

                    $query
                        ->select($db->qn('extension_id'))
                        ->from($db->qn('#__extensions'))
                        ->where($db->qn('type') . ' = ' . $db->q('plugin'))
                        ->where($db->qn('element') . ' = ' . $db->q($plugin))
                        ->where($db->qn('folder') . ' = ' . $db->q($folder));

                    $db->setQuery($query);
                    $id = $db->loadResult();

                    if ($id) {
                        $installer = new JInstaller;
                        $result = $installer->uninstall('plugin', $id, 1);
                    }
                }
            }
        }
    }

    /**
     * Removes Pro or Obsolete modules
     *
     * @param JInstaller $parent
     */
    private function _removeProObsoleteModules($parent)
    {
        $src = $parent->getParent()->getPath('source');
        $db = JFactory::getDbo();

        if (count($this->removeProObsoleteModules['modules'])) {
            foreach ($this->removeProObsoleteModules['modules'] as $folder => $modules) {
                foreach ($modules as $module) {

                    if (empty($folder)) {
                        $folder = 'site';
                    }

                    // Find the module ID
                    $query = $db->getQuery(true);

                    $query
                        ->select($db->qn('extension_id'))
                        ->from($db->qn('#__extensions'))
                        ->where($db->qn('element') . ' = ' . $db->q('mod_' . $module))
                        ->where($db->qn('type') . ' = ' . $db->q('module'));

                    $db->setQuery($query);
                    $id = $db->loadResult();

                    // Uninstall the module
                    if ($id) {
                        $installer = new JInstaller;
                        $result = $installer->uninstall('module', $id, 1);
                    }
                }
            }
        }
    }

    /**
     * Copies any CLI scripts into Joomla!'s cli directory
     *
     * @param JInstaller $parent
     */
    private function _copyCliFiles($parent)
    {
        if (!count($this->cliScripts)) {
            return;
        }
        $src = $parent->getParent()->getPath('source');

        jimport("joomla.filesystem.file");
        jimport("joomla.filesystem.folder");

        foreach ($this->cliScripts as $script) {
            if (JFile::exists(JPATH_ROOT . '/cli/' . $script)) {
                JFile::delete(JPATH_ROOT . '/cli/' . $script);
            }
            if (JFile::exists($src . '/cli/' . $script)) {
                JFile::move($src . '/cli/' . $script, JPATH_ROOT . '/cli/' . $script);
            }
        }
    }

    /**
     * Installs subextensions (modules, plugins) bundled with the main extension
     *
     * @param  JInstaller $parent
     * @return JObject The subextension installation status
     */
    private function _installSubextensions($parent)
    {
        $src = $parent->getParent()->getPath('source');

        $db = JFactory::getDbo();

        $status = new JObject();
        $status->modules = array();
        $status->plugins = array();

        // Modules installation
        if (count($this->installation_queue['modules'])) {
            foreach ($this->installation_queue['modules'] as $folder => $modules) {
                if (count($modules)) {
                    foreach ($modules as $module => $modulePreferences) {
                        // Install the module
                        if (empty($folder)) {
                            $folder = 'site';
                        }

                        $path = "$src/modules/$folder/$module";

                        if (!is_dir($path)) {
                            $path = "$src/modules/$folder/mod_$module";
                        }

                        if (!is_dir($path)) {
                            $path = "$src/modules/$module";
                        }

                        if (!is_dir($path)) {
                            $path = "$src/modules/mod_$module";
                        }

                        if (!is_dir($path)) {
                            continue;
                        }

                        // Was the module already installed?
                        $query = $db->getQuery(true);
                        $query
                            ->select('COUNT(*)')
                            ->from('#__modules')
                            ->where($db->qn('module') . ' = ' . $db->q('mod_' . $module));

                        $db->setQuery($query);

                        try {
                            $count = $db->loadResult();
                        } catch (Exception $exc) {
                            $count = 0;
                        }

                        $installer = new JInstaller;
                        $result = $installer->install($path);
                        $status->modules[] = array(
                            'name' => 'mod_' . $module,
                            'client' => $folder,
                            'result' => $result
                        );

                        // Modify where it's published and its published state
                        if (!$count) {
                            // A. Position and state
                            list($modulePosition, $modulePublished) = $modulePreferences;

                            if ($modulePosition == 'cpanel') {
                                $modulePosition = 'icon';
                            }

                            $query = $db->getQuery(true);
                            $query
                                ->update($db->qn('#__modules'))
                                ->set($db->qn('position') . ' = ' . $db->q($modulePosition))
                                ->where($db->qn('module') . ' = ' . $db->q('mod_' . $module));

                            if ($modulePublished) {
                                $query->set($db->qn('published') . ' = ' . $db->q('1'));
                            }

                            $db->setQuery($query);

                            try {
                                $db->execute();
                            } catch (Exception $exc) {
                                // Nothing
                            }

                            // B. Change the ordering of back-end modules to 1 + max ordering
                            if ($folder == 'admin') {
                                try {
                                    $query = $db->getQuery(true);
                                    $query
                                        ->select('MAX(' . $db->qn('ordering') . ')')
                                        ->from($db->qn('#__modules'))
                                        ->where($db->qn('position') . '=' . $db->q($modulePosition));

                                    $db->setQuery($query);
                                    $position = $db->loadResult();

                                    $position++;

                                    $query = $db->getQuery(true);
                                    $query
                                        ->update($db->qn('#__modules'))
                                        ->set($db->qn('ordering') . ' = ' . $db->q($position))
                                        ->where($db->qn('module') . ' = ' . $db->q('mod_' . $module));

                                    $db->setQuery($query);
                                    $db->execute();
                                } catch (Exception $exc) {
                                    // Nothing
                                }
                            }

                            // C. Link to all pages
                            try {
                                $query = $db->getQuery(true);
                                $query
                                    ->select('id')->from($db->qn('#__modules'))
                                    ->where($db->qn('module') . ' = ' . $db->q('mod_' . $module));

                                $db->setQuery($query);
                                $moduleid = $db->loadResult();

                                $query = $db->getQuery(true);
                                $query
                                    ->select('*')->from($db->qn('#__modules_menu'))
                                    ->where($db->qn('moduleid') . ' = ' . $db->q($moduleid));

                                $db->setQuery($query);
                                $assignments = $db->loadObjectList();

                                $isAssigned = !empty($assignments);
                                if (!$isAssigned) {
                                    $o = (object)array(
                                        'moduleid' => $moduleid,
                                        'menuid' => 0
                                    );
                                    $db->insertObject('#__modules_menu', $o);
                                }
                            } catch (Exception $exc) {
                                // Nothing
                            }
                        }
                    }
                }
            }
        }

        // Plugins installation
        if (count($this->installation_queue['plugins'])) {
            foreach ($this->installation_queue['plugins'] as $folder => $plugins) {
                if (count($plugins)) {
                    foreach ($plugins as $plugin => $published) {
                        $path = "$src/plugins/$folder/$plugin";

                        if (!is_dir($path)) {
                            $path = "$src/plugins/$folder/plg_$plugin";
                        }

                        if (!is_dir($path)) {
                            $path = "$src/plugins/$plugin";
                        }

                        if (!is_dir($path)) {
                            $path = "$src/plugins/plg_$plugin";
                        }

                        if (!is_dir($path)) {
                            continue;
                        }

                        // Was the plugin already installed?
                        $query = $db->getQuery(true)
                            ->select('COUNT(*)')
                            ->from($db->qn('#__extensions'))
                            ->where($db->qn('element') . ' = ' . $db->q($plugin))
                            ->where($db->qn('folder') . ' = ' . $db->q($folder));
                        $db->setQuery($query);

                        try {
                            $count = $db->loadResult();
                        } catch (Exception $exc) {
                            $count = 0;
                        }

                        $installer = new JInstaller;
                        $result = $installer->install($path);

                        // Fix the display names for new inclusion of type style
                        if (in_array($plugin, $this->oldPluginNames)) {
                            $status->plugins[] = array('name' => 'plg_' . $plugin, 'group' => $folder, 'result' => $result);
                        } else {
                            $status->plugins[] = array('name' => 'plg_' . $folder . '_' . $plugin, 'group' => $folder, 'result' => $result);
                        }

                        if ($published && !$count) {
                            $query = $db->getQuery(true)
                                ->update($db->qn('#__extensions'))
                                ->set($db->qn('enabled') . ' = ' . $db->q('1'))
                                ->where($db->qn('element') . ' = ' . $db->q($plugin))
                                ->where($db->qn('folder') . ' = ' . $db->q($folder));
                            $db->setQuery($query);

                            try {
                                $db->execute();
                            } catch (Exception $exc) {
                                // Nothing
                            }
                        }
                    }
                }
            }
        }

        return $status;
    }

    /**
     * Uninstalls subextensions (modules, plugins) bundled with the main extension
     *
     * @param  JInstaller $parent
     * @return JObject The subextension uninstallation status
     */
    private function _uninstallSubextensions($parent)
    {
        jimport('joomla.installer.installer');

        $db = JFactory::getDBO();

        $status = new JObject();
        $status->modules = array();
        $status->plugins = array();

        // Modules uninstallation
        if (count($this->uninstallation_queue['modules'])) {
            foreach ($this->uninstallation_queue['modules'] as $folder => $modules) {
                if (count($modules)) {
                    foreach ($modules as $module) {
                        if (empty($folder)) {
                            $folder = 'site';
                        }
                        // Find the module ID
                        $query = $db->getQuery(true);
                        $query
                            ->select($db->qn('extension_id'))
                            ->from($db->qn('#__extensions'))
                            ->where($db->qn('element') . ' = ' . $db->q('mod_' . $module))
                            ->where($db->qn('type') . ' = ' . $db->q('module'));

                        $db->setQuery($query);
                        $id = $db->loadResult();

                        // Uninstall the module
                        if ($id) {
                            $installer = new JInstaller;
                            $result = $installer->uninstall('module', $id, 1);
                            $status->modules[] = array(
                                'name' => 'mod_' . $module,
                                'client' => $folder,
                                'result' => $result
                            );
                        }
                    }
                }
            }
        }

        // Plugins uninstallation
        if (count($this->uninstallation_queue['plugins'])) {
            foreach ($this->uninstallation_queue['plugins'] as $folder => $plugins) {
                if (count($plugins)) {
                    foreach ($plugins as $plugin) {
                        $query = $db->getQuery(true);
                        $query
                            ->select($db->qn('extension_id'))
                            ->from($db->qn('#__extensions'))
                            ->where($db->qn('type') . ' = ' . $db->q('plugin'))
                            ->where($db->qn('element') . ' = ' . $db->q($plugin))
                            ->where($db->qn('folder') . ' = ' . $db->q($folder));

                        $db->setQuery($query);
                        $id = $db->loadResult();

                        if ($id) {
                            $installer = new JInstaller;
                            $result = $installer->uninstall('plugin', $id, 1);

                            // Fix the display names for new inclusion of type style
                            if (in_array($plugin, $this->oldPluginNames)) {
                                $status->plugins[] = array(
                                    'name' => 'plg_' . $plugin,
                                    'group' => $folder,
                                    'result' => $result
                                );
                            } else {
                                $status->plugins[] = array(
                                    'name' => 'plg_' . $folder . '_' . $plugin,
                                    'group' => $folder,
                                    'result' => $result
                                );
                            }
                        }
                    }
                }
            }
        }

        return $status;
    }

    /**
     * Removes obsolete files and folders before install
     *
     * @param array $removeFiles
     */
    private function _removeObsoleteFilesAndFolders($removeFiles)
    {
        // Remove files
        jimport('joomla.filesystem.file');
        if (!empty($removeFiles['files'])) {
            foreach ($removeFiles['files'] as $file) {
                $f = JPATH_ROOT . '/' . $file;
                if (!JFile::exists($f)) {
                    continue;
                }
                JFile::delete($f);
            }
        }
        // Remove folders
        jimport('joomla.filesystem.folder');
        if (!empty($removeFiles['folders'])) {
            foreach ($removeFiles['folders'] as $folder) {
                $f = JPATH_ROOT . '/' . $folder;
                if (!JFolder::exists($f)) {
                    continue;
                }
                JFolder::delete($f);
            }
        }
    }

    /**
     * Add new files and folders
     *
     * @param $parent
     */
    private function _addNewFilesAndFolders($parent)
    {
        $src = $parent->getParent()->getPath('source');

        // Add files
        jimport('joomla.filesystem.file');
        if (!empty($this->addFiles['files'])) {
            foreach ($this->addFiles['files'] as $file) {
                if (JFile::exists(JPATH_ROOT . '/' . $file)) {
                    JFile::delete(JPATH_ROOT . '/' . $file);
                }
                if (JFile::exists($src . '/' . $file)) {
                    JFile::move($src . '/' . $file, JPATH_ROOT . '/' . $file);
                }
            }
        }
        // Add folders
        jimport('joomla.filesystem.folder');
        if (!empty($this->addFiles['folders'])) {
            foreach ($this->addFiles['folders'] as $folder) {
                $f = $src . '/' . $folder;
                if (JFolder::exists($f)) {
                    continue;
                }
                JFolder::create($f);
            }
        }
    }

    /**
     * move existing folders
     * @return null
     */
    private function _moveFolders()
    {
        // Move folders
        jimport('joomla.filesystem.folder');
        if (count($this->moveFolders['folders'])) {
            foreach ($this->moveFolders['folders'] as $from => $to) {
                if (JFolder::exists(JPATH_ROOT . '/' . $to)) {
                    continue;
                }
                if (JFolder::exists(JPATH_ROOT . '/' . $from)) {
                    try {
                        JFolder::move(JPATH_ROOT . '/' . $from, JPATH_ROOT . '/' . $to);
                    } catch (Exception $e) {
                        // Nothing
                        continue;
                    }
                }
            }
        } else {
            return null;
        }
    }

    /**
     * Remove any conflicting update sites
     */
    private function _removeUpdateSite()
    {
        //Do we have anything to remove?
        if (!count($this->update_remove)) {
            return;
        }

        // We only need the last part of the name(element) for plugins
        $extRoot = explode('_', $this->coalaweb_extension);
        if ($extRoot !== null && array_key_exists(2,$extRoot)) {
            $element = $extRoot[2];
        } else {
            $element = $this->coalaweb_extension;

        }

        // Work out what type of extension we are dealing with
        switch ('com') {
            case 'com':
                $extType = 'component';
                break;
            case 'mod':
                $extType = 'module';
                break;
            case 'plg':
                $extType = 'plugin';
                break;
            default:
                $extType = 'component';
                break;
        }

        $db = JFactory::getDbo();

        foreach ($this->update_remove as $url) {

            // Get some info on all the stuff we've gotta delete
            $query = $db->getQuery(true);

            $query
                ->select(array(
                    $db->qn('s') . '.' . $db->qn('update_site_id'),
                    $db->qn('e') . '.' . $db->qn('extension_id'),
                    $db->qn('e') . '.' . $db->qn('element'),
                    $db->qn('s') . '.' . $db->qn('location'),
                ))
                ->from($db->qn('#__update_sites') . ' AS ' . $db->qn('s'))
                ->join('INNER', $db->qn('#__update_sites_extensions') . ' AS ' . $db->qn('se') . ' ON(' .
                    $db->qn('se') . '.' . $db->qn('update_site_id') . ' = ' .
                    $db->qn('s') . '.' . $db->qn('update_site_id')
                    . ')')
                ->join('INNER', $db->qn('#__extensions') . ' AS ' . $db->qn('e') . ' ON(' .
                    $db->qn('e') . '.' . $db->qn('extension_id') . ' = ' .
                    $db->qn('se') . '.' . $db->qn('extension_id')
                    . ')')
                ->where($db->qn('s') . '.' . $db->qn('type') . ' = ' . $db->q('extension'))
                ->where($db->qn('e') . '.' . $db->qn('type') . ' = ' . $db->q($extType))
                ->where($db->qn('e') . '.' . $db->qn('element') . ' = ' . $db->q($element))
                ->where($db->qn('s') . '.' . $db->qn('location') . ' = ' . $db->q($url));

            $db->setQuery($query);

            $oResult = $db->loadObject();

            // If no record is found, do nothing. We've already killed the monster!
            if (is_null($oResult)) {
                continue;
            }

            // Delete the #__update_sites record
            $query = $db->getQuery(true);

            $query
                ->delete($db->qn('#__update_sites'))
                ->where($db->qn('update_site_id') . ' = ' . $db->q($oResult->update_site_id));

            $db->setQuery($query);

            try {
                $db->execute();
            } catch (Exception $exc) {
                // If the query fails, don't sweat about it
            }

            // Delete the #__update_sites_extensions record
            $query = $db->getQuery(true);
            $query
                ->delete($db->qn('#__update_sites_extensions'))
                ->where($db->qn('update_site_id') . ' = ' . $db->q($oResult->update_site_id));

            $db->setQuery($query);

            try {
                $db->execute();
            } catch (Exception $exc) {
                // If the query fails, don't sweat about it
            }

            // Delete the #__updates records
            $query = $db->getQuery(true);

            $query
                ->delete($db->qn('#__updates'))
                ->where($db->qn('update_site_id') . ' = ' . $db->q($oResult->update_site_id));

            $db->setQuery($query);

            try {
                $db->execute();
            } catch (Exception $exc) {
                // If the query fails, don't sweat about it
            }
        }
    }

    /**
     * Activate if main extension is a plugin on install
     *
     * @param JInstaller $parent
     */
    private function _activatePlugin($parent) {
        $db = JFactory::getDbo();

        if (count($this->activatePlugins['plugins'])) {
            foreach ($this->activatePlugins['plugins'] as $folder => $plugins) {
                if (count($plugins)) {
                    foreach ($plugins as $plugin => $published) {

                        if ($published) {
                            $query = $db->getQuery(true)
                                ->update($db->qn('#__extensions'))
                                ->set($db->qn('enabled') . ' = ' . $db->q('1'))
                                ->where($db->qn('element') . ' = ' . $db->q($plugin))
                                ->where($db->qn('folder') . ' = ' . $db->q($folder));
                            $db->setQuery($query);

                            try {
                                $db->execute();
                            } catch (Exception $e) {
                                // Nothing
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Copy params from old extension to newly named extension
     *
     */
    private function _copyParams()
    {
        $db = JFactory::getDbo();

        if (count($this->copyParams['extensions'])) {
            foreach ($this->copyParams['extensions'] as $extensions) {
                if (count($extensions)) {
                    foreach ($extensions as $old => $new) {
                        $query = $db->getQuery(true);
                        $query
                            ->select(array('params'))
                            ->from($db->quoteName('#__extensions'))
                            ->where($db->quoteName('element') . ' = ' . $db->q($old));

                        $db->setQuery($query);

                        $result = $db->loadRow();

                        if ($result) {

                            $query = $db->getQuery(true)
                                ->update($db->qn('#__extensions'))
                                ->set($db->qn('params') . ' = ' . $db->q($result[0]))
                                ->where($db->qn('element') . ' = ' . $db->q($new));

                            $db->setQuery($query);

                            try {
                                $db->execute();
                            } catch (Exception $exc) {
                                // Nothing
                            }
                        }
                    }
                }
            }
        }
    }
}
