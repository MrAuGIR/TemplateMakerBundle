pimcore.registerNS("pimcore.plugin.TemplateMakerBundle");

pimcore.plugin.TemplateMakerBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.TemplateMakerBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("TemplateMakerBundle ready!");
    }
});

var TemplateMakerBundlePlugin = new pimcore.plugin.TemplateMakerBundle();
