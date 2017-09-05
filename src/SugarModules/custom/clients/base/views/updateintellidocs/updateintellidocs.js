({
    className: 'updateintellidocs',
    events: {
        'click #updateDocuments': 'updateDocuments',
        'click #cancel': 'cancel'              
    },     
    strLastUpdated: false,        
    loadData: function () {
        // assign scope
        var self = this;
        // initialize url
        var strUrl = app.api.buildURL('intellidocs/getlastsync');
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
                    // assign last updated value
                    self.strLastUpdated = objResponse;
                    // render
                    self.render();
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
    updateDocuments: function (event) {
        // Don't follow any forms
        event.preventDefault();  
        // spin icon
        $("#updateDocuments i").attr("class", "icon-refresh icon-spin fa fa-refresh fa-spin");
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/updatedocuments');
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),               
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
                // if error occured
                if (objResponse){
                    //indicate success
                    app.alert.show('activity-logger', {
                        level: 'success',
                        messages: 'Successfully Sync Documents',
                        autoClose: true
                    });                    
                    // stop spin icon
                    $("#updateDocuments i").attr("class", "icon-refresh fa fa-refresh");
                    // assign last updated value
                    self.strLastUpdated = objResponse;
                    // render
                    self.render();                    
                } else {
                    // Indicate error
                    app.alert.show('activity-logger', {
                            level: 'error',
                            messages: "Error occured. Please validate your connection in IntelliDocs",
                            autoClose: false
                        });
                    // stop spin icon
                    $("#updateDocuments i").attr("class", "icon-refresh fa fa-refresh");
                    // simply return
                    return;                                      
                }
            }
        });                   
    },
    cancel: function () {
        // go back to admin
        history.back();
    },

})