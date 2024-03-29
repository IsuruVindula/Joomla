/**
 * Main JavaScript file
 *
 * @package         NoNumber Extension Manager
 * @version         4.8.7
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2015 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

var NNEM_NNEM = 0;
var NNEM_IDS_FAILED = [];
var NNEM_TASK = 'install';
var NNEM_INSTALL = 0;

(function($) {
	if (typeof( window['nnManagerProcess'] ) != "undefined") {
		return;
	}

	nnManagerProcess = {

		process: function(task) {
			this.hide('title');
			this.show('processing', $('.titles'));

			NNEM_TASK = task;
			NNEM_INSTALL = (task != 'uninstall');

			var sb = window.parent.SqueezeBox;
			sb.overlay['removeEvent']('click', sb.bound.close);
			if (NNEM_REFRESH_ON_CLOSE || NNEM_IDS[0] == 'nonumberextensionmanager') {
				NNEM_NNEM = 1;
				sb.setOptions({
					onClose: function() {
						window.parent.location.href = window.parent.location;
					}
				});
			} else {
				sb.setOptions({
					onClose: function() {
						window.parent.nnManager.refreshData(1);
					}
				});
			}

			this.processNextStep(0);
		},

		processNextStep: function(step) {
			var id = NNEM_IDS[step];

			if (!id) {
				var sb = window.parent.SqueezeBox;
				this.hide('title');
				if (NNEM_IDS_FAILED.length) {
					this.show('failed', $('.titles'));
					NNEM_IDS = NNEM_IDS_FAILED;
					NNEM_IDS_FAILED = [];
				} else {
					this.hide('processlist');
					this.show('done', $('.titles'));
					if (!NNEM_NNEM) {
						window.parent.nnManager.refreshData(1);
						sb.removeEvents();
					}
				}
				sb.overlay['addEvent']('click', sb.bound.close);
			} else {
				this.install(step)
			}
		},

		install: function(step) {
			var id = NNEM_IDS[step];

			this.hide('status', $('tr#row_' + id));
			this.show('processing_' + id);

			var url = 'index.php?option=com_nonumbermanager&view=process&tmpl=component&id=' + id;
			if (NNEM_INSTALL) {
				url += '&action=install';
				ext_url = $('#url_' + id).val() + '&action=' + NNEM_TASK + '&host=' + window.location.hostname;
				url += '&url=' + escape(ext_url);
			} else {
				url += '&action=uninstall';
			}
			nnScripts.loadajax(url, 'nnManagerProcess.processResult( data.trim(), ' + step + ' )', 'nnManagerProcess.processResult( 0, ' + step + ' )', NNEM_TOKEN + '=1');
		},

		processResult: function(data, step) {
			var id = NNEM_IDS[step];

			this.hide('status', $('tr#row_' + id));
			if (!data || ( data !== '1' && data.indexOf('<div class="alert alert-success"') == -1 )) {
				NNEM_IDS_FAILED.push(id);
				this.show('failed_' + id);
			} else {
				this.show('success_' + id);
			}
			this.processNextStep(++step);
		},

		show: function(classes, parent) {
			if (!parent) {
				parent = $('div#nnem');
			} else {
				parent.addClass(classes.replace(',', ''));
			}
			classes = '.' + classes.replace(', ', ', .')
			parent.find(classes).removeClass('hide');
		},

		hide: function(classes, parent) {
			if (!parent) {
				parent = $('div#nnem');
			} else {
				parent.removeClass(classes.replace(',', ''));
			}
			classes = '.' + classes.replace(', ', ', .')
			parent.find(classes).addClass('hide');
		}
	}
})(jQuery);
