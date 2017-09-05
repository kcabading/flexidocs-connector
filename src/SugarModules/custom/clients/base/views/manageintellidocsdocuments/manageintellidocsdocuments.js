({
    className: 'manageintellidocsdocuments tcenter',
    events: {        
        'click #cancelMerge' : 'cancelMerge'        
    },      
    templateCollection: null,      
    searchDocument: null,    
    loadData: function () {
        // assign collection to current object
        this.templateCollection = this.context.get('collection');
        // assign parent module to object
        this.strParentModule = this.context.get('parent_module');        
        // and id
        this.strParentId = this.context.get("parent_id");
    },    
    _render: function() {
        console.log('manageintellidocsdocuments');
        console.log(this.templateCollection);
        // call parent handler
        this._super("_render");   
        // assign scope
        var self = this;
        // set select2
        $("#search_name").select2({            
            minimumResultsForSearch:5,
            closeOnSelect: true,
            allowClear:true
        });        
        // change event
        $("#search_name").on("change", function(){
            // get selected document
            self.searchDocument = $(this).val();            
            if (self.searchDocument == ""){

                self.searchDocument = false;
            }
            //render
            self.render();
            // set selected
            $("#search_name").select2("val", self.searchDocument);
        })        
        // set tooltip  
        $('.favorite').tooltip({selector: '[rel="tooltip"]'});
        $('[rel=tooltip]').tooltip();
        // merge event
        $('.mergeDocument').on( "click" , function(event){            
            // stop triggering other event
            event.stopPropagation();   
            // prevent Default
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
            // // Open in a drawer            
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
                            output_format: objModel.attributes.output_format,
                            allow_download: objModel.attributes.allow_download,
                            allow_email: objModel.attributes.allow_email                            
                        }                          
            });
        });
        // initialize favorite documents
        objFavorites = JSON.parse(localStorage.getItem("favoriteDocuments"));
        // not empty
        if (objFavorites){
            // loop
            $.each(objFavorites.documents, function(key, value){
                // find item
                var td = $("[data-document-id="+value+"]");                
                // style
                td.find("span").css({ color: "#e6af17" }); 
            })
        }
        // favorites on hover event
        $(".favorite").on("click", function(){            
            console.log("star clicked");
            // find star element
            var star = $(this).find("span"),
                starValue = $(this).data("document-id"),                
                objFavorites = JSON.parse(localStorage.getItem("favoriteDocuments"));

            var strStarColor = star.css('color');
            console.log(strStarColor);
            console.log(typeof strStarColor);

            // remove favorite
            if ( strStarColor == 'rgb(230, 175, 23)' ){
                // set color to empty
                star.css({color: "rgb(113, 113, 113)"});
                // find and remove
                arRemaining = jQuery.grep(objFavorites.documents, function(value) {
                        return value != starValue;
                });                
                // if remaining is empty
                if(arRemaining.length > 0){
                    console.log("not empty");
                    // create object
                    var objFavorites = {};
                    // create remaining favorites                    
                    objFavorites.documents = arRemaining;
                    // save
                    localStorage.setItem('favoriteDocuments', JSON.stringify(objFavorites) );
                } else {
                    // remove from local storage
                    localStorage.removeItem('favoriteDocuments');
                }                
            } else {
                console.log('setting local storage');
                // star.removeClass();
                star.css({ color: "#e6af17"});                                
                // if there's already a favorite
                if (objFavorites){                    
                    // just add the document
                    objFavorites.documents.push(starValue);
                    // if not yet added
                    if ( $.inArray(starValue, objFavorites.documents) ){
                        // save 
                        //document.cookie="favoriteDocuments=" + JSON.stringify(objFavorites) + "; expires=Thu, 18 Dec 2015 12:00:00 UTC; path=/";
                        localStorage.setItem('favoriteDocuments', JSON.stringify(objFavorites) );    
                    }
                    // do nothing
                } else {
                    // create object
                    var objFavorites = {};
                    // create favorites                    
                    objFavorites.documents = [starValue];
                    // save
                    localStorage.setItem('favoriteDocuments', JSON.stringify(objFavorites) );
                }
            }
        })
    },
    _dispose: function() {
        this._fields = null;
        app.view.View.prototype._dispose.call(this);
    },    
    cancelMerge: function () {                
        $("[name=web_merge]").trigger("click");
        //close the drawer
        app.drawer.close();
    },

})