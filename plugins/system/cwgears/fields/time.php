<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Gears
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL, see /assets/en-GB.license.txt
 * @copyright   Copyright (c) 2018 Steven Palmer All rights reserved.
 *
 * CoalaWeb Gears is free software: you can redistribute it and/or modify
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

// Add CSS and JS some are local to stop potential mix content errors
$gearsMedia = JURI::root() . 'media/coalaweb/plugins/system/gears/';
JHtml::stylesheet($gearsMedia . 'css/bootstrap-datetimepicker.min.css');
JHtml::script($gearsMedia . 'js/bootstrap-datetimepicker.min.js');

jimport('joomla.form.formfield');

/**
 * Class JFormFieldTime
 */
class JFormFieldTime extends JFormField {

    protected $type = 'Time';

    /**
     * @return string
     */
    public function getInput() {
        
        // Detect language
        $lang = JFactory::getLanguage();
        $locale = $lang->getTag();
        
        //Date time format
        $format = 'hh:mm';
        
        // Input field
        $output[] = '<div id="datetimepicker' . $this->id . '" class="input-append">';
        $output[] = '<input '
                . 'data-format="' . $format . '" '
                . 'name="' . $this->name . '" '
                . 'value="' . $this->value . '" '
                . 'type="text" '
                . 'placeholder="' . $this->hint . '">'
                . '</input>';
        $output[] = '<span class="add-on">';
        $output[] = '<i data-time-icon="icon-clock"></i>';
        $output[] = '</span>';
        $output[] = '</div>';

        //jQuery code
        $output[] = '<script type="text/javascript">';
        $output[] = 'jQuery(function() {';
        $output[] = '   jQuery("#datetimepicker' . $this->id . '").datetimepicker({';
        $output[] = '       language: "' . $locale . '",';
        $output[] = '       pick12HourFormat: false,';
        $output[] = '       pickDate: false,';
        $output[] = '       pickSeconds: false,';
        $output[] = '       format: "' . $format . '"';
        $output[] = '   });';
        $output[] = '});';
        $output[] = '</script>';

        return implode("\n", $output);
    }
}