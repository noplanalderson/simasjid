/*!
 * lightgallery | 2.2.0-beta.0 | June 15th 2021
 * http://www.lightgalleryjs.com/
 * Copyright (c) 2020 Sachin Neravath;
 * @license GPLv3
 */

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

var autoplaySettings = {
    autoplay: true,
    slideShowAutoplay: false,
    slideShowInterval: 5000,
    progressBar: true,
    forceSlideShowAutoplay: false,
    autoplayControls: true,
    appendAutoplayControlsTo: '.lg-toolbar',
};

/**
 * Creates the autoplay plugin.
 * @param {object} element - lightGallery element
 */
var Autoplay = /** @class */ (function () {
    function Autoplay(instance) {
        this.core = instance;
        // extend module default settings with lightGallery core settings
        this.settings = __assign(__assign({}, autoplaySettings), this.core.settings);
        return this;
    }
    Autoplay.prototype.init = function () {
        var _this = this;
        if (!this.settings.autoplay) {
            return;
        }
        this.interval = false;
        // Identify if slide happened from autoplay
        this.fromAuto = true;
        // Identify if autoplay canceled from touch/drag
        this.pausedOnTouchDrag = false;
        this.pausedOnSlideChange = false;
        // append autoplay controls
        if (this.settings.autoplayControls) {
            this.controls();
        }
        // Create progress bar
        if (this.settings.progressBar) {
            this.core.$lgContent.append('<div class="lg-progress-bar"><div class="lg-progress"></div></div>');
        }
        // Start autoplay
        if (this.settings.slideShowAutoplay) {
            this.core.LGel.once(lGEvents.slideItemLoad + ".autoplay", function () {
                _this.startAuto();
            });
        }
        // cancel interval on touchstart and dragstart
        this.core.LGel.on(lGEvents.dragStart + ".autoplay touchstart.lg.autoplay", function () {
            if (_this.interval) {
                _this.cancelAuto();
                _this.pausedOnTouchDrag = true;
            }
        });
        // restore autoplay if autoplay canceled from touchstart / dragstart
        this.core.LGel.on(lGEvents.dragEnd + ".autoplay touchend.lg.autoplay", function () {
            if (!_this.interval && _this.pausedOnTouchDrag) {
                _this.startAuto();
                _this.pausedOnTouchDrag = false;
            }
        });
        this.core.LGel.on(lGEvents.beforeSlide + ".autoplay", function () {
            _this.showProgressBar();
            if (!_this.fromAuto && _this.interval) {
                _this.cancelAuto();
                _this.pausedOnSlideChange = true;
            }
            else {
                _this.pausedOnSlideChange = false;
            }
            _this.fromAuto = false;
        });
        // restore autoplay if autoplay canceled from touchstart / dragstart
        this.core.LGel.on(lGEvents.afterSlide + ".autoplay", function () {
            if (_this.pausedOnSlideChange &&
                !_this.interval &&
                _this.settings.forceSlideShowAutoplay) {
                _this.startAuto();
                _this.pausedOnSlideChange = false;
            }
        });
        // set progress
        this.showProgressBar();
    };
    Autoplay.prototype.showProgressBar = function () {
        var _this = this;
        if (this.settings.progressBar && this.fromAuto) {
            var _$progressBar_1 = this.core.outer.find('.lg-progress-bar');
            var _$progress_1 = this.core.outer.find('.lg-progress');
            if (this.interval) {
                _$progress_1.removeAttr('style');
                _$progressBar_1.removeClass('lg-start');
                setTimeout(function () {
                    _$progress_1.css('transition', 'width ' +
                        (_this.core.settings.speed +
                            _this.settings.slideShowInterval) +
                        'ms ease 0s');
                    _$progressBar_1.addClass('lg-start');
                }, 20);
            }
        }
    };
    // Manage autoplay via play/stop buttons
    Autoplay.prototype.controls = function () {
        var _this = this;
        var _html = '<button aria-label="Toggle autoplay" type="button" class="lg-autoplay-button lg-icon"></button>';
        // Append autoplay controls
        this.core.outer
            .find(this.settings.appendAutoplayControlsTo)
            .append(_html);
        this.core.outer
            .find('.lg-autoplay-button')
            .first()
            .on('click.lg.autoplay', function () {
            if (_this.core.outer.hasClass('lg-show-autoplay')) {
                _this.cancelAuto();
            }
            else {
                if (!_this.interval) {
                    _this.startAuto();
                }
            }
        });
    };
    // Autostart gallery
    Autoplay.prototype.startAuto = function () {
        var _this = this;
        this.core.outer
            .find('.lg-progress')
            .css('transition', 'width ' +
            (this.core.settings.speed +
                this.settings.slideShowInterval) +
            'ms ease 0s');
        this.core.outer.addClass('lg-show-autoplay');
        this.core.outer.find('.lg-progress-bar').addClass('lg-start');
        this.interval = setInterval(function () {
            if (_this.core.index + 1 < _this.core.galleryItems.length) {
                _this.core.index++;
            }
            else {
                _this.core.index = 0;
            }
            _this.fromAuto = true;
            _this.core.slide(_this.core.index, false, false, 'next');
        }, this.core.settings.speed + this.settings.slideShowInterval);
    };
    // cancel Autostart
    Autoplay.prototype.cancelAuto = function () {
        if (this.interval) {
            this.core.outer.find('.lg-progress').removeAttr('style');
            this.core.outer.removeClass('lg-show-autoplay');
            this.core.outer.find('.lg-progress-bar').removeClass('lg-start');
        }
        clearInterval(this.interval);
        this.interval = false;
    };
    Autoplay.prototype.closeGallery = function () {
        this.cancelAuto();
    };
    Autoplay.prototype.destroy = function () {
        if (this.settings.autoplay) {
            this.core.outer.find('.lg-progress-bar').remove();
        }
        // Remove all event listeners added by autoplay plugin
        this.core.LGel.off('.lg.autoplay');
        this.core.LGel.off('.autoplay');
    };
    return Autoplay;
}());

export default Autoplay;
//# sourceMappingURL=lg-autoplay.es5.js.map
