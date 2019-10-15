CREATE TABLE IF NOT EXISTS `#__cwcontact_emailtemplates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `alias` varchar(250) NOT NULL,
  `type` varchar(100) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `email` mediumtext NOT NULL,
  `params` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(10) NOT NULL,
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `ordering` int(11) NOT NULL,
  `language` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__cwcontact_emailtemplates` (`id`, `title`, `alias`, `type`, `subject`, `email`, `params`, `state`, `checked_out`, `checked_out_time`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `publish_up`, `publish_down`, `ordering`, `language`) VALUES
(1, 'Admin Example', 'admin-example', 'admin', 'Admin Subject: [SUBJECT]', '<table class="body" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">\r\n<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">\r\n<table class="main" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff;">\r\n<tbody>\r\n<tr class="">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">\r\n<h1 class="align-center" style="color: #444; font-family: sans-serif; font-weight: 300; line-height: 1.4; margin: 0; margin-bottom: 30px; font-size: 35px; text-transform: capitalize; text-align: center;">Copy of request</h1>\r\n<ul class="no-bullet" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; list-style: none;">\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">Subject:</strong> [SUBJECT]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">Message:</strong> [MESSAGE]</li>\r\n</ul>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr class="neutral" style="background: #EBEBEB;">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">\r\n<h1 class="align-center" style="color: #444; font-family: sans-serif; font-weight: 300; line-height: 1.4; margin: 0; margin-bottom: 30px; font-size: 35px; text-transform: capitalize; text-align: center;">Sent by details</h1>\r\n<ul class="no-bullet" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; list-style: none;">\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">Name:</strong> [NAME]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">Email:</strong> [EMAIL]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">[CUSTOMNAME1]</strong> [CUSTOM1]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">From:</strong> [DATEFROM]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">To:</strong> [DATETO]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">I agree to the TOS?</strong> [TOS]</li>\r\n</ul>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr class="primary" style="background: #00a8e6;">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; color: #ffffff; box-sizing: border-box; padding: 20px;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; color: #ffffff;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr style="color: #ffffff;">\r\n<td style="font-family: sans-serif; font-size: 14px; vertical-align: top; color: #ffffff;">\r\n<h1 class="align-center" style="color: #ffffff; font-family: sans-serif; font-weight: 300; line-height: 1.4; margin: 0; margin-bottom: 30px; font-size: 35px; text-transform: capitalize; text-align: center;">Sent from details</h1>\r\n<ul class="no-bullet" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; color: #ffffff; list-style: none;">\r\n<li style="list-style-position: inside; margin-left: 5px; color: #ffffff;"><strong style="font-weight: bold; color: #ffffff;">IP:</strong> [IP]</li>\r\n<li style="list-style-position: inside; margin-left: 5px; color: #ffffff;"><strong style="font-weight: bold; color: #ffffff;">Sent from this website:</strong> [WEBSITE]</li>\r\n<li style="list-style-position: inside; margin-left: 5px; color: #ffffff;"><strong style="font-weight: bold; color: #ffffff;">Sent from this URL:</strong> [URL]</li>\r\n</ul>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '', 1, 0, '0000-00-00 00:00:00', '2017-01-31 14:20:44', 0, '', '2017-02-06 13:26:56', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, '*'),
(2, 'Copy Example', 'copy-example', 'copy', 'Copy Subject:  [SUBJECT]', '<table class="body" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">\r\n<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">\r\n<table class="main" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff;">\r\n<tbody>\r\n<tr class="primary" style="background: #00a8e6;">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; color: #ffffff; box-sizing: border-box; padding: 20px;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; color: #ffffff;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr style="color: #ffffff;">\r\n<td style="font-family: sans-serif; font-size: 14px; vertical-align: top; color: #ffffff;">\r\n<h1 class="align-center" style="color: #ffffff; font-family: sans-serif; font-weight: 300; line-height: 1.4; margin: 0; margin-bottom: 30px; font-size: 35px; text-transform: capitalize; text-align: center;">Hi [NAME],</h1>\r\n<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; color: #ffffff;">Thanks for contacting [WEBSITE] we appreciate that you’ve taken the time to write to us. We’ll get back to you very soon.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr class="">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">\r\n<h1 class="align-center" style="color: #444; font-family: sans-serif; font-weight: 300; line-height: 1.4; margin: 0; margin-bottom: 30px; font-size: 35px; text-transform: capitalize; text-align: center;">Copy of request</h1>\r\n<ul class="no-bullet" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; list-style: none;">\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">Subject:</strong> [SUBJECT]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">Message:</strong> [MESSAGE]</li>\r\n</ul>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr class="neutral" style="background: #EBEBEB;">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">\r\n<h1 class="align-center" style="color: #444; font-family: sans-serif; font-weight: 300; line-height: 1.4; margin: 0; margin-bottom: 30px; font-size: 35px; text-transform: capitalize; text-align: center;">Sent by details</h1>\r\n<ul class="no-bullet" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; list-style: none;">\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">Name:</strong> [NAME]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">Email:</strong> [EMAIL]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">[CUSTOMNAME1]</strong> [CUSTOM1]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">From:</strong> [DATEFROM]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">To:</strong> [DATETO]</li>\r\n<li style="list-style-position: inside; margin-left: 5px;"><strong style="font-weight: bold;">I agree to the TOS?</strong> [TOS]</li>\r\n</ul>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr class="primary" style="background: #00a8e6;">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; color: #ffffff; box-sizing: border-box; padding: 20px;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; color: #ffffff;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr style="color: #ffffff;">\r\n<td style="font-family: sans-serif; font-size: 14px; vertical-align: top; color: #ffffff;">\r\n<h1 class="align-center" style="color: #ffffff; font-family: sans-serif; font-weight: 300; line-height: 1.4; margin: 0; margin-bottom: 30px; font-size: 35px; text-transform: capitalize; text-align: center;">Sent from details</h1>\r\n<ul class="no-bullet" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; color: #ffffff; list-style: none;">\r\n<li style="list-style-position: inside; margin-left: 5px; color: #ffffff;"><strong style="font-weight: bold; color: #ffffff;">IP:</strong> [IP]</li>\r\n<li style="list-style-position: inside; margin-left: 5px; color: #ffffff;"><strong style="font-weight: bold; color: #ffffff;">Sent from this website:</strong> [WEBSITE]</li>\r\n<li style="list-style-position: inside; margin-left: 5px; color: #ffffff;"><strong style="font-weight: bold; color: #ffffff;">Sent from this URL:</strong> [URL]</li>\r\n</ul>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr class="footer" style="background-color: #f6f6f6; clear: both; padding-top: 10px; text-align: center; width: 100%;">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 12px; vertical-align: top; box-sizing: border-box; padding: 20px; color: #999999; text-align: center;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td class="content-block" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;">\r\n<ul class="subnav" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; margin: 5px; padding: 0; list-style: none;">\r\n<li style="list-style-position: inside; margin-left: 5px; display: inline-block;"><a style="color: #999999; text-decoration: none; font-size: 12px; text-align: center;" href="#">GitHub</a></li>\r\n<li style="list-style-position: inside; margin-left: 5px; display: inline-block;"><a style="color: #999999; text-decoration: none; font-size: 12px; text-align: center;" href="#">Facebook</a></li>\r\n<li style="list-style-position: inside; margin-left: 5px; display: inline-block;"><a style="color: #999999; text-decoration: none; font-size: 12px; text-align: center;" href="#">Twitter</a></li>\r\n<li style="list-style-position: inside; margin-left: 5px; display: inline-block;"><a style="color: #999999; text-decoration: none; font-size: 12px; text-align: center;" href="#">Google +</a></li>\r\n</ul>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="content-block" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Example Company, 123 Example Street, Example EX 12345</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '', 1, 0, '0000-00-00 00:00:00', '2017-01-31 15:44:17', 0, '', '2017-02-06 13:27:38', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, '*'),
(3, 'Thankyou Example', 'thankyou-example', 'thankyou', 'Thank you [NAME] for contacting [WEBSITE].', '<table class="body" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">\r\n<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">\r\n<table class="main" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff;">\r\n<tbody>\r\n<tr class="primary" style="background: #00a8e6;">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; color: #ffffff; box-sizing: border-box; padding: 20px;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; color: #ffffff;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr style="color: #ffffff;">\r\n<td style="font-family: sans-serif; font-size: 14px; vertical-align: top; color: #ffffff;">\r\n<h1 class="align-center" style="color: #ffffff; font-family: sans-serif; font-weight: 300; line-height: 1.4; margin: 0; margin-bottom: 30px; font-size: 35px; text-transform: capitalize; text-align: center;">Hi [NAME],</h1>\r\n<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; color: #ffffff;">Thanks for contacting [WEBSITE] we appreciate that you’ve taken the time to write to us. We’ll get back to you very soon.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr class="footer" style="background-color: #f6f6f6; clear: both; padding-top: 10px; text-align: center; width: 100%;">\r\n<td class="wrapper" style="font-family: sans-serif; font-size: 12px; vertical-align: top; box-sizing: border-box; padding: 20px; color: #999999; text-align: center;">\r\n<table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td class="content-block" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;">\r\n<ul class="subnav" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px; margin: 5px; padding: 0; list-style: none;">\r\n<li style="list-style-position: inside; margin-left: 5px; display: inline-block;"><a style="color: #999999; text-decoration: none; font-size: 12px; text-align: center;" href="#">GitHub</a></li>\r\n<li style="list-style-position: inside; margin-left: 5px; display: inline-block;"><a style="color: #999999; text-decoration: none; font-size: 12px; text-align: center;" href="#">Facebook</a></li>\r\n<li style="list-style-position: inside; margin-left: 5px; display: inline-block;"><a style="color: #999999; text-decoration: none; font-size: 12px; text-align: center;" href="#">Twitter</a></li>\r\n<li style="list-style-position: inside; margin-left: 5px; display: inline-block;"><a style="color: #999999; text-decoration: none; font-size: 12px; text-align: center;" href="#">Google +</a></li>\r\n</ul>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="content-block" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Example Company, 123 Example Street, Example EX 12345</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '', 1, 0, '0000-00-00 00:00:00', '2017-01-31 15:47:43', 0, '', '2017-02-06 13:18:13', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, '*');