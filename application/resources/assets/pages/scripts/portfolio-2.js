(function($, window, document, undefined) {
    'use strict';

    // init cubeportfolio
    $('#js-grid-mosaic').cubeportfolio({
        layoutMode: 'mosaic',
        sortToPreventGaps: true,
        mediaQueries:  [{width: 2000, cols: 5}, {width: 1000, cols: 4}, {width: 700, cols: 1}],
        // mediaQueries: [{
        //     width: 3000,
        //     cols: 500
        // }, {
        //     width: 1500,
        //     cols: 300
        // }, {
        //     width: 1250,
        //     cols: 30
        // }, {
        //     width: 1000,
        //     cols: 20
        // }, {
        //     width: 350,
        //     cols: 1
        // }],
        animationType: 'quicksand',
        gapHorizontal: 0,
        gapVertical: 0,
        gridAdjustment: 'responsive',
        caption: 'zoom',
        displayType: 'sequentially',
        displayTypeSpeed: 100,

        // lightbox
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title',
        lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',
    });
})(jQuery, window, document);
