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

JHtml::_('jquery.framework');
$user = JFactory::getUser();
$lang = JFactory::getLanguage();

?>

<div id="cpanel-v2" class="span8 well">
    <div class="row-fluid">

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="blue-light" href="index.php?option=com_config&view=component&component=com_coalawebcontact">
                    <img alt="<?php echo JText::_('COM_CWCONTACT_TITLE_OPTIONS'); ?>"
                         src="<?php echo JURI::root() ?>/media/coalaweb/components/generic/images/icons/icon-48-cw-options-v2.png"/>
                    <span><?php echo JText::_('COM_CWCONTACT_TITLE_OPTIONS'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="red-light"
                   onclick="Joomla.popupWindow('https://coalaweb.com/support/documentation/item/coalaweb-contact-guide', 'Help', 700, 500, 1);"
                   href="#">
                    <img alt="<?php echo JText::_('COM_CWCONTACT_TITLE_HELP'); ?>"
                         src="<?php echo JURI::root() ?>/media/coalaweb/components/generic/images/icons/icon-48-cw-support-v2.png"/>
                    <span><?php echo JText::_('COM_CWCONTACT_TITLE_HELP'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="pink-light"
                   onclick="Joomla.popupWindow('https://coalaweb.com/extensions/joomla-extensions/coalaweb-contact/feature-comparison', 'Help', 700, 500, 1)"
                   href="#">
                    <img alt="<?php echo JText::_('COM_CWCONTACT_TITLE_UPGRADE'); ?>"
                         src="<?php echo JURI::root() ?>/media/coalaweb/components/generic/images/icons/icon-48-cw-upgrade-v2.png"/>
                    <span><?php echo JText::_('COM_CWCONTACT_TITLE_UPGRADE'); ?></span>
                </a>
            </div>
        </div>

    </div>
</div>

<div id="tabs" class="span4">
    <div class="row-fluid">

        <?php
        $options = array(
            'onActive' => 'function(title, description){
        description.setStyle("display", "block");
        title.addClass("open").removeClass("closed");
    }',
            'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',
            'startOffset' => 0, // 0 starts on the first tab, 1 starts the second, etc...
            'useCookie' => true, // this must not be a string. Don't use quotes.
            'startTransition' => 1,
        );
        ?>

        <?php echo JHtml::_('sliders.start', 'slider_group_id', $options); ?>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWCONTACT_SLIDER_TITLE_ABOUT'), 'slider_1_id'); ?>
        <div class="well well-large">
            <h1><?php echo JText::_('COM_CWCONTACT_TITLE_CORE'); ?></h1>
            <?php echo JText::_('COM_CWCONTACT_ABOUT_DESCRIPTION'); ?>

        </div>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWCONTACT_SLIDER_TITLE_SUPPORT'), 'slider_2_id'); ?>

        <div class="well well-large">
            <?php echo JText::_('COM_CWCONTACT_SUPPORT_DESCRIPTION'); ?>
        </div>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWCONTACT_SLIDER_TITLE_VERSION'), 'slider_3_id'); ?>

        <?php $type = ($this->isPro ? JText::_('COM_CWCONTACT_RELEASE_TYPE_PRO') : JText::_('COM_CWCONTACT_RELEASE_TYPE_CORE')); ?>

        <div class="well well-large">
            <h3> <?php echo JText::_('COM_CWCONTACT_RELEASE_TITLE'); ?> </h3>
            <ul class="">
                <li><strong><?php echo JText::_('COM_CWCONTACT_FIELD_RELEASE_TYPE_LABEL'); ?></strong> <span
                            class="badge badge-info"><?php echo $type; ?> </span></li>
                <li><strong><?php echo JText::_('COM_CWCONTACT_FIELD_RELEASE_VERSION_LABEL'); ?></strong> <span
                            class="badge badge-info"><?php echo $this->version ?> </span></li>
                <li><strong><?php echo JText::_('COM_CWCONTACT_FIELD_RELEASE_DATE_LABEL'); ?></strong> <span
                            class="badge badge-info"><?php echo $this->release_date; ?>  </span></li>
            </ul>
            <h3> <?php echo JText::_('COM_CWCONTACT_LATEST_RELEASE_TITLE'); ?> </h3>
            <ul class="">
                <li>
                    <strong><?php echo JText::_('COM_CWCONTACT_FIELD_RELEASE_VERSION_LABEL'); ?></strong> <span
                            class="badge badge-success"> <?php echo $this->current['remote']; ?></span> <?php echo $this->current['update']; ?>
                </li>
            </ul>
        </div>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWCONTACT_SLIDER_TITLE_UPGRADE'), 'slider_4_id'); ?>
        <div class="well well-large">
            <div class="alert alert-danger">
                <span class="icon-power-cord"></span> <?php echo JText::_('COM_CWCONTACT_MSG_UPGRADE'); ?>
            </div>
        </div>

        <?php echo JHtml::_('sliders.end'); ?>
    </div>
</div>

