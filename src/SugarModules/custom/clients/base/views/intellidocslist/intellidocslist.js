({
    className: 'tcenter',
    bLoaded: false,
    arRecords: [],
    strParentModule: "",
    objNotes: {},
    arDocuments : [],
    events: {        
        'click #cancel-merge' : 'onCancel',
        'click #generate-doc' : 'onGenerateDoc',
    },
    loadData: function() {
        // Assign scope        
        var self = this;
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/getdocuments');
        // their attachment handling on email popup
        var objContext = app.drawer._components[0].context;
        // Store the records
        self.arRecords = objContext.get("records");
        self.strParentModule = objContext.get("parent_module");
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),            
            "parent_module" : self.strParentModule
        };
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "GET",
            dataType: "json",
            data: objData,
            headers: {"OAuth-Token": app.api.getOAuthToken()},
            success: function(objResponse) {
                // Do we have any documents?
                if (objResponse != undefined) {
                    console.log(objResponse);
                    // loop through documents
                    $.each(objResponse, function(id,objDocument){
                        // initialise interactive
                        var bInteractive = false;
                        // loop through field maps
                        $.each(objDocument.field_maps, function(idx, strFieldValue) {                                                            
                            // if field map equals to interactive
                            if (strFieldValue == 'interactive') {
                                bInteractive = true;
                            }
                        });   
                        // add to the list
                        self.arDocuments.push({
                            id : objDocument.id,
                            file_name : objDocument.file_name,
                            file_type : objDocument.file_type,
                            is_interactive: bInteractive,
                        })
                    })
                    // Set the documents
                    // self.arDocuments = objResponse;
                    // Loaded
                    self.bLoaded = true;
                    // Re-render
                    self.render();
                }
            },
            error: function(objError, strError, strMessage) {
                // We should have a response text
                if (objError.responseText != undefined) {
                    // Decode
                    var objResponse = $.parseJSON(objError.responseText);
                    // Do we have an error message?
                    if (objResponse.error_message != undefined) {
                        // Indicate error
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: objResponse.error_message,
                            autoClose: true
                        });
                    } else {
                        // Indicate error
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: "An unknown error has occurred",
                            autoClose: true
                        });
                    }
                }
            }
        });
    },
    _render: function() {                
        // assign to local scope
        var self = this;
        // call parent handler
        this._super("_render");
        // Reset the data
        self.objNotes = {};
        // Render select2
        $("#select_document").select2();
        $("#select_format").select2();
    },
    emailFile: function(strNoteId, strDocName) {
        // Assign scope        
        var self = this;
        // Initialize documents
        var arDocs = [];
        // Set the response
        var objOptions = {
            "parent_id": "",
            "parent_name": "",
            "parent_type": "",
            "name": strDocName,
            "description_html": "",
            "to_addresses": "",
            "html_body": "",
            "subject": strDocName,
            "documents": []
        };        
        // Get the document names
        arDocs.push({
            id: strNoteId,
            name: strDocName,
            nameForDisplay: strDocName,
            type: 'template'
        });
        // Set the documents
        objOptions["attachments"] = arDocs;
        // Set the context
        var objContext = {
            create: true,
            prepopulate: objOptions,
            preFillAttachement:true,
            module:'Emails'
        }
        // Open the drawer
        var objOpen = app.drawer.open({
            layout:'compose',
            context: objContext
        });
        // Store the context - it's a hack, but only way we can do it until sugar fixes
        // their attachment handling on email popup
        var objContext = app.drawer._components[1].context;
        // On load, handle the attachments
        _.defer(function () {
            // Do we have attachments?
            if (arDocs.length > 0) {
                // Loop through
                $.each(arDocs, function(strKey, objAttachment) {
                    // Add the attachment
                    objContext.trigger("attachment:add", objAttachment);
                });
            }
        });        
    },
    downloadFile: function(strNoteId) {
        // Download the file
        app.api.fileDownload("rest/v10/Notes/" + strNoteId + "/file/filename?force_download=1&platform=base", {
          error: function(data) {
            app.error.handleHttpError(data, {});
          }
        }, {iframe: self.$el});
    },
    onCancel: function(objEvent) {
        // Prevent default
        objEvent.preventDefault();
        // close the drawer                    
        app.drawer.close();
    },
    onGenerateDoc: function(objEvent) {
        // assign to local scope
        var self = this;
        // Prevent default
        objEvent.preventDefault();
        // cache the event target
        var objTarget = $(objEvent.target);
        // Get the action
        var strAction = objTarget.data("action");
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/generatemulti');
        // their attachment handling on email popup
        var objContext = app.drawer._components[0].context;
        // Get the document id
        var strDocId = $("#select_document").select2("val");
        var strDocName = $('#select_document').select2('data').text;
        // Get the value
        if (strDocId == "") {
            // Indicate error
            app.alert.show('error-message', {
                level: 'error',
                messages: "Please select a document template before proceeding.",
                autoClose: true
            });
            // Nothing further to do
            return false;
        }
        // Do we have an existing doc?
        if (self.objNotes[strDocId] != undefined) {
            // Should we download or email?
            if (strAction == "email") {
                // Send the email
                self.emailFile(self.objNotes[strDocId], strDocName);
            } else {
                // Send the email
                self.downloadFile(self.objNotes[strDocId]);
            }
            // Nothing else to do
            return false;
        }
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "parent_module" : self.strParentModule,
            "intellidocs_id" : strDocId,
            "records" : self.arRecords
        };
        // Store the class
        var strClass = objTarget.find("i:first").attr("class");
        // start loading spin
        objTarget.find("i:first").attr("class", "fa fa-spinner fa-spin icon-spinner icon-spin");
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "POST",
            dataType: "json",
            data: objData,                           
            success: function(objResponse) {
                // Restore the icons
                objTarget.find("i:first").attr("class", strClass);
                // Do we have a note id?
                if (objResponse.success) {
                    // Set the note id
                    self.objNotes[strDocId] = objResponse.note_id;
                    // Should we download or email?
                    if (strAction == "email") {
                        // Send the email
                        self.emailFile(self.objNotes[strDocId], strDocName);
                    } else {
                        // Send the email
                        self.downloadFile(self.objNotes[strDocId]);
                    }
                }
            },
            error: function(objError, strError, strMessage) {
                // Restore the icons
                objTarget.find("i:first").attr("class", strClass);
                // We should have a response text
                if (objError.responseText != undefined) {
                    // Decode
                    var objResponse = $.parseJSON(objError.responseText);
                    // Do we have an error message?
                    if (objResponse.error_message != undefined) {
                        // Indicate error
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: objResponse.error_message,
                            autoClose: true
                        });
                    } else {
                        // Indicate error
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: "An unknown error has occurred",
                            autoClose: true
                        });
                    }
                }
            }
        });        
    },
    emailMergedDocument: function(event){
        // cache the event target
        var objTarget = $(event.target);
        // Assign scope        
        var self = this;
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/getdocumentforemail');
        // their attachment handling on email popup
        var objContext = app.drawer._components[0].context;
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "id" : this.strIntellidocsId,
            "merge_id": self.strRemoteMergeId,
            "format" : objTarget.data("format"),            
            "parent_module" : objContext.get("parent_module"),
            "parent_id" : objContext.get("parent_id")
        };
        // Store the class
        var strClass = $("#idocsEmailIcon").attr("class");
        // start loading spin
        $("#idocsEmailIcon").attr("class", "fa fa-spinner fa-spin icon-spinner icon-spin");
        // Show the progress indicator
        app.alert.show('intellidocs-process', {
            level: 'info',
            messages: "Converting document - this make take a few moments..",
            autoClose: true,                        
        });        
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "POST",
            dataType: "json",
            data: objData,                           
            success: function(objResponse) {
                // Restore the icons
                $("#idocsEmailIcon").attr("class", strClass);
                // Initialize documents
                var arDocs = [];
                // Set the response
                var objOptions = objResponse;
                // Do we have any documents?
                if (objResponse.documents != undefined) {
                    // Loop through each
                    $.each(objResponse.documents, function(intKey, objDoc) {
                        console.log("Doc");
                        console.log(objDoc);
                        // Get the document names
                        arDocs.push({
                            id: objDoc.id,
                            name: objDoc.name,
                            nameForDisplay: objDoc.name,
                            type: 'template'
                        });
                    });
                }
                // Set the documents
                objOptions["attachments"] = arDocs;
                // Set the context
                var objContext = {
                    create: true,
                    prepopulate: objOptions,
                    preFillAttachement:true,
                    module:'Emails'
                }
                // Open the drawer
                var objOpen = app.drawer.open({
                    layout:'compose',
                    context: objContext
                });
                // Store the context - it's a hack, but only way we can do it until sugar fixes
                // their attachment handling on email popup
                var objContext = app.drawer._components[1].context;
                // On load, handle the attachments
                _.defer(function () {
                    // Do we have attachments?
                    if (arDocs.length > 0) {
                        // Loop through
                        $.each(arDocs, function(strKey, objAttachment) {
                            // Add the attachment
                            objContext.trigger("attachment:add", objAttachment);
                        });
                    }
                });
            },
            error: function(objError, strError, strMessage) {
                // Restore the icons
                $("#idocsEmailIcon").attr("class", strClass);
                // We should have a response text
                if (objError.responseText != undefined) {
                    // Decode
                    var objResponse = $.parseJSON(objError.responseText);
                    // Do we have an error message?
                    if (objResponse.error_message != undefined) {
                        // Indicate error
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: objResponse.error_message,
                            autoClose: true
                        });
                    } else {
                        // Indicate error
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: "An unknown error has occurred",
                            autoClose: true
                        });
                    }
                }
            }
        });
    },    
    convertAndDownload: function(event){
        // cache the event target
        var objTarget = $(event.target);
        // Assign scope        
        var self = this;
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/convertdocument');
        // their attachment handling on email popup
        var objContext = app.drawer._components[0].context;
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "id" : this.strIntellidocsId,
            "merge_id": self.strRemoteMergeId,
            "format" : objTarget.data("format"),
            "parent_module" : objContext.get("parent_module"),
            "parent_id" : objContext.get("parent_id")
        };
        // Get the starting class
        var strClass = $("#idocsDownloadIcon").attr("class");
        // start loading spin
        $("#idocsDownloadIcon").attr("class", "fa fa-spinner fa-spin icon-spinner icon-spin");
        // Show the progress indicator
        app.alert.show('intellidocs-process', {
            level: 'info',
            messages: "Converting document - this make take a few moments..",
            autoClose: true,                        
        });         
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "POST",
            dataType: "json",
            data: objData,                           
            success: function(objResponse) {
                // Restore the class
                $("#idocsDownloadIcon").attr("class", strClass);
                // Download the file
                app.api.fileDownload("rest/v10/Notes/" + objResponse.note_id + "/file/filename?force_download=1&platform=base", {
                  error: function(data) {
                    app.error.handleHttpError(data, {});
                  }
                }, {iframe: self.$el});
            },
            error: function(objError, strError, strMessage) {
                // Restore the class
                $("#idocsDownloadIcon").attr("class", strClass);
                // We should have a response text
                if (objError.responseText != undefined) {
                    // Decode
                    var objResponse = $.parseJSON(objError.responseText);
                    // Do we have an error message?
                    if (objResponse.error_message != undefined) {
                        // Indicate error
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: objResponse.error_message,
                            autoClose: true
                        });
                    } else {
                        // Indicate error
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: "An unknown error has occurred",
                            autoClose: true
                        });
                    }
                }
            }
        });
    }
})