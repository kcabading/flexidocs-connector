({
    className: 'electronicsign tcenter',
    strDocEventId: "",
    strIntellidocsId: "",
    strRemoteMergeId: "",
    strFileType: "",
    arDefaultContacts: [],
    strDefaultContacts: "",
    arDefaultAddresses: [],
    intNoOfSigners: 0,
    bLoaded: false,
    objInteractiveFields: {},
    strCurrentView : "",
    bCalculateFirst : 1,
    arCountryCode : [],
    strDocumentName: '',
    intLobEnabled: 0,
    bAllowDownload: true,
    bAllowEmail: true,    
    bMultiple: false,
    events: {        
        'click #send-for-esign' : 'sendForEsign',
        'click #cancel-for-esign' : 'cancelForEsign',        
        'click #close-panel' : 'cancelForEsign',
        'click #cancel-merge' : 'cancelForEsign',
        'switchChange.bootstrapSwitch #send_for_signing' : 'hideSendButton',
        'click .convert-merged-document' : 'convertAndDownload',
        'click .email-merged-document' : 'emailMergedDocument',
        'click #submitInteractiveFields' : '_continueToMerge',
        'change .interactive' : '_removeRequired',
        'click .mail-document' : '_openMailingModal'
    },
    _changeMailingAddress: function(event){        
        // assign local scope
        var self = this;
        // get the selected mailing address
        var strSelectedAddress = $('#default-addresses').val();        
        // change the deafult value of each mailing address input
        $('#address_line1').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_street']);
        $('#address_city').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_city']);
        $('#address_state').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_state']);
        $('#address_zip').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_postalcode']);
        $("#address_country").select2({width:'100%'}).select2("val", self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_country']);
        // $('#address_country').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_country']);
    },
    _sendToAddress: function() {        
        // assign scope
        var self = this;
        // cache the value of address1 and country
        var strAddress1 = $('#address_line1').val();
        var strAddress2 = $('#address_line2').val();
        var strCity = $('#address_city').val();
        var strState = $('#address_state').val();
        var strZip = $('#address_zip').val();
        var strCountry = $('#address_country').val();
        // if empty
        if (!strAddress1) {
            // return error
            app.alert.show('intellidocs-logger', {
                level: 'error',
                messages: 'Please enter a value for Address Line 1.',
                autoClose: false,                        
            });
            //
            return;
        }
        // if country is US, 
        if (strCountry == 'US') {
            // city state and zip code are required.
            if (!strCity || !strState || !strZip)
            {
                // return error
                app.alert.show('intellidocs-logger', {
                    level: 'error',
                    messages: 'Please enter a value for City, State and Zip Code.',
                    autoClose: false,                        
                });
                //
                return;
            }
        }
        // cache all addresses
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "intellidocs_id": this.strIntellidocsId,                           
            "merge_id": this.strRemoteMergeId,
            "parent_module" : this.strParentModule,                
            "parent_id" : this.strParentId,
            'addresses' : {
                'address_line1' : strAddress1,
                'address_line2' : strAddress2,
                'address_city' : strCity,
                'address_state' : strState,
                'address_zip' : strZip,
                'address_country' : strCountry                
            },
            'description' : $('#letter_description').val(),
            'print_type' : $('input[type=radio][name=print_type]:checked').val(),
            'double_sided' : $('input[type=radio][name=double_sided]:checked').val(),
            'calculate_first' : self.bCalculateFirst
        }
        // disable button
        $("#send-to-address").attr("disabled", 'disabled');
        // start loading spin
        $("#send-to-address i").attr("class", "fa fa-refresh fa-spin icon-refresh icon-spin");        
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/sendtomailingaddress');
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
                // if error occured
                if (objResponse.error) {
                    // if merge fail, indicate error
                    app.alert.show('intellidocs-logger', {
                        level: 'error',
                        messages: objResponse.error,
                        autoClose: false,                        
                    });
                    // restore class
                    $("#send-to-address i").attr("class", 'icon-envelope fa fa-envelope');  
                    $("#send-to-address").removeAttr("disabled");                
                } else if (objResponse.total) {
                    // if we have total amount, show prompt
                    app.alert.show('flexidocs-logger', {
                        level: 'confirmation',
                        messages: 'The total cost to send this letter is $' + objResponse.total + '. Would you like to continue?',
                        autoClose: false,
                        onConfirm: function(){
                            // set calculate first flag
                            self.bCalculateFirst = 0;
                            // call function again
                            self._sendToAddress();
                        },
                        onCancel: function(){
                            // cancel
                            $("#send-to-address i").attr("class", 'icon-envelope fa fa-envelope');  
                            $("#send-to-address").removeAttr("disabled");  
                        }
                    });
                } else {
                    // change the button and disable
                    $("#send-to-address").attr("disabled", 'disabled');
                    $("#send-to-address").html("<i class='icon-check fa fa-check' ></i> Sent");
                    // close the mailing modal
                    $('#mailingModal').modal('hide');
                    // show success
                    app.alert.show('intellidocs-logger', {
                        level: 'success',
                        messages: objResponse.success,
                        autoClose: false,                        
                    });
                }                
            },
            error: function(objError, strError, strMessage) {
                
            }
        });
    },
    _verifyMailingAddress: function(){
         // assign scope
        var self = this;
        // cache all addresses
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            'addresses' : {
                'address_line1' : $('#address_line1').val(),
                'address_line2' : $('#address_line2').val(),
                'address_city' : $('#address_city').val(),
                'address_state' : $('#address_state').val(),
                'address_zip' : $('#address_zip').val(),
                'address_country' : $('#address_country').val()
            }
        }
        // start loading spin
        $("#verify-address i").attr("class", "fa fa-refresh fa-spin icon-refresh icon-spin");        
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/verifymailingaddress');
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
                // if error occured
                if (objResponse.error) {
                    // if merge fail, indicate error
                    app.alert.show('intellidocs-logger', {
                        level: 'error',
                        messages: objResponse.error,
                        autoClose: true,                        
                    });
                    // restore class
                    $("#verify-address i").attr("class", 'icon-refresh fa fa-refresh');
                } else {
                    // change the class
                    $("#verify-address i").attr("class", 'icon-check fa fa-check');
                    // show success
                    app.alert.show('intellidocs-logger', {
                        level: 'success',
                        messages: objResponse.success,
                        autoClose: true,                        
                    });
                }                
            },
            error: function(objError, strError, strMessage) {
                
            }
        });
    },
    _openMailingModal: function(event){
        // assig scope
        var self = this;
        event.preventDefault();        
        // check if modal exist as a direct child on body element
        if ($('body').children('#mailingModal').length == 0 ) {
            // add first to body and open
            $('#mailingModal').appendTo("body");
        }
        // set calculate first to true;
        self.bCalculateFirst = 1;
        // open modal
        $('#mailingModal').modal('show');
        // attach event for verifying and sending to address
        $('#verify-address').on('click', self._verifyMailingAddress);
        $('#send-to-address').on('click', self._sendToAddress.bind(self) );   
        // attach event when address is change
        $('#default-addresses').on('change',self._changeMailingAddress.bind(self));
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
                var objContext = app.drawer._components[app.drawer._components.length - 1].context;                
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
        // var objContext = app.drawer._components[0].context;
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "id" : this.strIntellidocsId,
            "merge_id": self.strRemoteMergeId,
            "format" : objTarget.data("format"),
            "parent_module" : self.strParentModule,
            "parent_id" : self.strParentId
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
                app.api.fileDownload("rest/v10/" + objResponse.download_from_module + "/" + objResponse.file_id + "/file/uploadfile?force_download=1&platform=base", {
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
    },
    hideSendButton: function(){
        // if switch
        if($("#send_for_signing").is(":checked")){
            // show
            $("#send-for-esign").show();
        } else {
            // hide
            $("#send-for-esign").hide();
        }
    },   
    objFileDetails: {},
    strParentModule: "",
    strParentId: "",    
    strIntellidocsId : '',
    strDocEventId: '',    
    bDirectSigning: false,
    bOutputOrig: false,
    bOutputPdf: false,    
    loadData: function(event) {        
        // Assign scope        
        var self = this;        
        // assign interactive fields
        var arInteractiveFields = this.context.get('interactive_fields');           
        // assign passed data to current object 
        this.strIntellidocsRecordId = this.context.get('record_id');
        this.strIntellidocsId = this.context.get("id");
        // get the document model
        this.strIntellidocsName = this.context.get("name");
        this.strParentModule = this.context.get("parent_module");        
        this.strParentId = this.context.get("parent_id");        
        this.bAlreadyMerged = this.context.get('bAlreadyMerged'); 
        this.strFileType = this.context.get('file_type');
        this.bAllowDownload = this.context.get('allow_download') ? true: false; 
        this.bAllowEmail =  this.context.get('allow_email') ? true : false;
        this.bOutputPdf = this.context.get('output_format_pdf') ? true: false; 
        this.bOutputOrig = this.context.get('output_format_orig') ? true: false;        
        this.bDirectSigning = this.context.get('bDirectSigning');
        // get the country code
        this.arCountryCode = app.lang.getAppListStrings('country_code');
        // then concatenate it to the file name
        this.emailSubject = this.strIntellidocsName;        
        // if already merged
        if (!this.bAlreadyMerged ) {
            // if we dont have interactive fields
            if (_.isEmpty(arInteractiveFields) ) {
                // set the view to merge and sign
                this.strCurrentView = 'merge-and-sign';
                // merge Document
                this._mergeDocument();
                
            } else {
                // if we get here, we have interactive fields. Loop through
                $.each(arInteractiveFields, function(idx, strValue){
                    // split variable
                    var arSplittedVar = strValue.split('|');                
                    // add to object variable
                    self.objInteractiveFields[strValue] = {
                        is_required: (arSplittedVar[1] == 'req')? true : false,
                        field : arSplittedVar[2],
                        name : arSplittedVar[3],
                        label: arSplittedVar[4],
                        value: '',
                        options: ''
                    };
                    // if field type is dropdown
                    if (arSplittedVar[2] == 'dropdown') {
                        // split the options and add
                        self.objInteractiveFields[strValue].options = arSplittedVar[5].split(',');
                    }
                })
                // set view
                this.strCurrentView = 'interactive';
            }
        } else {                        
            // set the view to merge and sign
            this.strCurrentView = 'merge-and-sign';
            // assign
            this.intLobEnabled = this.context.get("enable_lob");
            // set doc event id
            this.strDocEventId = this.context.get("doc_event_id");                    
            // Store the number of signers
            this.intNoOfSigners = this.context.get("no_of_signers");
            // Set the default signers
            this.arDefaultContacts = this.context.get("default_signers");
            // Initialize default signers
            this.strDefaultContacts = this.context.get("default_signers_init");            
            // set default addresses
            this.arDefaultAddresses = this.context.get("default_addresses"); 
            // Store the merge id
            this.strRemoteMergeId = this.context.get("merge_id");
            // Indicate that we're loaded
            this.bLoaded = true;            
            // show
            $("#signing_details").show();

        }
        // remove any custom modal
        $('.flexidocs-modal').remove();
    },
    _mergeDocument: function(){        
        // assign scope
        var self = this;
        // Generate the REST URL to merge document
        var strUrl = app.api.buildURL('intellidocs/mergedocument');
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "id" : this.strIntellidocsId,             
            "parent_id" : this.strParentId,
            "parent_module" : this.strParentModule,   
            "interactive_fields" : this.objInteractiveFields            
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
                // if cancel signing
                if (objResponse.cancel_signing) {
                    // show confirm prompt
                    app.alert.show('intellidocs-cancel-signing', {
                        level: 'confirmation',
                        messages: objResponse.cancel_signing,
                        autoClose: false,
                        onConfirm: function(){
                            // cancel signing
                            self.cancelSigning(objResponse);
                        },
                        onCancel: function(){
                            // close the drawer                    
                            app.drawer.close();
                        }
                    });
                // else if partially signed
                } else if (objResponse.partially_signed) {
                    // if merge fail, indicate error
                    app.alert.show('intellidocs-logger', {
                        level: 'error',
                        messages: objResponse.partially_signed,
                        autoClose: true,                        
                    }); 
                    // error - close the drawer                    
                    app.drawer.close();
                // else success
                } else if (objResponse.success) {
                    // Indicate that we're loaded
                    self.bLoaded = true;
                    // set intellidocs id
                    self.strIntellidocsRecordId = objResponse.intellidocs_id;                    
                    // set signature type
                    self.strSignatureType = objResponse.signature_type;
                    // set doc event id
                    self.strDocEventId = objResponse.doc_event_id;
                    // Store the merge id
                    self.strRemoteMergeId = objResponse.merge_id;
                    // Store the number of signers
                    self.intNoOfSigners = objResponse.no_of_signers;
                    // Set the default signers
                    self.arDefaultContacts = objResponse.default_signers;
                    // Initialize default signers
                    self.strDefaultContacts = objResponse.default_signers_init;
                    // set default addresses
                    self.arDefaultAddresses = objResponse.default_addresses;
                    // set lob enabled flag
                    self.intLobEnabled = objResponse.enable_lob;
                    // set allow email
                    self.bAllowEmail = objResponse.allow_email;
                    self.bAllowDownload = objResponse.allow_download;                    
                    self.bOutputPdf = objResponse.output_format_pdf;
                    self.bOutputOrig = objResponse.output_format_orig;
                    self.strFileType = objResponse.file_type;                    
                    // set document name
                    self.strDocumentName = objResponse.document_name;
                    // Re-render
                    self.render();
                } else {
                    // if merge fail, indicate error
                    app.alert.show('intellidocs-logger', {
                        level: 'error',
                        messages: objResponse.error,
                        autoClose: true,                        
                    }); 
                    // error - close the drawer                    
                    app.drawer.close();
                } 
            },
            error: function(objResponse) {                
                // if merge fail, indicate error
                app.alert.show('intellidocs-logger', {
                    level: 'error',
                    messages: objResponse.error,
                    autoClose: true,                        
                });
                // error - close the drawer                    
                app.drawer.close();
            }
        });
    },
    _removeRequired: function(event){        
        // remove field-required class
        $(event.target).removeClass('field-required');
    },
    _continueToMerge: function(event){
        // assign scope
        var self = this;        
        // prevent default action
        event.preventDefault();
        // get all interactive fields
        var arInteractiveFields = $('.interactive');                    
        // loop through fields
        $.each(arInteractiveFields, function(idx, objElement){
            // get the interactive field string
            var strInteractiveField = $(objElement).data('interactive');            
            // determine the input type
            if ($(objElement).attr('type') == 'text' || $(objElement).is('textarea') || $(objElement).is('select')) {
                // validate if field is required
                if (self.objInteractiveFields[strInteractiveField].is_required && _.isEmpty($(objElement).val()) ) {
                    // assign required class
                    $(objElement).addClass('field-required');
                }
                // get the value of the input and assign
                self.objInteractiveFields[strInteractiveField].value = $(objElement).val();                    
            } else if ($(objElement).attr('type') == 'checkbox') {
                // get the value of the input and assign
                self.objInteractiveFields[strInteractiveField].value = ($(objElement).is(':checked')) ? 1 : 0;
            }   
        });
        // return if we miss required fields?
        if($('.field-required').size() > 0 ) return;
        // set current view to merge-and-sign
        this.strCurrentView = 'merge-and-sign';
        // render partial view        
        this.renderPartialTemplate(this.strCurrentView,'merge-and-sign-container');
        // merge document
        this._mergeDocument();
    },
    _render: function() {                        
        // assign to local scope
        var self = this;
        // call parent handler
        this._super("_render");        
        // render current view
        this.renderPartialTemplate(this.strCurrentView,'merge-and-sign-container');        
        // initialise datepicker
        $('.datepicker').datepicker({format: (app.date.getUserDateFormat()).toLowerCase() }).on('changeDate', function (e) {
            // remove required on date select
            self._removeRequired(e);
        });
        // set the letter description field to the document name
        $('#letter_description').val(this.strDocumentName);
        // initialise select2
        $('.select2-field').select2({width:'100%'});
        // Initialize Switch
        $("#send_for_signing, #sign_each_location").bootstrapSwitch();                    
        // Set up in person signing
        $("#in_person_signing").bootstrapSwitch();                    
        // change event
        $('input[name="send_for_signing"]').on("switchChange.bootstrapSwitch", function(event,state) {
            // Determine the state
            if (state) {
                // show
                $("#signing_details").show();
            } else {
                // hide
                $("#signing_details").hide();
            }
        });
        // change event
        $('input[name="in_person_signing"]').on("switchChange.bootstrapSwitch", function(event,state){
            // Determine the state
            if (state){
                // show
                $("#emailSection").hide();                            
            } else {
                // hide
                $("#emailSection").show();                            
            }
        });
        // Set up select dropdowns
        $("#contactList").select2({
            initSelection : function (element, callback) {
                // Set the data
                callback(self.arDefaultContacts);
            },
            ajax: {
                transport: function (params) {                    
                    // build url
                    var strUrl = app.api.buildURL('intellidocs','searchcontactsusers', null, { "search" : params.data.search });
                    // initialise api call
                    var request = app.api.call('read', strUrl, null, {     
                        success: function (data) {                            
                            params.success(data);
                            // success(data);
                        },
                        error: function(err) {                            
                            params.error(err)
                        }
                    });                    
                },
                // url: app.api.buildURL('intellidocs/searchcontactsusers'),
                dataType: 'json',
                delay: 250,
                data: function(strFilter) {
                    return {
                        // "OAuth-Token": app.api.getOAuthToken(),
                        "search": strFilter
                    };
                },
                results: function (data, params) {                    
                  // parse the results into the format expected by Select2
                  // since we are using custom formatting functions we do not need to
                  // alter the remote JSON data, except to indicate that infinite
                  // scrolling can be used
                  params.page = params.page || 1;
             
                  return {
                    results: data.items,
                    pagination: {
                      more: (params.page * 30) < data.total_count
                    }
                  };
                },
                cache: true
            },
            minimumInputLength: 1,
            multiple: true
        });
    },
    _dispose: function() {
        this._fields = null;
        app.view.View.prototype._dispose.call(this);
    },
    sendForEsign: function(){                
        // Assign scope
        var self = this;
        // Ensure that we have at least 1 value
        if ( $('#contactList').select2('data').length != self.intNoOfSigners && $('#contactList').is(':visible') ) {
            // Indicate error
            app.alert.show('activity-logger', {
                level: 'error',
                messages: 'This document requires ' + self.intNoOfSigners + ' signers',
                autoClose: true
            });                 
            // simply return
            return;
        } else {
            // start loading spin
            $("#send-for-esign i").attr("class", "fa fa-spinner fa-spin icon-spinner icon-spin");
            // Generate the REST URL
            var strUrl = app.api.buildURL('intellidocs/sign');
            // Set up the data
            var objData = {
                "OAuth-Token": app.api.getOAuthToken(),
                "intellidocs_id": self.strIntellidocsId,                
                "doc_event_id" : self.strDocEventId,
                "merge_id": self.strRemoteMergeId,
                "parent_module" : self.strParentModule,                
                "parent_id" : self.strParentId,                
                "email_subject": $("#emailSubject").val(),
                "email_body": $("#emailBody").val(),
                "related_contacts": $('#contactList').val(),                
                "in_person": ($("#in_person_signing").is(":checked") ? "1" : "0"),
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
                    // Do we have an error?
                    if (objResponse.error) {
                        //indicate error
                        app.alert.show('intellidocs-logger', {
                            level: 'error',
                            messages: objResponse.error.replace(/\</g,'&lt;').replace(/\>/g, '&gt;'),
                            autoClose: false
                        });
                    } else {                        
                        // Is this an in person URL?
                        if ((objResponse.url != undefined) && (objResponse.url != "")) {
                            // Show the image
                            $("#maincontent").hide();
                            // Set the url
                            $("#url").after("<td style='width:320px'><img src='https://console.flexidocs.co/generateqrcode/" + objResponse.user_id + "/" + objResponse.id + "/" + objResponse.signature_id + "' ></td>");
                            // Set the signing url
                            $("#url_link").after("<td><a href='" + objResponse.url + "' target='_blank'>Click Here to Begin Signing</a> </td>");                            
                            // Show the image
                            $("#urlimage").show();                           
                        } else {
                            // indicate success
                            app.alert.show('intellidocs-logger', {
                                level: 'success',
                                messages: 'Successfully sent the document for signing',
                                autoClose: true                                
                            });
                            // //Success - close the drawer
                            app.drawer.close(); 
                            // refresh   
                            app.router.refresh()                   
                        }
                    }                        
                    // close loading
                    $("#send-for-esign i").attr("class", "fa fa-check icon-ok-circle");
                },
                error: function(objError) {
                    //indicate error
                    app.alert.show('intellidocs-logger', {
                        level: 'error',
                        messages: objResponse.error,
                        autoClose: false
                    });
                    //Success - close the drawer
                    app.drawer.close(); 
                    // refresh   
                    app.router.refresh()     
                }
            });                
        }              
    },
    cancelForEsign: function() {        
        // close drawer section
        app.drawer.close();
        // refresh
        app.router.refresh()
    },
    /**
     * Cancel Electronic Signing     
     */
    cancelSigning: function(objIntellidocs) {
        // assign scope
        var self = this;
        // initialise url for deletion
        var strUrl = app.api.buildURL('intellidocs/cancelsigning');                                            
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            'id': objIntellidocs.id,            
        };        
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "POST",
            dataType: 'json',
            data: objData,
            success: function(objResponse) {                                                                   
                // if success
                if (objResponse) {
                    // if cancel is success, re-merge
                    self.loadData()                    
                } else {
                    // if delete fail
                    app.alert.show('intellidocs-logger', {
                        level: 'error',
                        messages: 'Error deleting record',
                        autoClose: true                                
                    }); 
                    // // refresh route
                    // app.router.refresh();         
                }        
            }                                        
        });             
    },
    /**
     * Render Partial template
     */
    renderPartialTemplate: function (strTarget, strElement) {
        // pass to loca vars
        var self = this;        
        // do we have this target on the partial list
        if (!_.isUndefined(app.template.getView("electronicsign." + strTarget))) {
            // compile source data
            var template = app.template.getView("electronicsign." + strTarget);
            // pass current object to the compiler
            var context = this;
            // compile
            var strHtml = template(context);
            // replace content
            $("#" + strElement).html(strHtml);            
        }
    },
})