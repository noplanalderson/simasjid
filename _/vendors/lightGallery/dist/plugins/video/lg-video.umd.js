/*!
 * lightgallery | 2.2.0-beta.0 | June 15th 2021
 * http://www.lightgalleryjs.com/
 * Copyright (c) 2020 Sachin Neravath;
 * @license GPLv3
 */

(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global.lgVideo = factory());
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

    var videoSettings = {
        autoplayFirstVideo: true,
        youTubePlayerParams: false,
        vimeoPlayerParams: false,
        wistiaPlayerParams: false,
        gotoNextSlideOnVideoEnd: true,
        autoplayVideoOnSlide: false,
        videojs: false,
        videojsOptions: {},
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

    /**
     * Video module for lightGallery
     * Supports HTML5, YouTube, Vimeo, wistia videos
     *
     *
     * @ref Wistia
     * https://wistia.com/support/integrations/wordpress(How to get url)
     * https://wistia.com/support/developers/embed-options#using-embed-options
     * https://wistia.com/support/developers/player-api
     * https://wistia.com/support/developers/construct-an-embed-code
     * http://jsfiddle.net/xvnm7xLm/
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/video
     * https://wistia.com/support/embed-and-share/sharing-videos
     * https://private-sharing.wistia.com/medias/mwhrulrucj
     *
     * @ref Youtube
     * https://developers.google.com/youtube/player_parameters#enablejsapi
     * https://developers.google.com/youtube/iframe_api_reference
     *
     */
    function param(obj) {
        return Object.keys(obj)
            .map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]);
        })
            .join('&');
    }
    var Video = /** @class */ (function () {
        function Video(instance) {
            // get lightGallery core plugin instance
            this.core = instance;
            this.settings = __assign(__assign({}, videoSettings), this.core.settings);
            return this;
        }
        Video.prototype.init = function () {
            var _this = this;
            /**
             * Event triggered when video url found without poster
             * Append video HTML
             * Play if autoplayFirstVideo is true
             */
            this.core.LGel.on(lGEvents.hasVideo + ".video", this.onHasVideo.bind(this));
            if (this.core.settings.enableSwipe || this.core.settings.enableDrag) {
                this.core.LGel.on(lGEvents.posterClick + ".video", function () {
                    var $el = _this.core.getSlideItem(_this.core.index);
                    _this.loadVideoOnPosterClick($el);
                });
            }
            else {
                // For IE 9 and bellow
                this.core.outer
                    .find('.lg-item')
                    .first()
                    .on('click.lg', function () {
                    var $el = _this.core.getSlideItem(_this.core.index);
                    _this.loadVideoOnPosterClick($el);
                });
            }
            // @desc fired immediately before each slide transition.
            this.core.LGel.on(lGEvents.beforeSlide + ".video", this.onBeforeSlide.bind(this));
            // @desc fired immediately after each slide transition.
            this.core.LGel.on(lGEvents.afterSlide + ".video", this.onAfterSlide.bind(this));
        };
        /**
         * @desc Event triggered when video url or poster found
         * Append video HTML is poster is not given
         * Play if autoplayFirstVideo is true
         *
         * @param {Event} event - Javascript Event object.
         */
        Video.prototype.onHasVideo = function (event) {
            var _a = event.detail, index = _a.index, src = _a.src, html5Video = _a.html5Video, hasPoster = _a.hasPoster, isFirstSlide = _a.isFirstSlide;
            if (!hasPoster) {
                // All functions are called separately if poster exist in loadVideoOnPosterClick function
                this.appendVideos(this.core.getSlideItem(index), {
                    src: src,
                    addClass: 'lg-object',
                    index: index,
                    html5Video: html5Video,
                });
                // Automatically navigate to next slide once video reaches the end.
                this.gotoNextSlideOnVideoEnd(src, index);
            }
            if (this.settings.autoplayFirstVideo && isFirstSlide) {
                if (hasPoster) {
                    var $slide = this.core.getSlideItem(index);
                    this.loadVideoOnPosterClick($slide);
                }
                else {
                    this.playVideo(index);
                }
            }
        };
        /**
         * @desc fired immediately before each slide transition.
         * Pause the previous video
         * Hide the download button if the slide contains YouTube, Vimeo, or Wistia videos.
         *
         * @param {Event} event - Javascript Event object.
         * @param {number} prevIndex - Previous index of the slide.
         * @param {number} index - Current index of the slide
         */
        Video.prototype.onBeforeSlide = function (event) {
            var _a = event.detail, prevIndex = _a.prevIndex, index = _a.index;
            this.pauseVideo(prevIndex);
            var _videoInfo = this.core.galleryItems[index].__slideVideoInfo || {};
            if (_videoInfo.youtube || _videoInfo.vimeo || _videoInfo.wistia) {
                this.core.outer.addClass('lg-hide-download');
            }
        };
        /**
         * @desc fired immediately after each slide transition.
         * Play video if autoplayVideoOnSlide option is enabled.
         *
         * @param {Event} event - Javascript Event object.
         * @param {number} prevIndex - Previous index of the slide.
         * @param {number} index - Current index of the slide
         */
        Video.prototype.onAfterSlide = function (event) {
            var _this = this;
            var index = event.detail.index;
            if (this.settings.autoplayVideoOnSlide && this.core.lGalleryOn) {
                setTimeout(function () {
                    var $slide = _this.core.getSlideItem(index);
                    if (!$slide.hasClass('lg-video-loaded')) {
                        _this.loadVideoOnPosterClick($slide);
                    }
                    else {
                        _this.playVideo(index);
                    }
                }, 100);
            }
        };
        /**
         * Play HTML5, Youtube, Vimeo or Wistia videos in a particular slide.
         * @param {number} index - Index of the slide
         */
        Video.prototype.playVideo = function (index) {
            this.controlVideo(index, 'play');
        };
        /**
         * Pause HTML5, Youtube, Vimeo or Wistia videos in a particular slide.
         * @param {number} index - Index of the slide
         */
        Video.prototype.pauseVideo = function (index) {
            this.controlVideo(index, 'pause');
        };
        Video.prototype.getVideoHtml = function (src, addClass, index, html5Video) {
            var video = '';
            var videoInfo = this.core.galleryItems[index]
                .__slideVideoInfo || {};
            var currentGalleryItem = this.core.galleryItems[index];
            var videoTitle = currentGalleryItem.title || currentGalleryItem.alt;
            videoTitle = videoTitle ? 'title="' + videoTitle + '"' : '';
            var commonIframeProps = "allowtransparency=\"true\" \n            frameborder=\"0\" \n            scrolling=\"no\" \n            allowfullscreen \n            mozallowfullscreen \n            webkitallowfullscreen \n            oallowfullscreen \n            msallowfullscreen";
            if (videoInfo.youtube) {
                var videoId = 'lg-youtube' + index;
                var youTubePlayerParams = "?wmode=opaque&autoplay=0&enablejsapi=1";
                var playerParams = youTubePlayerParams +
                    (this.settings.youTubePlayerParams
                        ? '&' + param(this.settings.youTubePlayerParams)
                        : '');
                video = "<iframe allow=\"autoplay\" id=" + videoId + " class=\"lg-video-object lg-youtube " + addClass + "\" " + videoTitle + " src=\"//www.youtube.com/embed/" + (videoInfo.youtube[1] + playerParams) + "\" " + commonIframeProps + "></iframe>";
            }
            else if (videoInfo.vimeo) {
                var videoId = 'lg-vimeo' + index;
                var playerParams = param(this.settings.vimeoPlayerParams);
                video = "<iframe allow=\"autoplay\" id=" + videoId + " class=\"lg-video-object lg-vimeo " + addClass + "\" " + videoTitle + " src=\"//player.vimeo.com/video/" + (videoInfo.vimeo[1] + playerParams) + "\" " + commonIframeProps + "></iframe>";
            }
            else if (videoInfo.wistia) {
                var wistiaId = 'lg-wistia' + index;
                var playerParams = param(this.settings.wistiaPlayerParams);
                video = "<iframe allow=\"autoplay\" id=\"" + wistiaId + "\" src=\"//fast.wistia.net/embed/iframe/" + (videoInfo.wistia[4] + playerParams) + "\" " + videoTitle + " class=\"wistia_embed lg-video-object lg-wistia " + addClass + "\" name=\"wistia_embed\" " + commonIframeProps + "></iframe>";
            }
            else if (videoInfo.html5) {
                var html5VideoMarkup = '';
                for (var i = 0; i < html5Video.source.length; i++) {
                    html5VideoMarkup += "<source src=\"" + html5Video.source[i].src + "\" type=\"" + html5Video.source[i].type + "\">";
                }
                var html5VideoAttrs_1 = '';
                var videoAttributes_1 = html5Video.attributes || {};
                Object.keys(videoAttributes_1 || {}).forEach(function (key) {
                    html5VideoAttrs_1 += key + "=\"" + videoAttributes_1[key] + "\" ";
                });
                video = "<video class=\"lg-video-object lg-html5 " + (this.settings.videojs ? 'video-js' : '') + "\" " + html5VideoAttrs_1 + ">\n                " + html5VideoMarkup + "\n                Your browser does not support HTML5 video.\n            </video>";
            }
            return video;
        };
        /**
         * @desc - Append videos to the slide
         *
         * @param {HTMLElement} el - slide element
         * @param {Object} videoParams - Video parameters, Contains src, class, index, htmlVideo
         */
        Video.prototype.appendVideos = function (el, videoParams) {
            var _a;
            var videoHtml = this.getVideoHtml(videoParams.src, videoParams.addClass, videoParams.index, videoParams.html5Video);
            el.find('.lg-video-cont').append(videoHtml);
            var $videoElement = el.find('.lg-video-object').first();
            if (this.settings.videojs && ((_a = this.core.galleryItems[videoParams.index].__slideVideoInfo) === null || _a === void 0 ? void 0 : _a.html5)) {
                try {
                    return videojs($videoElement.get(), this.settings.videojsOptions);
                }
                catch (e) {
                    console.error('lightGallery:- Make sure you have included videojs');
                }
            }
        };
        Video.prototype.gotoNextSlideOnVideoEnd = function (src, index) {
            var _this = this;
            var $videoElement = this.core
                .getSlideItem(index)
                .find('.lg-video-object')
                .first();
            var videoInfo = this.core.galleryItems[index].__slideVideoInfo || {};
            if (this.settings.gotoNextSlideOnVideoEnd) {
                if (videoInfo.html5) {
                    $videoElement.on('ended', function () {
                        _this.core.goToNextSlide();
                    });
                }
                else if (videoInfo.vimeo) {
                    try {
                        // https://github.com/vimeo/player.js/#ended
                        new Vimeo.Player($videoElement.get()).on('ended', function () {
                            _this.core.goToNextSlide();
                        });
                    }
                    catch (e) {
                        console.error('lightGallery:- Make sure you have included //github.com/vimeo/player.js');
                    }
                }
                else if (videoInfo.wistia) {
                    try {
                        window._wq = window._wq || [];
                        // @todo Event is gettign triggered multiple times
                        window._wq.push({
                            id: $videoElement.attr('id'),
                            onReady: function (video) {
                                video.bind('end', function () {
                                    _this.core.goToNextSlide();
                                });
                            },
                        });
                    }
                    catch (e) {
                        console.error('lightGallery:- Make sure you have included //fast.wistia.com/assets/external/E-v1.js');
                    }
                }
            }
        };
        Video.prototype.controlVideo = function (index, action) {
            var $videoElement = this.core
                .getSlideItem(index)
                .find('.lg-video-object')
                .first();
            var videoInfo = this.core.galleryItems[index].__slideVideoInfo || {};
            if (!$videoElement.get())
                return;
            if (videoInfo.youtube) {
                try {
                    $videoElement.get().contentWindow.postMessage("{\"event\":\"command\",\"func\":\"" + action + "Video\",\"args\":\"\"}", '*');
                }
                catch (e) {
                    console.error("lightGallery:- " + e);
                }
            }
            else if (videoInfo.vimeo) {
                try {
                    new Vimeo.Player($videoElement.get())[action]();
                }
                catch (e) {
                    console.error('lightGallery:- Make sure you have included //github.com/vimeo/player.js');
                }
            }
            else if (videoInfo.html5) {
                if (this.settings.videojs) {
                    try {
                        videojs($videoElement.get())[action]();
                    }
                    catch (e) {
                        console.error('lightGallery:- Make sure you have included videojs');
                    }
                }
                else {
                    $videoElement.get()[action]();
                }
            }
            else if (videoInfo.wistia) {
                try {
                    window._wq = window._wq || [];
                    // @todo Find a way to destroy wistia player instance
                    window._wq.push({
                        id: $videoElement.attr('id'),
                        onReady: function (video) {
                            video[action]();
                        },
                    });
                }
                catch (e) {
                    console.error('lightGallery:- Make sure you have included //fast.wistia.com/assets/external/E-v1.js');
                }
            }
        };
        Video.prototype.loadVideoOnPosterClick = function ($el) {
            var _this = this;
            // check slide has poster
            if (!$el.hasClass('lg-video-loaded')) {
                // check already video element present
                if (!$el.hasClass('lg-has-video')) {
                    $el.addClass('lg-has-video');
                    var _html = void 0;
                    var _src = this.core.galleryItems[this.core.index].src;
                    var video = this.core.galleryItems[this.core.index].video;
                    if (video) {
                        _html =
                            typeof video === 'string' ? JSON.parse(video) : video;
                    }
                    var videoJsPlayer_1 = this.appendVideos($el, {
                        src: _src,
                        addClass: '',
                        index: this.core.index,
                        html5Video: _html,
                    });
                    this.gotoNextSlideOnVideoEnd(_src, this.core.index);
                    var $tempImg = $el.find('.lg-object').first().get();
                    // @todo make sure it is working
                    $el.find('.lg-video-cont').first().append($tempImg);
                    $el.addClass('lg-video-loading');
                    videoJsPlayer_1 &&
                        videoJsPlayer_1.ready(function () {
                            videoJsPlayer_1.on('loadedmetadata', function () {
                                _this.onVideoLoadAfterPosterClick($el, _this.core.index);
                            });
                        });
                    $el.find('.lg-video-object')
                        .first()
                        .on('load.lg error.lg loadeddata.lg', function () {
                        setTimeout(function () {
                            _this.onVideoLoadAfterPosterClick($el, _this.core.index);
                        }, 50);
                    });
                }
                else {
                    this.playVideo(this.core.index);
                }
            }
        };
        Video.prototype.onVideoLoadAfterPosterClick = function ($el, index) {
            $el.addClass('lg-video-loaded');
            this.playVideo(index);
        };
        Video.prototype.destroy = function () {
            this.core.LGel.off('.lg.video');
            this.core.LGel.off('.video');
        };
        return Video;
    }());

    return Video;

})));
//# sourceMappingURL=lg-video.umd.js.map
