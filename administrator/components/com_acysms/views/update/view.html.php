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

class UpdateViewUpdate extends acysmsView{

    function display($tpl = null){

        $function = $this->getLayout();
        if(method_exists($this, $function)) $this->$function();
        parent::display($tpl);
    }

    function acymailing(){
        $acyToolbar = acysms::get('helper.toolbar');
        $acyToolbar->setTitle('AcyMailing');
        $acyToolbar->display();

        $js = '
        function installAcyMailing(){
            var progressbar = document.getElementById("progressbar");
            var information = document.getElementById("information");
            progressbar.style.width = "10%";
            information.innerHTML = "'.htmlspecialchars(JText::_('SMS_DOWNLOADING'), ENT_QUOTES, 'UTF-8').'";

            try {
                var ajaxCall = new Ajax("index.php?option=com_acysms&tmpl=component&ctrl=file&task=downloadAcyMailing", {
                    method: "get",
                    onComplete: function (responseText, responseXML) {
                        if(responseText == "success") {
                            progressbar.style.width = "40%";
                            document.getElementById("information").innerHTML = "'.htmlspecialchars(JText::_('SMS_INSTALLING'), ENT_QUOTES, 'UTF-8').'";
                            installPackage();
                        }else{
                            document.getElementById("information").innerHTML = "'.str_replace('"', '\"', JText::sprintf('SMS_FAILED_INSTALL', '<a href="https://www.acyba.com/download-area/download/component-acymailing/level-starter.html">', '</a>')).'";
                        }
                    }
                }).request();
            } catch (err) {
                new Request({
                    url: "index.php?option=com_acysms&tmpl=component&ctrl=file&task=downloadAcyMailing",
                    method: "get",
                    onSuccess: function (responseText, responseXML) {
                        if(responseText == "success") {
                            progressbar.style.width = "40%";
                            document.getElementById("information").innerHTML = "'.htmlspecialchars(JText::_('SMS_INSTALLING'), ENT_QUOTES, 'UTF-8').'";
                            installPackage();
                        }else{
                            document.getElementById("information").innerHTML = "'.str_replace('"', '\"', JText::sprintf('SMS_FAILED_INSTALL', '<a href="https://www.acyba.com/download-area/download/component-acymailing/level-starter.html">', '</a>')).'";
                        }
                    }
                }).send();
            }
        }

        function installPackage(){
            try{
                var ajaxCall = new Ajax("index.php?option=com_acysms&tmpl=component&ctrl=file&task=installPackage",{
                    method: "get",
                    onComplete: function(responseText, responseXML) {
                        if(responseText == "success") {
                            progressbar.style.width = "60%";
                            document.getElementById("information").innerHTML = "'.htmlspecialchars(JText::_('SMS_INSTALLING_PLUGINS'), ENT_QUOTES, 'UTF-8').'"; 
                            installExtensions(); 
                        }else{
                            document.getElementById("information").innerHTML = responseText;//"'.str_replace('"', '\"', JText::sprintf('SMS_FAILED_INSTALL', '<a href="https://www.acyba.com/download-area/download/component-acymailing/level-starter.html">', '</a>')).'";
                        }
                    }
                }).request();
            }catch(err){
                new Request({
                    url:"index.php?option=com_acysms&tmpl=component&ctrl=file&task=installPackage",
                    method: "get",
                    onSuccess: function(responseText, responseXML) {
                        if(responseText == "success") {
                            progressbar.style.width = "60%";
                            document.getElementById("information").innerHTML = "'.htmlspecialchars(JText::_('SMS_INSTALLING_PLUGINS'), ENT_QUOTES, 'UTF-8').'"; 
                            installExtensions(); 
                        }else{
                            document.getElementById("information").innerHTML = responseText;//"'.str_replace('"', '\"', JText::sprintf('SMS_FAILED_INSTALL', '<a href="https://www.acyba.com/download-area/download/component-acymailing/level-starter.html">', '</a>')).'";
                        }
                    }
                }).send();
            }
        } 

        function installExtensions(){ 
            try{ 
                var ajaxCall = new Ajax("index.php?option=com_acymailing&ctrl=update&task=install&fromversion=",{ 
                    method: "get", 
                    onComplete: function(responseText, responseXML) { 
                        progressbar.style.width = "90%"; 
                        document.getElementById("information").innerHTML = "'.htmlspecialchars(JText::_('SMS_INSTALLING_LANGUAGES'), ENT_QUOTES, 'UTF-8').'"; 
                        installLanguages()
                    } 
                }).request(); 
            }catch(err){ 
                new Request({ 
                    url:"index.php?option=com_acymailing&ctrl=update&task=install&fromversion=", 
                    method: "get", 
                    onSuccess: function(responseText, responseXML) { 
                        progressbar.style.width = "90%"; 
                        document.getElementById("information").innerHTML = "'.htmlspecialchars(JText::_('SMS_INSTALLING_LANGUAGES'), ENT_QUOTES, 'UTF-8').'"; 
                        installLanguages()
                    } 
                }).send(); 
            } 
        } 
 ';

        jimport('joomla.filesystem.folder');
        $frontLanguages = JFolder::folders(JPATH_ROOT.DS.'language', '-');
        $backLanguages = JFolder::folders(JPATH_ADMINISTRATOR.DS.'language', '-');
        $installedLanguages = array_unique(array_merge($frontLanguages, $backLanguages));
        if(($key = array_search('en-GB', $installedLanguages)) !== false) unset($installedLanguages[$key]);

        $js .= '
        function installLanguages(){ 
            try{ 
                var ajaxCall = new Ajax("index.php?option=com_acymailing&ctrl=file&task=installLanguages&tmpl=component&languages='.implode(',', $installedLanguages).'",{ 
                    method: "get", 
                    onComplete: function(responseText, responseXML) { 
                        progressbar.style.width = "100%"; 
                        setTimeout(function(){  
                            document.getElementById("meter").style.display = "none";  
                            document.getElementById("postinstall").style.display = "";  
                        }, 2000); 
                    } 
                }).request(); 
            }catch(err){ 
                new Request({ 
                    url:"index.php?option=com_acymailing&ctrl=file&task=installLanguages&tmpl=component&languages='.implode(',', $installedLanguages).'", 
                    method: "get", 
                    onSuccess: function(responseText, responseXML) { 
                        progressbar.style.width = "100%"; 
                        setTimeout(function(){ 
                            document.getElementById("meter").style.display = "none"; 
                            document.getElementById("postinstall").style.display = ""; 
                        }, 2000); 
                    } 
                }).send(); 
            } 
        }';

        $doc = JFactory::getDocument();
        $doc->addScriptDeclaration($js);
    }
}
