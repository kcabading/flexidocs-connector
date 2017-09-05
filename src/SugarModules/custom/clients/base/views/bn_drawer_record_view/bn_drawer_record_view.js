/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2014 SugarCRM Inc.  All rights reserved.
 */
({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
        //extend the record view definition, so we include actions and the module specific fields.
        this.meta = _.extend({}, app.metadata.getView(this.module, 'record'), this.meta);
    },
    _renderHtml: function(ctx, options){
        this._super('_renderHtml', [ctx, options]);
        var self = this;
        closeButton = $('<a class="btn btn-primary" href="javascript:void(0);" name="close_drawer">Close</a>');
        closeButton.click(function() { $('.row-fluid').show(); app.drawer.close();});
        toolbar = $('#drawers div.headerpane div.btn-toolbar');
        toolbar.prepend(closeButton);
   }
});
