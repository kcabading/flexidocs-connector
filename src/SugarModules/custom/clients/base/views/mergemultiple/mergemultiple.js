({
    className: 'mergemultiple',    
    events: {        
        'click #cancel-merge' : 'close',   
        'click #mergeMultipleTemplates' : 'mergeMultipleTemplates',        
    },      
    templateCollection: null, 
    strParentModule : null,
    strParentId: null,      
    strNoteId: '',   
    loadData: function () {        
        // get document template collection
        this.templateCollection = this.context.get('templates');
        console.log(this.templateCollection); 

        // get parent module and id
        this.strParentModule = this.context.get('parent_module');
        this.strParentId = this.context.get('parent_id');       
    },    
    _render: function() {
        // initialize scope
        var self = this;
        // call parent handler
        this._super("_render");  
        // $('#merge_type').select2({width: '300px'});
        // Allow overflow in drawer
        $(".drawer").css("overflow", "scroll");      
    },
    _dispose: function() {
        this._fields = null;
        // Call parent handler
        app.view.View.prototype._dispose.call(this);
    },    
    close: function () {              
        //close the drawer
        app.drawer.close();
    },    
    downloadFile: function(strNoteId) {
        // assign scope
        var self = this;
        // Download the file
        app.api.fileDownload("rest/v10/Notes/" + strNoteId + "/file/filename?force_download=1&platform=base", {
          error: function(data) {
            app.error.handleHttpError(data, {});
          }
        }, {iframe: self.$el});
    },
    mergeMultipleTemplates: function(event){
        // assign to local scope
        var self = this;
        console.log('merging multiple documents');
        // initialise holder
        var arSelectedTemplates = [];
        // get document templates
        var arDocumentTemplates = $('.document-templates');
        // get file type
        // self.strFileType = $('#merge_type').val();
        // console.log(self.strFileType);
        // loop through
        $.each(arDocumentTemplates, function(idc, objEl){
            // check if checked
            if ($(objEl).is(':checked')) {
                // then push to array
                arSelectedTemplates.push($(objEl).val());
            }
        });        
        // if nothing has selected
        if (arSelectedTemplates.length == 0) {
            // return and prompt the user        
            app.alert.show('intellidocs-logger', {
                level: 'error',
                messages: 'Please select at least one document to proceed',
                autoClose: true,                        
            }); 
            // simply return
            return;
        } else {            
            // Get the starting class
            var strClass = $(".mergeMultipleIcon").attr("class");
            // start loading spin
            $(".mergeMultipleIcon").attr("class", "fa fa-spinner fa-spin icon-spinner icon-spin");
            // Generate the REST URL to merge document
            var strUrl = app.api.buildURL('intellidocs/mergemultipledocuments');                        
            // Set up the data
            var objData = {
                "OAuth-Token": app.api.getOAuthToken(),
                "multiple" : true,
                'ids' : arSelectedTemplates,
                "parent_id" : this.strParentId,
                "parent_module" : this.strParentModule,                    
            }; 
            // initialize ajax
            $.ajax({
                url: strUrl,
                type: "POST",
                dataType: "json",
                data: objData,                           
                success: function(objResponse) {
                    // String response?
                    if (typeof(objResponse) == "string") {
                        // Decode
                        objResponse = $.parseJSON(objResponse);                    
                    }
                    console.log(objResponse);
                    // if one document is partially signed
                    if (objResponse.cancel_signing || objResponse.partially_signed) {
                        // assign default class
                        $("#mergeMultipleTemplates i").attr('class', strClass);
                        // if merge fail, indicate error
                        app.alert.show('intellidocs-logger', {
                            level: 'error',
                            messages: 'One ore more selected document is currently on signature process. Complete or cancel the signature process to continue',
                            autoClose: true,                        
                        });                                                 
                    } else if (!objResponse) {
                        // assign default class
                        $("#mergeMultipleTemplates i").attr('class', strClass);
                        // indicate error
                        app.alert.show('intellidocs-logger', {
                            level: 'error',
                            messages: 'Error Merging Documents',
                            autoClose: true                                
                        });
                        // close the drawer                    
                        self.close();
                    } else {                    
                        // assign default class
                        $("#mergeMultipleTemplates i").attr('class', strClass);
                        // indicate success
                        app.alert.show('intellidocs-logger', {
                            level: 'success',
                            messages: 'Success fully merged the selected documents',
                            autoClose: true                                
                        });
                        console.log('SENT FOR SIGNING');
                        console.log(objResponse);
                        // Open the layout for sending to signature in a drawer
                        app.drawer.open({
                            layout: 'electronicsign',
                            // pass data
                            context: {  
                                        id : objResponse.document_id,
                                        record_id : objResponse.record_id,
                                        merge_id :objResponse.merge_id,
                                        name : objResponse.merge_name, 
                                        file_type : 'DOCX',              
                                        parent_module: self.strParentModule,                                        
                                        parent_id: self.strParentId,                        
                                        bAlreadyMerged : true,
                                        enable_lob : objResponse.enable_lob,
                                        doc_event_id : objResponse.doc_event_id,
                                        no_of_signers : objResponse.no_of_signers,
                                        default_signers : objResponse.default_signers,
                                        default_signers_init: objResponse.default_signers_init,
                                        default_addresses: objResponse.default_addresses,
                                        output_format_pdf: objResponse.output_format_pdf,
                                        output_format_orig: objResponse.output_format_orig,
                                        allow_email: objResponse.allow_email,
                                        allow_download: objResponse.allow_download                                        
                                    }                          
                        });
                        // // Set the note id
                        // self.strNoteId = objResponse.note_id;                                                
                        // // Download file
                        // self.downloadFile(self.strNoteId);                        
                    }            
                }
            });            
        }        
    }
})

