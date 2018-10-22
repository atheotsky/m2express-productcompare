define(['jquery', 'ko', 'Magento_Ui/js/modal/modal', 'uiComponent', 'domReady!'], function($, ko, modal, Component) {
    'use strict';
    var self;
    return Component.extend({
        defaults: {
            template: 'M2express_ProductCompare/compare'
        },
        productList : ko.observableArray([]),
        initObservable: function () {
            self = this;
            this._super();
            return this;
        },
        openQuickCompareModal:function () {
            var productCompareList = [];
            var selectedProduct = $('.compare_items:checked').map(function() {
                return this.value;
            }).get().join(', ');
            $.ajax(
                {
                    type:'GET',
                    url:'/rest/V1/product-compare/items/' + selectedProduct,
                    data: null,
                    dataType: 'json',
                    success: function(data){
                        $.each(data, function(index, product) {
                            productCompareList.push(product);
                        });
                        self.productList(productCompareList);
                        var options = {
                            type: 'popup',
                            responsive: true,
                            innerScroll: false,
                            title: false,
                            buttons: false
                        };

                        var modal_overlay_element = $('#quickcompare-modal');

                        var popup = modal(options, modal_overlay_element);

                        modal_overlay_element.css("display", "block");

                        var modalContainer = $("#quickcompare-modal");
                        modalContainer.modal('openModal');
                    }
                }
            );
        },
        onSelectedCheckbook: function (item) {
            return item;
        }
    });
});