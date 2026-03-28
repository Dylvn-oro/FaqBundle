define(function(require) {
    'use strict';

    const BaseView = require('oroui/js/app/views/base/view');
    const _ = require('underscore');
    const $ = require('jquery');

    const FaqView = BaseView.extend({
        options: {
            scrollOffset: 80,
            scrollDuration: 400
        },

        events: {
            'click .faq-category__item-question': '_onQuestionClick',
            'click .faq-nav__link': '_onNavClick'
        },

        /**
         * @inheritDoc
         */
        initialize(options) {
            this.options = _.defaults(options || {}, this.options);
            FaqView.__super__.initialize.call(this, options);
            this._handleAnchorOnLoad();
        },

        _onQuestionClick(e) {
            const $button = $(e.currentTarget);
            const $item = $button.closest('.faq-category__item');
            const isOpen = $item.hasClass('faq-category__item--open');

            $item.toggleClass('faq-category__item--open', !isOpen);
            $button.attr('aria-expanded', String(!isOpen));
        },

        _onNavClick(e) {
            const href = $(e.currentTarget).attr('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                this._scrollTo(href);
                history.pushState(null, null, href);
            }
        },

        _scrollTo(anchor) {
            const $target = this.$(anchor);
            if (!$target.length) {
                return;
            }
            $('html, body').animate(
                {scrollTop: $target.offset().top - this.options.scrollOffset},
                this.options.scrollDuration
            );
        },

        _handleAnchorOnLoad() {
            const hash = window.location.hash;
            if (hash) {
                _.defer(() => this._scrollTo(hash));
            }
        }
    });

    return FaqView;
});
