var mspAssist = function (config) {
    config = config || {};
    mspAssist.superclass.constructor.call(this, config);
};
Ext.extend(mspAssist, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('mspassist', mspAssist);

mspAssist = new mspAssist();