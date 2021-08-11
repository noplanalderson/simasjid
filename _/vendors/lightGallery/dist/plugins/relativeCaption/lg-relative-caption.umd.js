/*!
 * lightgallery | 2.2.0-beta.0 | June 15th 2021
 * http://www.lightgalleryjs.com/
 * Copyright (c) 2020 Sachin Neravath;
 * @license GPLv3
 */

(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global.lgRelativeCaption = factory());
}(this, (function () { 'use strict';

    /*! *****************************************************************************
    Copyright (c) Microsoft Corporation.

    Permission to use, copy, modify, and/or distribute this software for any
    purpose with or without fee is hereby granted.

    THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
    REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
    AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
    INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
    LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
    OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
    PERFORMANCE OF THIS SOFTWARE.
    ***************************************************************************** */

    var __assign = function() {
        __assign = Object.assign || function __assign(t) {
            for (var s, i = 1, n = arguments.length; i < n; i++) {
                s = arguments[i];
                for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
            }
            return t;
        };
        return __assign.apply(this, arguments);
    };

    /**
     * List of lightGallery events
     * All events should be documented here
     * Below interfaces are used to build the website documentations
     * */
    var lGEvents = {
        afterAppendSlide: 'lgAfterAppendSlide',
        init: 'lgInit',
        hasVideo: 'lgHasVideo',
        containerResize: 'lgContainerResize',
        updateSlides: 'lgUpdateSlides',
        afterAppendSubHtml: 'lgAfterAppendSubHtml',
        beforeOpen: 'lgBeforeOpen',
        afterOpen: 'lgAfterOpen',
        slideItemLoad: 'lgSlideItemLoad',
        beforeSlide: 'lgBeforeSlide',
        afterSlide: 'lgAfterSlide',
        posterClick: 'lgPosterClick',
        dragStart: 'lgDragStart',
        dragMove: 'lgDragMove',
        dragEnd: 'lgDragEnd',
        beforeNextSlide: 'lgBeforeNextSlide',
        beforePrevSlide: 'lgBeforePrevSlide',
        beforeClose: 'lgBeforeClose',
        afterClose: 'lgAfterClose',
    };

    var relativeCaptionSettings = {
        relativeCaption: false,
    };

    /**
     * lightGallery caption for placing captions relative to the image
     */
    var RelativeCaption = /** @class */ (function () {
        function RelativeCaption(instance) {
            // get lightGallery core plugin instance
            this.core = instance;
            // Override some of lightGallery default settings
            var defaultSettings = {
                addClass: this.core.settings.addClass + ' lg-relative-caption',
            };
            this.core.settings = __assign(__assign({}, this.core.settings), defaultSettings);
            // extend module default settings with lightGallery core settings
            this.settings = __assign(__assign(__assign({}, relativeCaptionSettings), this.core.settings), defaultSettings);
            return this;
        }
        RelativeCaption.prototype.init = function () {
            var _this = this;
            if (!this.settings.relativeCaption) {
                return;
            }
            this.core.LGel.on(lGEvents.slideItemLoad + ".caption", function (event) {
                var _a = event.detail, index = _a.index, delay = _a.delay;
                setTimeout(function () {
                    _this.setRelativeCaption(index);
                }, delay);
            });
            this.core.LGel.on(lGEvents.afterSlide + ".caption", function (event) {
                var index = event.detail.index;
                setTimeout(function () {
                    var slide = _this.core.getSlideItem(index);
                    if (slide.hasClass('lg-complete')) {
                        _this.setRelativeCaption(index);
                    }
                });
            });
            this.core.LGel.on(lGEvents.beforeSlide + ".caption", function (event) {
                var index = event.detail.index;
                setTimeout(function () {
                    var slide = _this.core.getSlideItem(index);
                    slide.removeClass('lg-show-caption');
                });
            });
        };
        RelativeCaption.prototype.setCaptionStyle = function (index, rect) {
            var $subHtmlInner = this.core
                .getSlideItem(index)
                .find('.lg-relative-caption-item');
            var $subHtml = this.core.getSlideItem(index).find('.lg-sub-html');
            var subHtmlRect = $subHtmlInner.get().getBoundingClientRect();
            var top = rect.bottom;
            if (rect.height + subHtmlRect.height >= rect.bottom) {
                top -= subHtmlRect.height;
            }
            $subHtml
                .css('width', rect.width + "px")
                .css('left', rect.left + "px")
                .css('top', top + "px");
        };
        RelativeCaption.prototype.setRelativeCaption = function (index) {
            var slide = this.core.getSlideItem(index);
            if (slide.hasClass('lg-current')) {
                var rect = this.core
                    .getSlideItem(index)
                    .find('.lg-object')
                    .get()
                    .getBoundingClientRect();
                this.setCaptionStyle(index, rect);
                slide.addClass('lg-show-caption');
            }
        };
        RelativeCaption.prototype.destroy = function () {
            this.core.LGel.off('.caption');
        };
        return RelativeCaption;
    }());

    return RelativeCaption;

})));
//# sourceMappingURL=lg-relative-caption.umd.js.map
