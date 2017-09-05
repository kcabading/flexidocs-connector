({
    className: 'viewdocumentvariables',
    signingFields: {},
    moduleFields: {},
    relateFields: {},
    relateModules: {},
    events: {        
        'click .close-drawer' : 'close', 
        'click .copy-module-variable': 'copyToClipBoard', 
        'click .copy-related-module-variable-btn': 'copyToClipBoard', 
        'click .copy-related-variable': 'copyToClipBoard'
    },      
    templateCollection: null,          
    loadData: function () {

        console.log("context");
        console.log(this.context);
        // assigned pass data to current object
        // this.moduleFields = this.context.get('modulefields');
        // Assign scope        
        var self = this;
        // Generate the REST URL
        var strUrl = app.api.buildURL('intellidocs/getvariables');
        // Set up the data
        var objData = {
            "OAuth-Token": app.api.getOAuthToken(),
            "parent_module" : this.context.get('parent_module'),
            "parent_id" : this.context.get('parent_id')
        };
        // initialize ajax
        $.ajax({
            url: strUrl,
            type: "GET",
            dataType: "json",
            data: objData,
            headers: {"OAuth-Token": app.api.getOAuthToken()},
            success: function(objResponse) {
                // String response?
                if (typeof(objResponse) == "string") {
                    // Decode
                    objResponse = $.parseJSON(objResponse);                    
                }
                // Set the module fields
                self.signingFields = objResponse.signing;
                self.moduleFields = objResponse.fields;
                self.relateFields = objResponse.relate_fields;
                self.relateModules = objResponse.relate_modules;
                self.currentUserFields = objResponse.current_user;
                // Render
                self._render();
            }
        });
    },
    copyToClipBoard: function(objEvent) {
        // Prevent default behaviour
        objEvent.preventDefault();
        // Get the element
        objTarget = $(objEvent.target);
        // initialize text to copy as string
        var strTextToCopy = '';
        // append an invinsible input
        $("body").append("<textarea type='text' id='temp' style='position:absolute;opacity:0;'></textarea>");     
        // if event triggered is the button for copying module variable
        if (objTarget.hasClass('copy-related-module-variable-btn')) {
            // cache the parent div of the button
            var strParentDiv = objTarget.parent().parent();
            // get the parent module
            var strParentModule = strParentDiv.prev().data('parent-module');            
            // get all checkboxes on the current div
            var arCheckBoxes = strParentDiv.find('.check-related-module-variable');
            // initialize as string
            var strIncludedVariables = "";                     
            // loop through each checkboxed
            $.each(arCheckBoxes,function(idx, obj){                                
                // if checked
                if ($(obj).is(":checked")) {
                    // add to array
                    strIncludedVariables +=  $(obj).data('label-name') + ": {$IDENTIFIER." + $(obj).data('parent-variable') + "}\n\r" ;
                }
            });
            // finalize the content
            strTextToCopy = "{foreach from=" + strParentModule + " item=IDENTIFIER} \n\r" + strIncludedVariables +  "{/foreach}";
        } else {
            // just assign the text
            strTextToCopy = objTarget.data("module-variable");
        }
        // select the input text
        $("#temp").val(strTextToCopy).select();
        // execute document copy to clipboard event
        document.execCommand("copy");
        // remove the input
        $("#temp").remove();        
        // show info alert
        app.alert.show('copy-to-clipboard-logger', {
            level: 'info',
            messages: "Copied Variable to Clipboard",
            autoClose: true
        });
    },
    _render: function() {
        // initialize scope
        var self = this;
        // call parent handler
        this._super("_render");
        // // attach action for clipboard copy
        // $(".copy-module-variable, .copy-related-variable, .copy-related-module-variable-btn").on('click', function(event){
        //     // initiate copy event
        //     self.copyToClipBoard($(event.target));
        // });
        // Handle the expand/collapse function
        $(".moduleName").on("click", function(event){
            // if next element is visible
            if ($(this).next().is(":visible")) {
                // hide 
                $(this).next().hide();
                // change icon
                $(this).find("i").attr("class", "icon-plus-sign fa fa-plus");
            } else {
                // show
                $(this).next().show();
                // change icon
                $(this).find("i").attr("class","icon-minus-sign fa fa-minus");    
            }
        });
        // hide loading icon
        $("#loading-icon").hide();
        // show variables view
        $("#variables-view").show();
    },
    _dispose: function() {
        this._fields = null;
        // Call parent handler
        app.view.View.prototype._dispose.call(this);
    },    
    close: function () {              
        //close the drawer
        app.drawer.close();
    }    
})

