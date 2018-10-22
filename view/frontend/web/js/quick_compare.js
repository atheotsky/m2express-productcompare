define(['jquery', 'ko', 'Magento_Ui/js/modal/modal', 'uiComponent', 'domReady!'], function($, ko, modal, Component) {
    'use strict';
    var self;
    return Component.extend({
        defaults: {
            template: 'M2express_ProductCompare/compare'
        },
        productList : ko.observableArray([]),
        productToCompare: ko.observableArray([]),
        initObservable: function () {
            self = this;
            this._super();
            return this;
        },
        openQuickCompareModal:function () {
            var productCompareList = [];
            /*
            var selectedProduct = $('.compare_items:checked').map(function() {
                return this.value;
            }).get().join(', ');
            */
            var selectedProduct = self.productToCompare().map(function(elem){
                return elem.id;
            }).join(",");

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
        },
        openCompareSideBar:function () {

            var options = {
                type: 'slide',
                responsive: true,
                innerScroll: false,
                modalLeftMargin:200,
                title: false,
                buttons: false
            };
            var modal_overlay_element = $('#sidebar-modal');

            var popup = modal(options, modal_overlay_element);

            modal_overlay_element.css("display", "block");

            var modalContainer = $("#sidebar-modal");
            modalContainer.modal('openModal');
        },
        addToCompare:function (item) {
            if(self.productToCompare.indexOf(item) > -1) {
                // Duplicate
            } else {
                self.productToCompare.push(item);
            }
        },
        addToCompareV:function (id, name) {
            if(self.productToCompare().map(function(a) { return a.id; }).indexOf(id) > -1) {
                // Duplicate data
            } else {
                self.productToCompare.push({
                    id: id,
                    name: name
                });
            }
        },
        removeItemCompare: function (item) {
            if(self.productToCompare.indexOf(item) > -1) {
                self.productToCompare.remove(item);
            }
        },
        removeItemCompareV: function (item) {
            //console.log(item);
            if(self.productToCompare().map(function(a) { return a.id; }).indexOf(item.id) > -1) {
                self.productToCompare.remove(function(items) {
                    return items.id === item.id;
                });
            }
        }
    });
});