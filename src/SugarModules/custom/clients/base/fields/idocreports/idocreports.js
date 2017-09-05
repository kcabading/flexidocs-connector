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
    fieldTag: 'idocreports',
    displayValue: "",
    initialize: function(options) {
    	// Store access to self
    	var self = this;
    	// Call parent handler
        this._super('initialize', [options]);
		// generate url to retrieve data
        var strUrl = app.api.buildURL('intellidocs/getcompatiblereports');
        // Make a call to our API
        $.ajax({
			url: strUrl,
			type: 'GET',
			dataType: 'json',
			data: {
				'OAuth-Token': app.api.getOAuthToken(),
                'parent_module': self.model.get("parent_module")                
			},
            headers: {"OAuth-Token": app.api.getOAuthToken()},
			success: function(objResponse) {

				console.log(objResponse);
				// Do we have any matches?
				if (objResponse && objResponse.success) {
					// Call the handler
                    _.extend(self, objResponse);
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
                            autoClose: false
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
		// Store reference to self
		var self = this;
		// Call parent handler
        app.view.Field.prototype._render.call(this);
        // Set up the select handlers
        this.$el.find(".select2").select2().on('change', function(objEvent) {
        	// Get the value
            var strValue = objEvent.val;

            console.log("Value", strValue);
            // Check the value
            if (_.isUndefined(strValue)) {
            	// Invalid value
                return;
            }
            // Do we have a model?
            if (self.model) {
            	// Set the model
                self.model.set(self.name, strValue);
            }
        });
    }
})
