// ==================================================
// Project Name  :  Prelaoder Extension
// File          :  JS Base
// Version       :  1.0
// Author        :  Codeixer (https://themeforest.net/user/codeixer)
// Developer:    :  Codeixer
// ==================================================

(function ($) {
    "use strict";

    
    $(window).on('load', function () {
        $('#preloader > div,#preloader > img').fadeOut();
        $('#preloader').delay(350).fadeOut();
        $('body').delay(350).css({ 'overflow': 'visible' });
        

    })

})(jQuery);