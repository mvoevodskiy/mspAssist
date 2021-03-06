mspAssist.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'mspassist-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: false,
            hideMode: 'offsets',
            items: [{
                title: _('mspassist_items'),
                layout: 'anchor',
                items: [{
                    html: _('mspassist_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'mspassist-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    mspAssist.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(mspAssist.panel.Home, MODx.Panel);
Ext.reg('mspassist-panel-home', mspAssist.panel.Home);
