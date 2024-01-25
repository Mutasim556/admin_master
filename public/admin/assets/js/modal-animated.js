"use strict";
function testAnim(x) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  modal-xl ' + x + '  animated');
};
var modal_animate_custom = {
    init: function() {
        $('#product-details-modal').on('show.bs.modal', function (e) {
            var anim = 'slideInDown';
            testAnim(anim);
        })
        $('#product-details-modal').on('hide.bs.modal', function (e) {
            var anim = 'slideOutRight';
            testAnim(anim);
        })
        // $("a").tooltip();
    }
};
(function($) {
    "use strict";
    modal_animate_custom.init()
})(jQuery);