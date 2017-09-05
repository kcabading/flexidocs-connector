/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
/**
 * Active followups dashlet takes advantage of the tabbed dashlet abstraction by
 * using its metadata driven capabilities to configure its tabs in order to
 * display information about followups module.
 *
 * Besides the metadata properties inherited from Tabbed dashlet, Active followups
 * dashlet also supports other properties:
 *
 * - {Array} overdue_badge field def to support overdue calculation, and showing
 *   an overdue badge when appropriate.
 *
 * @class View.Views.BaseActiveTasksView
 * @alias SUGAR.App.view.views.BaseActiveTasksView
 * @extends View.Views.BaseTabbedDashletView
 */
({    
    /**
     * {@inheritDoc}
     *
     * @property {Number} _defaultSettings.limit Maximum number of records to
     *   load per request, defaults to '10'.
     * @property {String} _defaultSettings.visibility Records visibility
     *   regarding current user, supported values are 'user' and 'group',
     *   defaults to 'user'.
     */
    className: 'intellidocs-record',
    _defaultSettings: {
        limit: 10,
        visibility: 'user',
        user_ownership: 'Mine',
    },    
    plugins: ['Dashlet'],                    
    strModule : 'idoc_documents',
    defaultVisibility: "user",
    events: {
        'click .sign-intellidocs' : 'signIntellidocs',
        'click .delete-intellidocs' : 'deleteIntellidocs',
        'click .open-record-view' : 'displayRecordView',
        'click .toggle-timeline' : 'toggleTimeline',
        'click .cancel-esign' : 'cancelSigning',
        'click .mail-document' : '_openeventMailingModal',
        'click .upload-new-version' : '_openFileInput',
        'change .flexidoc-upload-file' : '_manuallyUploadDoc',
    },
    objCurrentUser : {},
    strIntellidocsID : '',
    strEventID: '',
    offset : 10,    
    arIntellidocs : [],    
    bNoResult : false,
    bCalculateFirst : 1,
    arDefaultAddresses: [],
    arCountryCode : [],
    intLobEnabled : 0,    
    objDownloadNotes: {},       
    arSendLetterStatus: ['merged','manually_uploaded','partially_signed','signed','document_converted'],   
    _openFileInput: function(event){
        console.log('button click');
        console.log(event.target);
        // prevent default action
        event.preventDefault();
        event.stopPropagation();
        // cache element target
        var objTarget = $(event.target);
        // workaround for tags inside button that is still clickable
        if ( objTarget.parent().is(":disabled") )
        {    
            return false;
        } 
        // // disable button
        // objTarget.parents('.btn-group').find('button.upload-new-version').attr('disabled','disabled');        
        // assign local scope
        var self = this;        
        // trigger file upload
        objTarget.parents('.btn-group').find('input[type=file]').trigger('click');
    },
    _manuallyUploadDoc: function(event){
        // assign local scope
        var self = this;
        // disable file input
        // $('#flexidoc-upload-file').attr('disabled','disabled');                      
        console.log('Uploading document');    
        // cache file input element
        var objTarget = $(event.target);
        // cache the target element icon class
        var strClass = $('.upload-new-version i').attr('class');
        // change the upload icon to spinner class
        objTarget.parents('.btn-group').find('button.upload-new-version i').attr('class','fa fa-spinner fa-spin');      
        // disable button  
        objTarget.parents('.btn-group').find('button.upload-new-version').attr('disabled','disabled');
        // check if Window FileReader works        
        if (window.File && window.FileReader) {            
            // get the file
            var objFile = event.target.files[0];            
            // check file type
            if (objFile.type != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' && objFile.type != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
                // change the class
                $('.upload-new-version i').attr('class',strClass);
                // show success
                app.alert.show('intellidocs-logger', {
                    level: 'error',
                    messages: 'Invalid file type.',
                    autoClose: false,                        
                });        
                // remove disable
                objTarget.removeAttr('disabled');        
                // simply return
                return;
            }
            // initialise file reader
            var objFileReader  = new FileReader();
            // add event listener
            objFileReader.addEventListener("load", function () {
                // do we have data
                if (objFileReader.result !== undefined) {
                    // start ajax upload, setup data                    
                    var objData = {
                        "OAuth-Token": app.api.getOAuthToken(),
                        'module' : self.model.get('_module'),
                        'id' : self.model.get('id'),
                        'file-name' : objFile.name,
                        'file-type' : 'docx',
                        'file-data' : objFileReader.result,
                        'document-id' : objTarget.data('document-id'),
                        'record-id' : objTarget.data('record-id')
                    }   
                    console.log(objData);
                    // Generate the REST URL
                    var strUrl = app.api.buildURL('intellidocs/manualupload');                    
                    // initialize ajax
                    $.ajax({
                        url: strUrl,
                        type: "POST",
                        dataType: "json",
                        data: objData,                           
                        success: function(objResponse) {
                            console.log(objResponse);
                            // // String response?
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
                                $('.upload-new-version i').attr('class',strClass);
                            } else {
                                // change the class
                                $('.upload-new-version i').attr('class',strClass);
                                // show success
                                app.alert.show('intellidocs-logger', {
                                    level: 'success',
                                    messages: objResponse.success,
                                    autoClose: false,                        
                                });
                            }     
                            // empty the file
                            objTarget.val("");
                            // remove disable
                            objTarget.parents('.btn-group').find('button.upload-new-version').removeAttr('disabled');
                            // refresh   
                            app.router.refresh();
                        },
                        error: function(objError, strError, strMessage) {
                            
                        }
                    });
                }
            }, false);
            // do we have file?
            if (objFile) {
                // read data
                objFileReader.readAsDataURL(objFile);                
            } else {
                alert('File not found');      
            }
        } else {
          alert('The File APIs are not fully supported in this browser.');
        }
    },
    _changeMailingAddress: function(event){
        console.log('changing address');
        // assign local scope
        var self = this;
        // get the selected mailing address
        var strSelectedAddress = $('#event-default-addresses').val();
        console.log(strSelectedAddress);
        // change the deafult value of each mailing address input
        $('#event_address_line1').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_street']);
        $('#event_address_city').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_city']);
        $('#event_address_state').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_state']);
        $('#event_address_zip').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_postalcode']);
        $("#event_address_country").select2({width:'100%'}).select2("val", self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_country']);
        // $('#event_address_country').val(self.arDefaultAddresses[strSelectedAddress][strSelectedAddress + '_country']);
    },
    _openeventMailingModal: function(event){
        console.log('OPENING MODAL');
        console.log($(event.target).data('id'));
        console.log($(event.target).data('event-id'));
        // prevent default action
        event.preventDefault();        
        // assig scope
        var self = this;
        // remove disable attribute
        $("#event-send-to-address").removeAttr("disabled");
        $("#event-send-to-address").html("<i class='icon-check fa fa-envelope' ></i> Send");
        // set calculate first to true;
        self.bCalculateFirst = 1;
        // get intellidocs id and event id
        this.strIntellidocsID = $(event.target).data('id');
        this.strEventID = $(event.target).data('event-id');        
        // check if modal exist as a direct child on body element
        if ($('body').children('#eventMailingModal').length == 0 ) {
            // add first to body and open
            $('#eventMailingModal').appendTo("body");
        }
        $('#eventMailingModal').modal('show');
        // attach event for verifying and sending to address
        $('#event-verify-address').on('click', self._verifyMailingAddress);        
        $('#event-send-to-address').on('click', self._sendToAddress.bind(self) );
        // attach event when address is change              
        $('#event-default-addresses').on('change',self._changeMailingAddress.bind(self));  
    },
    _sendToAddress: function(event) {
        // assign scope
        var self = this;      
        // cache the value of address1
        var strAddress1 = $('#event_address_line1').val();
        var strAddress2 = $('#event_address_line2').val();
        var strCity = $('#event_address_city').val();
        var strState = $('#event_address_state').val();
        var strZip = $('#event_address_zip').val();
        var strCountry = $('#event_address_country').val();
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
            "intellidocs_id": this.strIntellidocsID,                           
            "event_id": this.strEventID,
            "parent_module" : this.model.get('_module'),                
            "parent_id" : this.model.get('id'),            
            'addresses' : {
                'address_line1' : strAddress1,
                'address_line2' : strAddress2,
                'address_city' : strCity,
                'address_state' : strState,
                'address_zip' : strZip,
                'address_country' : strCountry               
            },
            'description' : $('#event_letter_description').val(),
            'print_type' : $('input[type=radio][name=event_print_type]:checked').val(),
            'double_sided' : $('input[type=radio][name=event_double_sided]:checked').val(),
            'calculate_first' : self.bCalculateFirst
        }
        console.log(objData);
        // disable button
        $("#event-send-to-address").attr("disabled", 'disabled');
        // start loading spin
        $("#event-send-to-address i").attr("class", "fa fa-refresh fa-spin icon-refresh icon-spin");        
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/sendtomailingaddress');
        // initialize ajax
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
                if (objResponse.error) {
                    // if merge fail, indicate error
                    app.alert.show('intellidocs-logger', {
                        level: 'error',
                        messages: objResponse.error,
                        autoClose: false,                        
                    });
                    // restore class
                    $("#event-send-to-address i").attr("class", 'icon-envelope fa fa-envelope');  
                    $("#event-send-to-address").removeAttr("disabled");                
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
                            $("#event-send-to-address i").attr("class", 'icon-envelope fa fa-envelope');  
                            $("#event-send-to-address").removeAttr("disabled");  
                        }
                    });
                } else {
                    // change the button and disable
                    $("#event-send-to-address").attr("disabled", 'disabled');
                    $("#event-send-to-address").html("<i class='icon-check fa fa-check' ></i> Sent");
                    // close the mailing modal
                    $('#eventMailingModal').modal('hide');
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
                'address_line1' : $('#event_address_line1').val(),
                'address_line2' : $('#event_address_line2').val(),
                'address_city' : $('#event_address_city').val(),
                'address_state' : $('#event_address_state').val(),
                'address_zip' : $('#event_address_zip').val(),
                'address_country' : $('#event_address_country').val()
            }
        }
        // start loading spin
        $("#event-verify-address i").attr("class", "fa fa-refresh fa-spin icon-refresh icon-spin");        
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/verifymailingaddress');
        // initialize ajax
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
                if (objResponse.error) {
                    // if merge fail, indicate error
                    app.alert.show('intellidocs-logger', {
                        level: 'error',
                        messages: objResponse.error,
                        autoClose: true,                        
                    });
                    // restore class
                    $("#event-verify-address i").attr("class", 'icon-refresh fa fa-refresh');
                } else {
                    // change the class
                    $("#event-verify-address i").attr("class", 'icon-check fa fa-check');
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
    /**
     * Cancel Electronic Signing     
     */
    cancelSigning: function(event) {
        // assign scope
        console.log('Canceling signature' + $(event.target).data('id') );
        // show a confirmation alert
        app.alert.show('message-id', {
            level: 'confirmation',
            messages: 'Are you sure you want to cancel ' + $(event.target).data('name') + ' for signing?',
            autoClose: false,
            onConfirm: function(){                
                // initialise url for deletion
                var strUrl = app.api.buildURL('intellidocs/cancelsigning');                                            
                // Set up the data
                var objData = {
                    "OAuth-Token": app.api.getOAuthToken(),
                    'id': $(event.target).data('id'),                               
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
                            // if merge success
                            app.alert.show('intellidocs-logger', {
                                level: 'success',
                                messages: 'Successfully cancelled',
                                autoClose: true                                
                            });                
                            // refresh
                            app.router.refresh();         
                        } else {
                            // if delete fail
                            app.alert.show('intellidocs-logger', {
                                level: 'error',
                                messages: 'Error deleting record',
                                autoClose: true                                
                            }); 
                        }        
                    }                                        
                }); 
            },
            onCancel: function(){
                // simply return
                return;
            }
        });
    },
    /**
     * Toggle timeline view for each record
     * 
     * @return null
     */
    toggleTimeline: function(event) {
        // cache event target
        var target = $(event.target).closest('.intellidoc-details');        
        // check if timeline record is hidden
        if (target.next().is(':hidden')) {
            // change the tag
            $(event.target).attr('class','icon icon-minus-sign fa fa-minus toggle-timeline');
            // hide it
            target.next().slideDown();            
        } else {
            // change the tag
            $(event.target).attr('class','icon icon-plus-sign fa fa-plus toggle-timeline');
            //show it
            target.next().slideUp();            
        }
    },
    /**
     * Sign Intellidocs document
     *
     * @param event Click event to capture -data values
     *
     * @return null
     */
    signIntellidocs: function(event){        
        // assign to local scope
        var self = this;
        // cache the value
        var objTarget = $(event.target);
        // workaround for tags inside button that is still clickable
        if ( objTarget.parent().is(":disabled") )
        {    
            return false;
        }
        // get the flexiocs id
        var strIntellidocsID = $(event.target).data('id');        
        // if document key exist
        if (!_.isUndefined(self.arIntellidocs[strIntellidocsID]) && self.arIntellidocs[strIntellidocsID] != undefined) {
            // Open the layout for sending to signature in a drawer
            app.drawer.open({
                layout: 'electronicsign',
                // pass data
                context: {  
                            id : strIntellidocsID,
                            record_id : self.arIntellidocs[strIntellidocsID].id,
                            name : self.arIntellidocs[strIntellidocsID].name, 
                            file_type : self.arIntellidocs[strIntellidocsID].file_ext,
                            allow_email: false,
                            allow_download: false,
                            no_of_signers: self.arIntellidocs[strIntellidocsID].no_of_signers,
                            default_signers: self.arIntellidocs[strIntellidocsID].default_signers,
                            default_signers_init: self.arIntellidocs[strIntellidocsID].default_signers_init,
                            doc_event_id : self.arIntellidocs[strIntellidocsID].doc_event_id,
                            parent_module: self.model.get('_module'),
                            parent_id: self.model.get('id'),                   
                            bAlreadyMerged : true,
                            bDirectSigning : true,
                        }                          
            });
        }        
    },
    /**
     * Delete Intellidocs document
     * 
     * @param event Click event to capture -data values
     *
     * @return null Show alerts if deletion is successful or not
     */
    deleteIntellidocs: function(event){
        // assign to local scope
        var self = this;                
        // show a confirmation alert
        app.alert.show('message-id', {
            level: 'confirmation',
            messages: 'Are you sure you want to delete the document ' + $(event.target).data('name') + '?',
            autoClose: false,
            onConfirm: function(){                
                // initialise url for deletion
                var strUrl = app.api.buildURL('intellidocs/deleterelatedintellidocs');                                            
                // Set up the data
                var objData = {
                    "OAuth-Token": app.api.getOAuthToken(),
                    'id': $(event.target).data('id'),
                    "parent_id": self.model.get('id'),                 
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
                            // if merge success
                            app.alert.show('intellidocs-logger', {
                                level: 'success',
                                messages: 'Successfully deleted',
                                autoClose: true                                
                            });                
                            // refresh
                            app.router.refresh();         
                        } else {
                            // if delete fail
                            app.alert.show('intellidocs-logger', {
                                level: 'error',
                                messages: 'Error deleting record',
                                autoClose: true                                
                            }); 
                        }        
                    }                                        
                }); 
            },
            onCancel: function(){
                // simply return
                return;
            }
        });   
    },
    /**
     * {@inheritDoc}
     */
    initialize: function(options) {     
        var self = this;       
        // extend meta
        options.meta = _.extend({}, options.meta, {
            last_state: {
                id: 'intellidocs-list' + self.cid
            }
        });                        
        // Initialise the view
        app.view.View.prototype.initialize.call(this, options);        
        // Load the no access template
        this._noAccessTemplate = app.template.get(this.name + '.noaccess');
        // set currents user id and user type
        this.objCurrentUser.id = app.user.id;
        this.objCurrentUser.type = app.user.attributes.type;       
    },
    /**
     * {@inheritDoc}
     */
    _initEvents: function() {
        this._super('_initEvents');
        return this;
    },    
    /**
     * Function that calls before the render
     */
    loadData: function(options) {        
        // if we already have a config        
        if (this.disposed || this.meta.config) {
            return;
        }                
        // set to local
        var self = this;
        // initialise url
        var strUrl = app.api.buildURL('intellidocs/getrelatedintellidocs');                                            
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),            
            "record_id": this.model.get('id'),
            "module" : this.model.get('_module'),
            "timeline_limit" : this.settings.get("timeline_limit")
        };        
        // call web service
        $.ajax({
            url: strUrl,
            type: "GET",
            dataType: 'json',
            data: objData,
            headers: {"OAuth-Token": app.api.getOAuthToken()},
            success: function(objResponse) {                    
                // Is this a json object
                if (typeof(objResponse) == "string") {
                    // Decode
                    objResponse = $.parseJSON(objResponse);
                }                
                // // if we have response
                if (objResponse) {     
                    // assign to object
                    self.arIntellidocs = objResponse.documents;                    
                    // if no documents generated yet
                    if(_.isEmpty(self.arIntellidocs)) self.bNoResult = true;
                    // assign document templates
                    self.objDocumentTemplates = objResponse.document_templates;                    
                    console.log(self.arIntellidocs);
                    console.log(self.objDocumentTemplates);
                    // set default addresses
                    self.arDefaultAddresses = objResponse.default_addresses;
                    // set if lob is enabled
                    self.intLobEnabled = objResponse.enable_lob;                                       
                    // render
                    self.render();
                } else {
                    self.bNoResult = true;
                    // render
                    self.render();
                    console.log('error');
                }
                // // set initial load to false
                // self.bInitialLoad = false;              
            },
            context: self,
            complete: options ? options.complete : null            
        });     
        // remove any custom modal
        $('.flexidocs-modal').remove();
        // get the country code
        this.arCountryCode = app.lang.getAppListStrings('country_code');         
    },        
    /*
    * Override parent render
    */
    _render: function() {        
        // call parent handler
        this._super("_render");         
        // assign scope
        var self = this;     
        // initialise general select2 fields
        $('.select2-field').select2({width:'100%'});          
        // set the letter description field to the document name
        $('#event_letter_description').val($('#document-name').text());                
        // initialize tooltip
        $('[rel=tooltip]').tooltip();           
    },        
    _dispose: function() {        
        this._super('_dispose');
    },
    displayRecordView: function(event) {
        // Don't follow the link
        event.preventDefault();
        // Store reference to object
        var self = this;
        // Get the record id
        var strId = $(event.target).data('id');
        var strModule = $(event.target).data('module');
        // Create the model
        var objModel = app.data.createBean(strModule, {'id': strId});
        // Fetch the model
        objModel.fetch();
        // hide
        // $('.row-fluid').hide();        
        // Open in a drawer
        app.drawer.open({
            layout: 'bn_drawer_record_view',
            context: {
                module: strModule,
                model: objModel
            }
        });
    },
})