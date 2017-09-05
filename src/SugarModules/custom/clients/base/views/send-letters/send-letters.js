({
    className: 'generateletters tcenter',       
    events: {
    	'click .drawer_link' : 'displayDrawer',        
        'click #filter-test' : 'filterTest',
        'click #generate-letters' : 'generateLetters'
    },    
    arModules: {},
    arFilters: [
        {},
        {},
        {},
        {},
        {}
    ],
    arTotals: [
        {},
        {}
    ],
    objModuleData: {},
    objModuleFields: {},
    strModule: "",
    isLoaded: false,
    arDocuments: [],
    arAggregateVariable: {},
    loadData: function() {
    	// assign scope
    	var self = this;
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/getmoduleinfo');
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),             
        };
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "GET",
            dataType: "json",
            data: objData,
            headers: {"OAuth-Token": app.api.getOAuthToken()},
            success: function(objResponse) {
                console.log(objResponse);
                // Is this a json object
                if (typeof(objResponse) == "string") {
                    // Decode
                    objResponse = $.parseJSON(objResponse);
                }
                // Loaded
                self.isLoaded = true;
                // Log the consultants
                self.arModules = objResponse.module_list;
                self.objModuleData = objResponse.module_relationships;
                self.objModuleFields = objResponse.module_fields;                
                self.arDocuments = objResponse.documents;  
                // Render
                self.render();                                           
            },
            error: function(objError, strError, strMessage) {
                // Loaded
                self.isLoaded = true;
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
        // call parent handler
        this._super("_render"); 
        // assign scope
        var self = this;
        // Set up our select boxes
        $("#primary_module").select2({allowClear: true}).change(function() {
            // Get the data value
            self.strModule = $(this).val();
            // Update the filters
            self.initialiseFilters();            
        });
        // Update the filters
        self.initialiseFilters();
        // Set up the select option
        $(".select_module").select2({
            query: function(objQuery) {
                // Initialise the data
                var objFullData = {results: []}
                // Set the results
                var arModules = self.getFilterModuleList();
                // Loop through and add
                $.each(arModules, function(strKey, objData) {
                    // Is there a term?
                    if ((objQuery.term == "") || (String(objData.text).indexOf(objQuery.term) > -1)) {
                        // dont add the primary module
                        // if (self.strModule != objData.id) {
                            // Add the results
                            objFullData.results.push({id: objData.id, text: objData.text});                            
                        // }
                    }
                });
                // Make the callback
                objQuery.callback(objFullData);
            },
            allowClear: true            
        }).on("change", function(e){
            // cache target value
            var objTarget = $(e.target);            
            // if target has class
            if (objTarget.hasClass('select_related_total')) {
                // get up to the parent div
                var objRow = objTarget.closest('.aggregate-row');
                // clear all the fields except the related module
                objRow.find('.select_sum_field, .select_aggregate_operator').select2("val", "");    
                objRow.find('.variable_name').val('');
            }
        });         
        // Set up the select option
        $(".select_operator").select2({allowClear: true});                
        // Set up the select option
        $(".select_field").select2({
            query: function(objQuery) {
                // Get the target object
                var objTarget = objQuery.element;
                // Get the module
                var strModule = objTarget.parents(".row-fluid:first").find(".select_module:first").select2('val');
                // Initialise the data
                var objFullData = {results: []}
                // We should have a list of fields
                if (self.objModuleFields[strModule] != undefined) {
                    // Loop through and add
                    $.each(self.objModuleFields[strModule], function(strKey, objData) {
                        // Is there a term?
                        if ((objQuery.term == "") || (String(objData.label).indexOf(objQuery.term) > -1)) {
                            // Add the results
                            objFullData.results.push({id: strKey, text: objData.label});                            
                        }
                    });
                }
                // Make the callback
                objQuery.callback(objFullData);
            },
            allowClear: true 
        }).on("select2-open", function(e){
            // cache target value
            var objTarget = $(e.target);
            // get the module
            var strModule = objTarget.parents(".row-fluid:first").find(".select_module:first").select2('val');
            // get the select value field
            var objFieldValue = objTarget.parents(".row-fluid:first").find(".select_value:first");
            // if current field value is select2
            if (objFieldValue.hasClass('select2-container')) {
                console.log('click Current value is select2');
                // remove select2
                objFieldValue.select2('destroy');
            } 
        }).on("change", function(e) {            
            // cache target value
            var objTarget = $(e.target);
            // get the module
            var strModule = objTarget.parents(".row-fluid:first").find(".select_module:first").select2('val');
            // get the select value field
            var objFieldValue = objTarget.parents(".row-fluid:first").find(".select_value:first");
            // initialize options options            
            var arOptions = [];
            // Remove previous event listener
            objFieldValue.unbind("click");
            // check the field type
            switch(self.objModuleFields[strModule][e.val]['type']){
                case 'datetime':                                             
                    // set the field value as datepicker
                    objFieldValue.datepicker();
                    break;

                case 'enum':
                    //  get the options
                    var objOptions = self.objModuleFields[strModule][e.val]['options'];                    
                    // loop through options
                    $.each(objOptions, function(index, strValue){
                        // add option
                        arOptions.push({id: index, text: strValue });
                    });                    
                    // set the field value as select2
                    objFieldValue.select2({
                        data : arOptions,
                        allowClear: true
                    });
                    break;

                case 'bool':
                    // set select2
                    objFieldValue.select2({data:[{id:'yes', text:'yes'},{id:'no', text: 'no'}]});
                    break;

                default:
                    // unbind any event
                    objFieldValue.unbind();                                        
                    break;
            }
        });
        // Set up the select option
        $(".select_sum_field").select2({
            query: function(objQuery) {
                // Get the target object
                var objTarget = objQuery.element;
                // Get the module
                var strModule = objTarget.parents(".row-fluid:first").find(".select_module:first").select2('val');
                // Initialise the data
                var objFullData = {results: []}
                // We should have a list of fields
                if (self.objModuleFields[strModule] != undefined) {
                    // Loop through and add
                    $.each(self.objModuleFields[strModule], function(strKey, objData) {

                        console.log(objData.type);
                        // Is there a term?
                        if (((objData.type == "int") || (objData.type == "decimal") || (objData.type == "currency")) && ((objQuery.term == "") || (String(objData.label).indexOf(objQuery.term) > -1))) {
                            // Add the results
                            objFullData.results.push({id: strKey, text: objData.label});                            
                        }
                    });
                }
                // Make the callback
                objQuery.callback(objFullData);
            },
            allowClear: true   
        }).change(function(e){
            // cache parent Div
            var objRow = $(e.target).closest('.aggregate-row');                        
            // clear all the fields except this field
            objRow.find('.select_aggregate_operator').select2("val", "");    
            objRow.find('.variable_name').val('');
        })
        // select document 
        $(".select_document").select2({
            query: function(objQuery) {                
                // Initialise the data
                var objFullData = {results: []}        
                // Loop through all the documents
                $.each(self.arDocuments, function(strKey, objData) {
                    // Is there a term?
                    if ((objQuery.term == "") || (String(objData.text).indexOf(objQuery.term) > -1)) {
                        // if primary module is equal to document's module
                        if (self.strModule == objData.module) {
                            // Add the results
                            objFullData.results.push({id: objData.id, text: objData.name});                            
                        }
                    }
                });
                // // Make the callback
                objQuery.callback(objFullData);
            },
            allowClear: true
        }).change(function() {
            // Get the data value
            self.objDocument = self.arDocuments[$(this).val()];
            console.log(self.objDocument);
        });
        // setup event for aggregate select2
        $('.select_aggregate_operator').select2().change(function(event){
            // cache the target element
            var el = $(this);
            // get module
            var strModule = el.closest('.aggregate-row').find('.select_module').select2('val');
            // get aggregate field
            var strAggregateField = el.closest('.aggregate-row').find('.select_sum_field').select2('val');
            // get operator field
            var strOperator = el.select2('val');
            // if all fields not empty
            if (!_.isEmpty(strModule) && !_.isEmpty(strAggregateField) && !_.isEmpty(strOperator) ) {
                // concatenate the values
                var strAggregateVariable = String(strModule).toLowerCase() + '_' + strAggregateField + '_' +strOperator;                
                // if module not yet added
                if ( !self.arAggregateVariable.hasOwnProperty(strModule)  ) { 
                    // set it as array
                    self.arAggregateVariable[strModule] = [];
                }
                // then add to array
                self.arAggregateVariable[strModule].push({
                    field: strAggregateField,
                    operator: strOperator,
                    variable: strAggregateVariable
                });
                // add value to the 4th column
                el.closest('.aggregate-row').find('.variable_name').val(strAggregateVariable);
            }
        })
        // setup popover for aggregate input 
        $('.variable_name').popover({
            placement: 'top',
            trigger: 'hover'            
        });
        // attach action for clipboard copy
        $(".variable_name").on('click', function(event){
            // initiate copy event
            self._copyToClipBoard($(event.target));
        });
    },
    getFilterModuleList: function() {
        // Initialize the modules
        var arModules = [];
        // Get the primary module first of all
        if ($("#primary_module").val() != "") {
            // Add the data
            var objData = $("#primary_module").select2('data');
            // Add to the modules
            arModules.push(objData);
        }
        // Do we have related data?
        if ($("#related_data").val() != "") {
            // Add the data
            var arData = $("#related_data").select2('data');
            // Loop through
            $.each(arData, function(strKey, objData) {
                // Add to the modules
                arModules.push({id: objData.module_key, text: objData.text});
            });
        }
        // Return the modules
        return arModules;
    },
    initialiseFilters: function() {
        // assign scope
        var self = this;
        // reset filters first
        $('#filter-container').find('.select_operator, .select_module, .select_field, .select_value ').select2('val','');
        $('#aggregate-container').find('.select_operator, .select_module, .select_sum_field').select2('val','');
        $('#aggregate-container').find('.variable_name').val('');
        // Set up the related data
        $("#related_data").select2({
            multiple: true,
            query: function(objQuery) {
                // Initialise the data
                var objData = {results: []}
                // Do we have relationship data
                if (self.objModuleData[self.strModule] != undefined) {
                    // Loop through and add
                    $.each(self.objModuleData[self.strModule], function(strKey, objModuleData) {
                        // Is there a term?
                        if ((objQuery.term == "") || (String(objModuleData.label).indexOf(objQuery.term) > -1)) {
                            // Add the results
                            objData.results.push({id: strKey, module_key: objModuleData.module, text: objModuleData.label});                            
                        }
                    });
                }
                // Make the callback
                objQuery.callback(objData);
            },
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });
    },
    displayDrawer: function(event) {
        // Don't follow the link
        event.preventDefault();
        // Store reference to object
        var self = this;
        // Split the data into module and id
        var arData = String($(event.target).attr("href")).replace("#", "").split("/");
        // We should have two values
        if (arData.length == 2) {
            // Create the model
            var objModel = app.data.createBean(arData[0], {'id': arData[1]});
            // Fetch the model
            objModel.fetch();
            // hide
            $('.row-fluid').hide();        
            // Open in a drawer
            app.drawer.open({
                layout: 'recorddrawer',
                context: {
                    module: arData[0],
                    model: objModel
                }
            });
        }
    },
    /**
     * Run Filter Test
     * @param event click event
     * 
     * @return int Number of records retrieved
     */
    filterTest: function(event) {
        // assign local scope
        var self = this, arRelatedFilters = [], arModules = [];
        // get selected modules
        arModules = this._getSelectedModules();
        // get defined filters
        arRelatedFilters = this._getDefinedFilters();
        // no modules?
        if (arModules.primary_module == '' ) {
            // return prompt message to select            
            app.alert.show("intellidocs-error",
                {
                    level : "error",
                    messages: 'Please select a primary module to continue',
                    autoClose: true
                }
            );
            // return
            return;
        }               
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/filterstest');
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "primary_module": arModules['primary_module'],
            "related_modules" : arModules['related_modules'],
            "related_filters": arRelatedFilters
        };
        // add filter test loading icon
        $("#filter-test i").attr('class','icon-spinner icon-spin fa fa-spinner fa-spin');
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "POST",
            dataType: "json",
            data: objData,
            success: function(objResponse) {
                console.log(objResponse);                
                // remove icon-spinner
                $("#filter-test i").attr('class','icon-book fa fa-book');
                // if we have response
                if (objResponse) {
                    // return prompt message
                    app.alert.show("intellidocs-success",
                        {
                            level : "success",
                            messages: 'Number of Records found: ' + objResponse ,
                            autoClose: true
                        }
                    );
                } else {
                    // return error prompt message
                    app.alert.show("intellidocs-error",
                        {
                            level : "error",
                            messages: 'No Records found',
                            autoClose: true
                        }
                    );
                }               
                // Is this a json object                
            },
            error: function(objResponse) {
                // Set the icon
                
            }
        });
    },
    /**
     * Generate letters with defined filters
     *
     * @param event click event
     * 
     * @return boolean If action is successful or not
     */
    generateLetters: function(event) {
        // assign local scope
        var self = this, arRelatedFilters = [], arModules = [], arAggregateFields = [];
        // get selected modules
        arModules = this._getSelectedModules();
        // get defined filters
        arRelatedFilters = this._getDefinedFilters();
        // no primary module selected?
        if (arModules.primary_module == '' ) {
            // return prompt message to select            
            app.alert.show("intellidocs-error",
                {
                    level : "error",
                    messages: 'Please select a primary module to continue',
                    autoClose: true
                }
            );
            //simply return
            return;
        }
        // is the document object empty
        if ( _.isEmpty(self.objDocument) ) {
            // return prompt message to select a document
            app.alert.show("intellidocs-error",
                {
                    level : "error",
                    messages: 'Please select the intellidocs document to use',
                    autoClose: true
                }
            );
            // simply return
            return;
        }               
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/generatedocuments');
        // add filter test loading icon
        $("#generate-letters i").attr('class','icon-spinner icon-spin fa fa-spinner fa-spin');
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "primary_module": arModules['primary_module'],
            "related_modules" : arModules['related_modules'],
            "related_filters": arRelatedFilters,
            "aggregate_fields" : self.arAggregateVariable,
            "intellidocs" : self.objDocument            
        };
        console.log(objData);
        console.log(objData.intellidocs);
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "POST",
            dataType: "json",
            data: objData,
            success: function(objResponse) {
                console.log(objResponse);
                // parse json
                if (typeof(objResponse) == "string") {
                    // Decode
                    objResponse = $.parseJSON(objResponse);
                }
                // remove icon-spinner
                $("#generate-letters i").attr('class','icon-book fa fa-book');
                // if we have an error
                if (objResponse.error) {
                    // return error prompt message
                    app.alert.show("intellidocs-error",
                        {
                            level : "error",
                            messages: objResponse.error,
                            autoClose: true
                        }
                    );                    
                } else {
                    // return prompt message
                    app.alert.show("intellidocs-success",
                        {
                            level : "success",
                            messages: 'Successfully generated filtered records',
                            autoClose: false
                        }
                    );
                    // download
                    self.downloadFile(objResponse.note_id);
                    // redirect to download page
                    // $(location).attr('href', 'https://console.flexidocs.co/download/zipped/' + objResponse.file_id);
                }                
            },
            error: function(objResponse) {
                // Set the icon
                
            }
        });
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
    /**
     * Get the selected primary and related modules
     *
     * @return array Array of primary and related modules
     */
    _getSelectedModules: function() {        
        // Initialize the modules
        var arModules = {
            primary_module:'',
            related_modules:[]
        };
        // Get the primary module first of all
        if ($("#primary_module").val() != "") {
            // Add the data
            var objData = $("#primary_module").select2('val');
            // Add to the modules
            arModules.primary_module = objData;
        }
        // Do we have related data?
        if ($("#related_data").val() != "") {
            // Add the data
            var arData = $("#related_data").select2('data');
            // Loop through
            $.each(arData, function(strKey, objData) {
                // Add to the modules
                arModules.related_modules.push(objData.module_key);
            });
        } 
        // Return the modules
        return arModules;
    },
    /**
     * Get all the filters
     *
     * @return array Array of filters
     */
    _getDefinedFilters: function() {

        console.log('getting defined filters');
        // initialise filters as array
        var objFilters = {};
        // cache the filter row element
        var arFilterRow = $('.filter-row');
        // loop through each filter
        $.each(arFilterRow, function(idx,objElement){            
            // set to jquery object
            objElement = $(objElement);            
            // if one field is empty
            if (
                objElement.find('.select_module').select2('val') == "" && 
                objElement.find('.select_field').val() == "" && 
                objElement.find('.select_operator').val() == ""                
                ) {
                // skip row
                return true;
            }
            // if module not yet added
            if ( !objFilters.hasOwnProperty(objElement.find('.select_module').select2('val'))  ) {
                console.log('module not yet added' + objElement.find('.select_module').select2('val'));
                // set it as array
                objFilters[objElement.find('.select_module').select2('val')] = [];
            }
            // then add the filter
            objFilters[objElement.find('.select_module').select2('val')].push({
                'module': objElement.find('.select_module').select2('val'),
                'field' : objElement.find('.select_field').select2('val'),
                'operator' : objElement.find('.select_operator').select2('val'),
                'value' : (objElement.find('.select_value').val() == '' ) ? objElement.find('.select_value').select2('val') : objElement.find('.select_value').val()
            });
        });        
        // return filters
        return objFilters;

    },
    /** 
     * Get all aggregate fields
     * @return array Array of aggregate fields
     */
    _getAggregateFields: function() {
        // initialise as object
        var arAggregateFields = {};
        console.log('getting aggregate fields');
        // cache all the aggregate row div
        var arAggregateDiv = $('.aggregate-row');
        // loop through divs
        $.each(arAggregateDiv, function(idx, objElement){
            // set to jquery object
            objElement = $(objElement);
            // get the variable name
            var strVariable = objElement.find('.variable_name').val();
            // if variable not empty
            if (strVariable != '') {
                // if module not yet added
                if ( !arAggregateFields.hasOwnProperty(objElement.find('.select_module').select2('val'))  ) {                    
                    // set it as array
                    arAggregateFields[objElement.find('.select_module').select2('val')] = [];
                }
                // then add to array
                arAggregateFields[objElement.find('.select_module').select2('val')].push(objElement.find('.variable_name').val());
            }            
        });
        // return 
        return arAggregateFields;
    },
    _copyToClipBoard: function(element) {
        // if text variable is empty
        if (!element.val()) {
            // simply return
            return;
        }
        // initialize text to copy as string
        var strTextToCopy = '';
        // append an invinsible input
        $("body").append("<textarea type='text' id='temp' style='position:absolute;opacity:0;'></textarea>");             
        // assign text
        strTextToCopy = element.val();    
        // select the input text
        $("#temp").val(strTextToCopy).select();
        // execute document copy to clipboard event
        document.execCommand("copy");
        // remove the input
        $("#temp").remove();        
        // show info alert
        app.alert.show('copy-to-clipboard-logger', {
            level: 'info',
            messages: "Copied to Clipboard: <br />" + strTextToCopy,
            autoClose: false
        });
    },
})