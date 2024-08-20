jQuery(document).ready(function($) {
    Fancybox.bind("[data-fancybox]", {
        caption: function (fancybox, carousel, slide) {
            return slide.caption || '';
        },
        on: {
            reveal: (fancybox, slide) => {
                if (slide.$caption) {
                    slide.$caption.classList.add('fancybox__caption');
                }
            }
        }
    });
});
