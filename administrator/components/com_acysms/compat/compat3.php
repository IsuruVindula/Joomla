<?php
/**
 * @package	AcySMS for Joomla!
 * @version	3.5.1
 * @author	acyba.com
 * @copyright	(C) 2009-2018 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php

class acysmsView extends JViewLegacy{

	var $chosen = true;

	function display($tpl = null){
		$app = JFactory::getApplication();
		if($this->chosen && $app->isAdmin()){
			JHtml::_('formbehavior.chosen', 'select');
		}

		return parent::display($tpl);
	}
}

class acysmsControllerCompat extends JControllerLegacy{

}

function acysms_loadResultArray(&$db){
	return $db->loadColumn();
}

function acysms_loadMootools($loadMootoolsMoreLib = false){
	JHTML::_('behavior.framework', $loadMootoolsMoreLib);
}

function acysms_getColumns($table){
	$db = JFactory::getDBO();
	return $db->getTableColumns($table);
}

function acysms_getEscaped($value, $extra = false){
	$db = JFactory::getDBO();
	return $db->escape($value, $extra);
}

function acysms_getFormToken(){
	return JSession::getFormToken();
}

class acysmsParameter extends JRegistry{

	function get($path, $default = null){
		$value = parent::get($path, 'noval');
		if($value === 'noval') $value = parent::get('data.'.$path, $default);
		return $value;
	}
}
