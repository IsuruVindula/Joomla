<?php
/**
 * @package	AcySMS for Joomla!
 * @version	3.5.1
 * @author	acyba.com
 * @copyright	(C) 2009-2018 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><div id="acysms_content" class="installacymailing">
    <div id="iframedoc"></div>
    <span style="font-weight: bold;"><i class="smsicon-stats" style="margin-right: 10px;vertical-align:middle;"></i><?php echo JText::_('SMS_MAILING_PRESENTATION'); ?></span>
    <div id="startbutton" class="myacysmsarea"><button onclick="document.getElementById('meter').style.display = '';document.getElementById('startbutton').style.display = 'none';installAcyMailing();"><?php echo JText::_('SMS_TRY_IT'); ?></button></div>
    <div id="meter" style="display:none;">
        <div>
            <span id="progressbar"></span>
            <div id="information"></div>
        </div>
    </div>
    <div id="postinstall" style="display:none;font-weight: bold;margin-top: 15px;">
        <?php echo JText::_('SMS_INSTALLED'); ?>
        <div class="myacysmsarea"><a href="index.php?option=com_acymailing" ><button><?php echo JText::_('SMS_TRY_IT'); ?></button></a></div>
    </div>

    <div id="acy_main_features" style="max-width: 980px;margin:auto;margin-top:50px;">
        <div class="contentsize shadowleft">
            <div class="row-fluid">
                <div class="span7">
                    <h4>Manage your mailing lists efficiently</h4>
                    <ul>
                        <li>Import and export easily as many <strong>contacts and groups</strong> as you want and create different <strong>mailing lists</strong></li>
                        <li><strong>Filter your users</strong> when you send a newsletter, depending on their group, their subscription date, their profile ... etc</li>
                        <li>Keep your lists clean with our <strong>bounce back handling</strong> system. All failed e-mails are automatically deleted and people who put your newsletters in their spam box are also deleted.</li>
                    </ul>
                </div>
                <div class="span5"><img style="max-width: 360px;" src="https://www.acyba.com/images/main_features_acymailing/user_management.png" alt=""></div>
            </div>
        </div>
        <div class="greybg">
            <div class="contentsize shadowright">
                <div class="row-fluid">
                    <div class="span5"><img style="max-width: 340px; margin-top: 30px;" src="https://www.acyba.com/images/main_features_acymailing/customize.png" alt=""></div>
                    <div class="span7">
                        <h4>Customize AcyMailing and create beautiful campaigns</h4>
                        <ul>
                            <li>Personalize your <strong>subscription module</strong> and all the AcyMailing front-end elements with CSS</li>
                            <li>Default <strong>responsive newsletter templates</strong> are included. You can modify them as you want to fit your own visual identity.</li>
                            <li>Enjoy our&nbsp;<a target="_blank" href="https://www.acyba.com/acymailing/templates-pack.html">templates pack</a> for more designs. And if you don't want to manage the "template creation"&nbsp;<a target="_blank" href="https://www.acyba.com/component/content/article/8-acymailing/264-template-pack-perso.html?Itemid=339">let our team do it for you</a> !</li>
                            <li><strong>Edit your newsletter</strong> quickly and easily thanks to the <strong>Acy editor</strong> which enables you to modify, replace or delete pictures, texts and areas without having a chance to break your layout!</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="contentsize shadowleft">
            <div class="row-fluid">
                <div class="span7">
                    <h4>Use all your website resources</h4>
                    <ul>
                        <li>Insert user profile informations (hello "<strong>name</strong>", today is your <strong>birthday</strong>, welcome to our website...)</li>
                        <li>Add elements to your newsletter directly from other Joomla components, thanks to our <strong>plugins and integrations</strong> (Hikashop, Joomsocial, K2, VirtueMart, JoomEvent...)</li>
                        <li>AcyMailing is available in more than<strong> 40 languages</strong></li>
                    </ul>
                </div>
                <div class="span5"><img src="https://www.acyba.com/images/main_features_acymailing/integrations.png" alt=""></div>
            </div>
        </div>
        <div class="greybg">
            <div class="contentsize shadowright">
                <div class="row-fluid">
                    <div class="span5"><img style="max-width: 300px;" src="https://www.acyba.com/images/main_features_acymailing/automatic.png" alt=""></div>
                    <div class="span7">
                        <h4>Automate your communication</h4>
                        <ul>
                            <li>Make sure your customers receive the right message at the right time...<br>Set up a series of <strong>automatic follow-up messages</strong>!</li>
                            <li><strong>Schedule your newsletters</strong> so you can plan everything and do something else</li>
                            <li>Birthday newsletter</li>
                            <li>Let AcyMailing automatically generate your weekly Newsletter with our <strong>auto-newsletter</strong> feature and its ability to load content from your website (new products, articles, upcoming events...)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="contentsize shadowleft">
            <div class="row-fluid">
                <div class="span7">
                    <h4>Improve your delivery rate</h4>
                    <ul>
                        <li>Easily test your Newsletters with our <strong>integrated Spam test</strong></li>
                        <li>Don't bother sending your own server and plug AcyMailing to an external SMTP server or one of our delivery partners</li>
                        <li>Sign all your messages with <strong>DKIM</strong></li>
                        <li>Make sure your emails are legitimate with the <strong>SPF / Sender-ID validation</strong></li>
                    </ul>
                </div>
                <div class="span5"><img src="https://www.acyba.com/images/main_features_acymailing/delivery_rate.png" alt=""></div>
            </div>
        </div>
        <div class="greybg">
            <div class="contentsize shadowright">
                <div class="row-fluid">
                    <div class="span5"><img style="max-width: 350px;" src="https://www.acyba.com/images/main_features_acymailing/spread_news.png" alt="share newsletter"></div>
                    <div class="span7">
                        <h4>Spread your news on social networks</h4>
                        <ul>
                            <li>Share your Newsletter on Facebook / Twitter / Google +</li>
                            <li>Forward to a friend</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="contentsize">
            <div class="row-fluid">
                <div class="span7">
                    <h4>Track your results</h4>
                    <ul>
                        <li>Who opened your Newsletter, when?</li>
                        <li>Who clicked on what link from what Newsletter?</li>
                        <li>Don't only get powerful statistics but use this information for your next campaign</li>
                    </ul>
                </div>
                <div class="span5"><img style="max-width: 360px;" src="https://www.acyba.com/images/main_features_acymailing/stat.png" alt=""></div>
            </div>
        </div>
    </div>
</div>
