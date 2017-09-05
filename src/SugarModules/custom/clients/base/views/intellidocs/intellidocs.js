/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Views.Base.RecordView
 * @alias SUGAR.App.view.views.BaseRecordView
 * @extends View.View
 */
({

    /**
     * Intellidocs record object
     */
    objIntellidocs : {},
    /**
     *
     */
    arStatusList : [],
    /**
     * Get the intellidocs record and the related timeline which are saved as notes
     */
    loadData: function(){
        // assign to local scope
        var self = this;
        // Generate the REST URL for getting the Intellidoc document and timeline events
        var strUrl = app.api.buildURL('intellidocs/getrecord');
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),            
            "id" : this.model.get('id')
        };
        // get the language of the intellidocs status
        this.arStatusList = App.lang.getAppListStrings('document_status_list');             
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "GET",
            dataType: "json",
            data: objData,
            headers: {"OAuth-Token": app.api.getOAuthToken()},  
            success: function(objResponse) {
                console.log(objResponse);
                // String response?
                // if (typeof(objResponse) == "string") {
                //     // Decode
                //     objResponse = $.parseJSON(objResponse);                    
                // }                
                // // if success
                if(objResponse){        
                    console.log('success render');
                    // set intellidocs id
                    self.objIntellidocs = objResponse;
                    // render
                    self.render();
                }                                                
            }
        }); 
    },
    _render: function() {                
        // call parent handler
        this._super("_render");              
        // set the select2 field
        $('#documentstatus').select2({allowClear:true, width: '200px'});
    },

})
