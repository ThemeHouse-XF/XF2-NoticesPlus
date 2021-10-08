var thnoticesplus = thnoticesplus || {};

!function($, window, document, _undefined)
{
	"use strict";

	thnoticesplus.Overlay = XF.Element.newHandler({
		options: {
			noticeId: null,
			dismissible: true,
			noticeDismissUrl: null
		},
		dismissing: false,

		init: function() {
			var noticeId = parseInt(this.options.noticeId, 10),
			userId = XF.config.userId,
			dismissed = this.getCookies();
			if (!userId) {
				if (noticeId && $.inArray(noticeId, dismissed) !== -1) {
					return;
				}
			}

			var $overlay = this.getOverlayHtml();
			if ($overlay) {
				$overlay = new XF.Overlay($overlay, {
					backdropClose: this.options.dismissible,
					escapeClose: this.options.dismissible
				});
				$overlay.show();
				var self = this;
				$overlay.on('overlay:hidden', function() { self.dismiss(); });
			}
		},

		getOverlayHtml: function() {
			var $overlay = this.$target;

			if ($overlay && $overlay.length && !$overlay.is('.overlay')) {
				$overlay = XF.getOverlayHtml({
					html: $overlay,
					dismissible: this.options.dismissible
				});
			}

			return ($overlay && $overlay.length) ? $overlay : null;
		},

		dismiss: function()
		{
			if (!this.options.dismissible) {
				return;
			}

			if (this.dismissing) {
				return;
			}

			this.dismissing = true;

			var t = this,
				noticeId = parseInt(this.options.noticeId, 10),
				cookieName = 'notice_dismiss',
				userId = XF.config.userId,
				dismissed = t.getCookies();

			if (!userId) {
				if (noticeId && $.inArray(noticeId, dismissed) == -1) {
					dismissed.push(noticeId);
					dismissed.sort(function(a, b) { return (a - b); });

					// expire notice cookies in one month
					var expiry = new Date();
					expiry.setUTCMonth(expiry.getUTCMonth() + 1);
					XF.Cookie.set(cookieName, dismissed.join(','), expiry);
				}
			} else {
				XF.ajax(
					'post',
					this.options.noticeDismissUrl, {},
					function() {},
					{ skipDefault: true }
				);
			}

			this.dismissing = false;
		},


		getCookies: function()
		{
			if (XF.config.userId) {
				return;
			}

			var cookieName = 'notice_dismiss',
				cookieValue = XF.Cookie.get(cookieName),
				cookieDismissed = cookieValue ? cookieValue.split(',') : [],
				values = [],
				id;

			for (var i = 0; i < cookieDismissed.length; i++) {
				id = parseInt(cookieDismissed[i], 10);
				if (id) {
					values.push(id);
				}
			}

			return values;
		},
	});

	XF.Element.register('thnoticesplus_overlay', 'thnoticesplus.Overlay');
}
(jQuery, window, document);