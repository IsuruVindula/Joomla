<?php
/**
 * @package         NoNumber Framework
 * @version         18.10.16084
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2018 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Form\FormField as JFormField;
use Joomla\CMS\HTML\HTMLHelper as JHtml;

require_once dirname(__DIR__) . '/helpers/functions.php';

/**
 * To use this, make a start xml param tag with the param and value set
 * And an end xml param tag without the param and value set
 * Everything between those tags will be included in the slide
 *
 * Available extra parameters:
 * param            The name of the reference parameter
 * value            a comma separated list of value on which to show the framework
 */
class JFormFieldNN_Toggler extends JFormField
{
	public $type = 'Toggler';

	protected function getLabel()
	{
		return '';
	}

	protected function getInput()
	{
		$field = new NNFieldToggler;

		return $field->getInput($this->element->attributes());
	}
}

class NNFieldToggler
{
	function getInput($params)
	{
		$this->params = $params;

		$option = JFactory::getApplication()->input->get('option');

		// do not place toggler stuff on JoomFish pages
		if ($option == 'com_joomfish')
		{
			return '';
		}

		$param  = $this->get('param');
		$value  = $this->get('value');
		$nofx   = $this->get('nofx');
		$method = $this->get('method');
		$div    = $this->get('div', 0);

		JHtml::_('jquery.framework');
		NNFrameworkFunctions::script('nnframework/script.min.js', '16.4.5735');
		NNFrameworkFunctions::script('nnframework/toggler.min.js', '16.4.5735');

		$param = preg_replace('#^\s*(.*?)\s*$#', '\1', $param);
		$param = preg_replace('#\s*\|\s*#', '|', $param);

		$html = [];
		if ($param != '')
		{
			$param      = preg_replace('#[^a-z0-9-\.\|\@]#', '_', $param);
			$param      = str_replace('@', '_', $param);
			$set_groups = explode('|', $param);
			$set_values = explode('|', $value);
			$ids        = [];
			foreach ($set_groups as $i => $group)
			{
				$count = $i;
				if ($count >= count($set_values))
				{
					$count = 0;
				}
				$value = explode(',', $set_values[$count]);
				foreach ($value as $val)
				{
					$ids[] = $group . '.' . $val;
				}
			}

			if ( ! $div)
			{
				$html[] = '</div></div>';
			}

			$html[] = '<div id="' . rand(1000000, 9999999) . '___' . implode('___', $ids) . '" class="nntoggler';
			if ($nofx)
			{
				$html[] = ' nntoggler_nofx';
			}
			if ($method == 'and')
			{
				$html[] = ' nntoggler_and';
			}
			$html[] = '">';

			if ( ! $div)
			{
				$html[] = '<div><div>';
			}
		}
		else
		{
			$html[] = '</div>';
		}

		return implode('', $html);
	}

	private function get($val, $default = '')
	{
		if ( ! isset($this->params[$val]) || (string) $this->params[$val] == '')
		{
			return $default;
		}

		return (string) $this->params[$val];
	}
}
