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

    $(document).render(function () {
        $('.checkboxlist-item a.checkboxlist-item-expand-collapse').off().on('click', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $parent= $this.parent();

            if ($parent.hasClass('open')) {
                closeLevel($parent);
            } else {
                openLevel($parent);
            }
        });

        // Open all action
        $('[data-field-checkboxlist-expand-all]').off().on('click', function (e) {
            e.preventDefault();
            var $this = $(this);

            $this.closest('.field-checkboxlist').find('.checkboxlist-item').each(function () {
                var $this = $(this);
                openLevel($this)
            });



            // Update scrollbar height
            // $('[data-control=scrollbar]').data('oc.scrollbar').update();
            console.log($('[data-control=scrollbar]').data('oc.scrollbar'));
        });

        // Collapse all action
        $('[data-field-checkboxlist-collapse-all]').off().on('click', function (e) {
            e.preventDefault();
            var $this = $(this);

            $this.closest('.field-checkboxlist').find('.checkboxlist-item').each(function () {
                var $this = $(this);
                closeLevel($this)
            });
        });

        // Open selected action
        $('[data-field-checkboxlist-expand-checked]').off().on('click', function (e) {
            e.preventDefault();
            var $this = $(this);

            $this.closest('.field-checkboxlist').find('.checkboxlist-item:has(input:checked)').each(function () {
                var $this = $(this);
                openLevel($this)
            });
        });
    })
}(window.jQuery);



class EnhancedCheckboxList extends Snowboard.PluginBase {
    /**
     * Constructor.
     */
    construct(list) {
        this.list = list;
    }

    listens() {
        return {
            ready: 'ready',
        };
    }

    ready() {
        console.log('ready');
        if (!this.list) {
            return;
        }

        console.log(this.list);
    }
}

// Set up UI scripts
((Snowboard) => {
    Snowboard.addPlugin('EnhancedCheckboxList', EnhancedCheckboxList);

    Snowboard.ready(() => {
        document.querySelectorAll('.field-checkboxlist').forEach((element) => {
            console.log(element);
            Snowboard.EnhancedCheckboxList(element);
        });
    });

})(window.Snowboard);
