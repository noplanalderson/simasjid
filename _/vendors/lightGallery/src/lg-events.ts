import { LightGallery } from './lightgallery';
import { VideoSource } from './plugins/video/types';

/**
 * List of lightGallery events
 * All events should be documented here
 * Below interfaces are used to build the website documentations
 * */
export const lGEvents: {
    [key: string]: string;
} = {
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
 * Fired only once when lightGallery is initialized
 * @name lgInit
 * @method onInit
 * @example
 *   const lg = document.getElementById('custom-events-demo');
 *   // Perform any action on lightGallery initialization.
 *   // Init event returns the plugin instance that can be used to call any lightGalley public method
 *   let pluginInstance = null;
 *   lg.addEventListener('lgInit', (event) => {
 *      pluginInstance = event.detail.instance;
 *   });
 *   lightGallery(lg);
 * @see <a href="/docs/methods">Methods<a>
 */
export interface InitDetail {
    /**
     * lightGallery plugin instance
     */
    instance: LightGallery;
}

/**
 * Fired when the slide content has been inserted into it's slide container.
 * @name lgAfterAppendSlide
 * @method onAfterAppendSlide
 */
export interface AfterAppendSlideEventDetail {
    /**
     * Index of the slide
     */
    index: number;
}

/**
 * Fired immediately before opening the gallery
 * @name lgBeforeOpen
 * @method onBeforeOpen
 */
export interface BeforeOpenDetail {}

/**
 * Fired immediately after opening the gallery
 * @name lgAfterOpen
 * @method onAfterOpen
 */
export interface AfterOpenDetail {}

/**
 * Fired once the media inside the slide has been completely loaded .
 * @name lgSlideItemLoad
 * @method onSlideItemLoad
 */
export interface SlideItemLoadDetail {
    /**
     * Index of the slide
     */
    index: number;
    /**
     * First time when an item is loaded lightGallery adds some delay for showing the completed item
     * to show transition effect on item load
     * Respect the delay when you use this event
     */
    delay: number;
}

/**
 * Fired immediately before each slide transition.
 * @name lgBeforeSlide
 * @method onBeforeSlide
 * @example
 *   const lg = document.getElementById('custom-events-demo');
 *   // Perform any action before each slide transition
 *   lg.addEventListener('lgBeforeSlide', (event) => {
 *       const { index, prevIndex } = event.detail;
 *       alert(index, prevIndex);
 *   });
 *   lightGallery(lg);
 */
export interface BeforeSlideDetail {
    /**
     * Index of the previous slide
     */
    prevIndex: number;
    /**
     * Index of the slide
     */
    index: number;
    /**
     * true if slide function called via touch event or mouse drag
     */
    fromTouch: boolean;
    /**
     * true if slide function called via thumbnail click
     */
    fromThumb: boolean;
}

/**
 * Fired immediately after each slide transition.
 * @name lgAfterSlide
 * @method onAfterSlide
 */
export interface AfterSlideDetail {
    /**
     * Index of the previous slide
     */
    prevIndex: number;
    /**
     * Index of the slide
     */
    index: number;
    /**
     * true if slide function called via touch event or mouse drag
     */
    fromTouch: boolean;
    /**
     * true if slide function called via thumbnail click
     */
    fromThumb: boolean;
}

/**
 * Fired when the video poster is clicked.
 * @name lgPosterClick
 * @method onPosterClick
 */
export interface PosterClickDetail {}

/**
 * Fired when the drag event to move to different slide starts.
 * @name lgDragStart
 * @method onDragStart
 */
export interface DragStartDetail {}

/**
 * Fired periodically during the drag operation.
 * @name lgDragMove
 * @method onDragMove
 */
export interface DragMoveDetail {}

/**
 * Fired when the user has finished the drag operation
 * @name lgDragEnd
 * @method onDragEnd
 */
export interface DragEndDetail {}

/**
 * Fired immediately before the start of the close process.
 * @name lgBeforeClose
 * @method onBeforeClose
 */
export interface BeforeCloseDetail {}

/**
 * Fired immediately once lightGallery is closed.
 * @name lgAfterClose
 * @method onAfterClose
 */
export interface AfterCloseDetail {
    /**
     * lightGallery plugin instance
     */
    instance: LightGallery;
}

/**
 * Fired immediately before each "next" slide transition
 * @name lgBeforeNextSlide
 * @method onBeforeNextSlide
 */
export interface BeforeNextSlideDetail {
    /**
     * Index of the slide
     */
    index: number;
    /**
     * true if slide function called via touch event or mouse drag
     */
    fromTouch: boolean;
}

/**
 * Fired immediately before each "prev" slide transition
 * @name lgBeforePrevSlide
 * @method onBeforePrevSlide
 */
export interface BeforePrevSlideDetail {
    /**
     * Index of the slide
     */
    index: number;
    /**
     * true if slide function called via touch event or mouse drag
     */
    fromTouch: boolean;
}

/**
 * Fired when the sub-html content (ex : title/ description) has been appended into the slide.
 * @name lgAfterAppendSubHtml
 * @method onAfterAppendSubHtml
 */
export interface AfterAppendSubHtmlDetail {
    /**
     * Index of the slide
     */
    index: number;
}

/**
 * Fired when the sub-html content (ex : title/ description) has been appended into the slide.
 * @name lgContainerResize
 * @method onContainerResize
 */
export interface ContainerResizeDetail {
    /**
     * Index of the slide
     */
    index: number;
}

/**
 * Fired when lightGallery detects video slide
 * @name lgHasVideo
 * @method onHasVideo
 */
export interface HasVideoDetail {
    /**
     * Index of the slide,
     */
    index: number;
    /**
     * Video source
     */
    src: string;
    /**
     * HTML5 video source if available
     * <p>
       HTML5 video source = source: {
            src: string;
            type: string;
        }[];
        attributes: HTMLVideoElement;
     * </p>
     */
    html5Video: VideoSource;
    /**
     * True if video has poster
     */
    hasPoster: boolean;

    /**
     * True for first slide
     */
    isFirstSlide: boolean;
}
