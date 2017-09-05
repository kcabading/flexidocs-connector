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
({
    extendsFrom: 'RowactionField',
    events: {
        'click [data-action=link]': 'linkClicked',
        'click [data-action=moreDocuments]': 'loadMoreTemplates',
        'click [data-action=listVariables]': 'listVariables',
        'click [data-action=mergeMultiple]': 'mergeMultiple',
        'mouselenter [rel="tooltip"]' : 'showToolTip',
        'mouseleave [rel="tooltip"]': 'hideToolTip'
    },    
    /**
     * Document Template collection.          
     */
    templateCollection: null,
    /**
     * Favorite Documents collection.          
     */
    favoriteDocuments : JSON.parse(localStorage.getItem("favoriteDocuments")),
    /**
     * Minimum of 5 Document in a collection
     */
    minimumTemplateCollection: null,
    /**
     * Check if number of documents exceeded more than 5
     *
     * @property {Boolean}
     */
    limitExceed: false,
    /**
     * Visibility property for available template links.
     *
     * @property {Boolean}
     */
    fetchCalled: false,   
    /**
     * Show tooltip
     */
    showToolTip: function(event) {
        // show
        this.$(event.currentTarget).tooltip("show");
    },
    hideToolTip: function(event) {
        // hide
        this.$(event.currentTarget).tooltip("hide");
    },         
    /**
     * {@inheritDoc}
     * Create Template collection in order to get available template list.
     */    
    getTemplates: function(options) {    
        // assign scope
        var self = this;         
        // assign parent module to object
        this.strParentModule = this.model.get('_module');        
        // and id
        this.strParentId = this.model.get("id");
        // create backbone model
        var DocumentTemplate = Backbone.Model.extend({});
        // create backbone collection
        var DocumentTemplates = Backbone.Collection.extend({
        model: DocumentTemplate
        });       
        // assign empty collection
        this.templateCollection = new DocumentTemplates();
        this.minimumTemplateCollection = new DocumentTemplates();
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/getdocuments');        
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "parent_module": this.strParentModule
        };        
        // Initialise the results
        var arResults = [];
        var self = this;
        // Get the list of documents
        $.ajax({
            url: strUrl,
            type: "GET",
            dataType: "json",            
            data: objData,
            headers: {"OAuth-Token": app.api.getOAuthToken()},        
            success: function(objResponse) {                       
                // return result is string
                if (typeof(objResponse) == "string") {
                    // Decode
                    objResponse = $.parseJSON(objResponse);
                }
                // console.log(objResponse);
                // // if empty 
                if (!objResponse.length){
                    // set no result to true
                    self.bNoResult = true;   
                    // display             
                    self._render();
                } else {                
                    // initialize array
                    var arDocuments = [];
                    // get favorites
                    var favoriteDocuments = JSON.parse(localStorage.getItem("favoriteDocuments"));
                    // if we have favorite documents set
                    if (favoriteDocuments) {
                    // sort documents by favorites
                        $.each(objResponse, function(strKey, objDetail) {
                            // if one of the favorite
                            if ( favoriteDocuments.documents.indexOf(objDetail.id)!= -1 ) {
                                // add to the beginning of array
                                arDocuments.unshift(objDetail);
                            } else {
                                // add it to the end of array
                                arDocuments.push(objDetail);
                            }
                        });                    
                    } else {
                        // set as is
                        arDocuments = objResponse;
                    }
                    // initialize counter                              
                    var intCount = 0;                         
                    // loop through response
                    // recreating and storing to global variable       
                    $.each(arDocuments, function( idx,objDetail) {                                                
                        // make sure we have key and id present on result
                        if (objDetail.webmerge_id != "" && objDetail.webmerge_key != "") {  
                             // initialise 
                            var bFlexiWriter = false;
                            var bInteractive = false;
                            // loop through field maps
                            $.each(objDetail.field_maps, function(idx, strFieldValue) {                                
                                // if field map name equals to flexiwriter
                                if (strFieldValue == 'flexiwriter') {
                                    bFlexiWriter = true;                                    
                                }
                                // if field map equals to interactive
                                if (strFieldValue == 'interactive') {
                                    bInteractive = true;
                                }
                            });                                                                           
                            // add while template is less than 4
                            if(intCount < 5){                            
                                // add it to the minimum collection
                                self.minimumTemplateCollection.add( new DocumentTemplate({
                                                                        id: objDetail.id,
                                                                        name: objDetail.name,
                                                                        file_type: objDetail.file_type,
                                                                        bFlexiEnabled: bFlexiWriter,
                                                                        is_interactive: bInteractive
                                                                    })
                                );                        
                            }
                            // add it to the whole collection
                            self.templateCollection.add( new DocumentTemplate({
                                                            id: objDetail.id,      
                                                            name: objDetail.name,
                                                            file_type: objDetail.file_type,
                                                            field_maps: objDetail.field_maps,
                                                            bFlexiEnabled: bFlexiWriter,
                                                            is_interactive: bInteractive,
                                                            output_format_pdf: objDetail.output_format_pdf,
                                                            output_format_orig: objDetail.output_format_orig,
                                                            allow_download: objDetail.allow_download,
                                                            allow_email: objDetail.allow_email
                                                        })
                            );
                            // console.log(self.templateCollection);
                            // add counter
                            intCount++;
                        }                        
                    });
                    // check if limit exceed
                    if (self.templateCollection.length > 5){
                        // set to true
                        self.limitExceed = true;
                        // add another link to the limit collection
                        self.minimumTemplateCollection.add( new DocumentTemplate({                                                                                                                                                   
                                                                                name: "Show More...",                                                                             
                                                                                data_action: "moreDocuments"                                                                        
                                                                                })
                        );
                    }     
                    // render the page                 
                    self._render();
                }
            }
        });  
        
    },
    _render: function() {           
        // call parent handler
        this._super('_render');
        // assign scope
        var self = this;
        // assign view variables event
        $('[data-action=listVariables]').on('click', self.listVariables );
        // listen for clicked event
        $("[data-action=merge]").on("click", function(event){
            // stop triggering other event
            event.stopPropagation();                        
            // dont follow link            
            event.preventDefault();           
            // get model from the collection
            var objModel = self.templateCollection.get($(this).data('id'));
            // initialise as array
            var arInteractiveFields = [];
            // loop through field maps
            $.each(objModel.attributes.field_maps, function(idx,strValue){                
                // if we found an interactive field
                if (strValue.indexOf('interactive|')!= -1) {
                    // add to array
                    arInteractiveFields.push(strValue);                    
                }   
            });            
            // Open in a drawer            
            app.drawer.open({
                layout: 'electronicsign',
                // pass data
                context: {  
                            id: objModel.attributes.id,
                            name : objModel.attributes.name,
                            file_type: objModel.attributes.file_type,
                            parent_module: self.strParentModule,
                            parent_id: self.strParentId,
                            signature_type: self.strSignatureType,
                            bAlreadyMerged : false,
                            interactive_fields: arInteractiveFields,
                            output_format_pdf: objModel.attributes.output_format_pdf,
                            output_format_orig: objModel.attributes.output_format_orig,
                            allow_download: objModel.attributes.allow_download,
                            allow_email: objModel.attributes.allow_email                 
                        }                          
            });           
        });
        //
        $('.flexi-edit').on('click', function(event){
            // stop event propagation
            event.stopPropagation();            
            // route to flexiwriter
            app.router.redirect("#Opportunities/" + self.model.get('id') + "/layout/blockedit");
        });
        // get favorites
        var favoriteDocuments = JSON.parse(localStorage.getItem("favoriteDocuments"));
        // if not empty
        if (favoriteDocuments){
            // get all documents
            var arDocuments = $("a[data-action=merge]");
            // loop
            $.each(arDocuments, function(index, value){
            // if we have    
            if ( favoriteDocuments.documents.indexOf($(this).data("id"))!= -1 ){
                    // add star icon
                    $(".documents").find("[data-id=" + $(this).data("id") + "]").prepend('<span class="icon-star fa fa-star" style="color: #e6af17"></span>');
                } 
            })
        }
    },    
    /**
     * Handle the button click event.
     * Stop event propagation in order to keep the dropdown box.
     *
     * @param {Event} evt Mouse event.
     */
    linkClicked: function(evt) {   
        // prevent default action        
        evt.stopPropagation();                        
        // check visibility 
        if (this.fetchCalled){
            // hide
            this.fetchCalled = false;
            // render            
            this.render();
        } else {            
            // load templates
            this.getTemplates();
            // show
            this.fetchCalled = true;  
            // render
            this.render();               
        }        
    },
    loadMoreTemplates: function(event){
        // keep dropdown box
        event.stopPropagation();
        // assign scope
        var self = this;
        // Open in a drawer            
        app.drawer.open({
            layout: 'manageintellidocsdocuments',
            // pass data
            context: {                          
                        collection: self.templateCollection,
                        parent_module: self.model.get("_module"),
                        parent_id: self.model.get("id")                                    
                    }                          
        });
    },
    listVariables: function(event){   
        // keep dropdown box
        event.stopPropagation();
        // assign scope
        var self = this;        
        // Open in a drawer            
        app.drawer.open({
            layout: 'viewdocumentvariables',
            // pass data
            context: {  
                        parent_module: $(event.target).data('module'),
                        parent_id: $(event.target).data('id')                     
                    }                          
        });
    },
    mergeMultiple: function(event){

        console.log('merge multiple documents');
        // keep dropdown box
        event.stopPropagation();
        // assign scope
        var self = this;        
        // Open in a drawer            
        app.drawer.open({
            layout: 'mergemultiple',
            // pass data
            context: {  
                        parent_module: self.model.get("_module"),
                        parent_id: self.model.get("id"), 
                        templates: self.templateCollection                       
                    }                          
        });

    }    
})