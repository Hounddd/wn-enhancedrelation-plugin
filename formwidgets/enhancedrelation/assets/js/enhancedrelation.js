/*
 * This is a sample JavaScript file used by EnhancedRelation
 *
 * You can delete this file if you want
 */

+function ($) {
    "use strict";

    function openLevel(el) {
        el.addClass('open');
        el.find('> .checkboxlist-children').addClass('open');
    }

    function closeLevel(el) {
        el.removeClass('open');
        el.find('> .checkboxlist-children').removeClass('open');
    }

    function openAll(elements) {
        elements.each(function () {
            openLevel($(this));
        });
    }

    function closeAll(elements) {
        elements.each(function () {
            closeLevel($(this));
        });
    }

    function updateScollBar() {
        // Update scrollbar height
        // Set a timer for .55s, waiting for the css animation to complete
        setTimeout(function () {
            $('[data-control=scrollbar]').data('oc.scrollbar').update();
        }, 550);
    }

    $(document).render(function () {
        var $checkboxListItems = $('.field-checkboxlist .checkboxlist-item');

        $('.checkboxlist-item a.checkboxlist-item-expand-collapse').off().on('click', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $parent= $this.parent('.checkboxlist-item');

            if ($parent.hasClass('open')) {
                closeLevel($parent);
            } else {
                openLevel($parent);
            }
        });

        // Open all action
        $('[data-field-checkboxlist-expand-all]').off().on('click', function (e) {
            e.preventDefault();

            openAll($checkboxListItems);
            updateScollBar();
        });

        // Collapse all action
        $('[data-field-checkboxlist-collapse-all]').off().on('click', function (e) {
            e.preventDefault();

            closeAll($checkboxListItems);
            updateScollBar();
        });

        // Open selected action
        $('[data-field-checkboxlist-expand-checked]').off().on('click', function (e) {
            e.preventDefault();

            closeAll($checkboxListItems);
            openAll($checkboxListItems.filter(':has(input:checked)'));
            updateScollBar();
        });
    })
}(window.jQuery);
