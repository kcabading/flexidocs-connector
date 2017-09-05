({
    className: 'configureintellidocs',
    events: {
        'click #saveIntelliDocsSettings': 'saveConfiguration',
        'click #cancel': 'cancel'              
    },     
    objSetting: "",        
    loadData: function () {
        // assign scope
        var self = this;
        // initialize url
        var strUrl = app.api.buildURL('intellidocs/getsettings');
        // setup data
        var objData = {
                "OAuth-Token": app.api.getOAuthToken(),                 
        };
        // var self = this;
        $.ajax({
                url: strUrl,
                type: "GET",
                dataType: "json",
                data: objData,
                headers: {"OAuth-Token": app.api.getOAuthToken()},
                success: function(objResponse) {
                    console.log(objResponse)
                    // String response?
                    if (typeof(objResponse) == "string") {
                        // Decode
                        objResponse = $.parseJSON(objResponse);
                    }           
                    // assign to current object
                    self.objSetting = objResponse;
                    // render
                    self.render();
                    // if config found                                       
                }
        });       
    },
    _render: function() {
        // call parent handler
        this._super("_render");                       
    },
    _dispose: function() {
        this._fields = null;
        app.view.View.prototype._dispose.call(this);
    },
    saveConfiguration: function (event) {
        // Don't follow any forms
        event.preventDefault();  
        // spin icon
        $("#saveIntelliDocsSettings i").attr("class", "icon-spinner icon-spin fa fa-spinner fa-spin");
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/validatelicense');
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "intellidocs_license_key" : $('#intellidocs_license_key').val(),            
        };            
        console.log(objData);        
        // return;
        // assign scope
        var self = this;
        // Get the list of documents
        $.ajax({
            url: strUrl,
            type: "POST",
            dataType: "json",
            data: objData,
            success: function(objResponse) {
                console.log(objResponse);
                // String response?
                if (typeof(objResponse) == "string") {
                    // Decode
                    objResponse = $.parseJSON(objResponse);
                }           
                // if error occured
                if (objResponse["error"]){
                    app.alert.show('activity-logger', {
                            level: 'error',
                            messages: objResponse["error"],
                            autoClose: false
                        });
                    // stop spin icon
                    $("#saveIntelliDocsSettings i").attr("class", "icon-ok-circle fa fa-check");
                    // simply return
                    return;
                } else {        
                    //indicate success
                    app.alert.show('activity-logger', {
                        level: 'success',
                        messages: objResponse['success'],
                        autoClose: true
                    });
                    // stop spin icon
                    $("#saveIntelliDocsSettings i").attr("class", "icon-ok-circle fa fa-check");
                    //Success - close the drawer
                    app.drawer.close();
                }
            }
        });           
        
    },
    cancel: function () {
        // go back to admin
        history.back();
    },

})