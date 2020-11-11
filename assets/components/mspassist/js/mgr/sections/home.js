mspAssist.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'mspassist-panel-home',
            renderTo: 'mspassist-panel-home-div'
        }]
    });
    mspAssist.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(mspAssist.page.Home, MODx.Component);
Ext.reg('mspassist-page-home', mspAssist.page.Home);