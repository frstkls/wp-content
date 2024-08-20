jQuery(document).ready(function($) {
    var $grid = $('.masonry').masonry({
        itemSelector: '.portfolio-item',
        columnWidth: '.portfolio-item',
        percentPosition: true,
        gutter: 20  // De gutter zorgt voor gelijke spacing
    });
    
    $grid.imagesLoaded().progress(function() {
        $grid.masonry('layout');
    });
});
