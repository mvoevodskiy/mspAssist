mspAssist.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'mspassist-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('mspassist_item_create'),
        width: 550,
        autoHeight: true,
        url: mspAssist.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    mspAssist.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(mspAssist.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('mspassist_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('mspassist_item_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('mspassist_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('mspassist-item-window-create', mspAssist.window.CreateItem);


mspAssist.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'mspassist-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('mspassist_item_update'),
        width: 550,
        autoHeight: true,
        url: mspAssist.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    mspAssist.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(mspAssist.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('mspassist_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('mspassist_item_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('mspassist_item_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('mspassist-item-window-update', mspAssist.window.UpdateItem);