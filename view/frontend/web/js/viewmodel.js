define([
    'uiComponent',
    'ko',
    'jquery',
    'mage/url'
], function (Component, ko, $, url) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Cedran_CrudKnockoutjs/grid',
            items: [],
            newItemTitle: '',
            newItemDescription: '',
            addItemFormVisible: false,
            isEdit: false,
            editItemId: null
        },
        initObservable: function () {
            this._super()
                .observe([
                    'items',
                    'newItemTitle',
                    'newItemDescription',
                    'addItemFormVisible',
                    'isEdit',
                    'editItemId'
                ]);

            this.loadItems();
            return this;
        },
        loadItems: function () {
            var self = this;
            $.ajax({
                url: url.build('cedran_crudknockoutjs/item/list'),
                type: 'GET',
                dataType: 'json'
            }).done(function (data) {
                self.items(data.items);
            }).fail(function (response) {
                console.error('Could not load items:', response);
            });
        },
        showAddItemForm: function () {
            this.isEdit(false);
            this.newItemTitle('');
            this.newItemDescription('');
            this.addItemFormVisible(true);
        },
        hideAddItemForm: function () {
            this.addItemFormVisible(false);
        },
        saveItem: function () {
            var self = this;
            var serviceUrl = this.isEdit() ? url.build('cedran_crudknockoutjs/item/edit') : url.build('cedran_crudknockoutjs/item/save');
            var data = {
                item_id: this.editItemId(),
                title: this.newItemTitle(),
                description: this.newItemDescription()
            };

            $.ajax({
                url: serviceUrl,
                type: 'POST',
                dataType: 'json',
                data: data,
                showLoader: true
            }).done(function (response) {
                self.loadItems();
                self.hideAddItemForm();
            }).fail(function (response) {
                console.error('Error saving item:', response);
            });
        },
        editItem: function (item) {
            this.isEdit(true);
            this.editItemId(item.id);
            this.newItemTitle(item.title);
            this.newItemDescription(item.description);
            this.addItemFormVisible(true);
        },
        deleteItem: function (item) {
            var self = this;
            if (!confirm('Are you sure you want to delete this item?')) {
                return;
            }
            $.ajax({
                url: url.build('cedran_crudknockoutjs/item/delete'),
                type: 'POST',
                dataType: 'json',
                data: { item_id: item.id },
                showLoader: true
            }).done(function (response) {
                self.loadItems();
            }).fail(function (response) {
                console.error('Error deleting item:', response);
            });
        }
    });
});
