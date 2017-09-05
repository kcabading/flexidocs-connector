({
    fieldTag:"input.Blockeditfield",
    fieldname: "",
    record: "",
    /**
     * Called when initializing the field
     * @param options
     */
    initialize: function(options) {
        app.view.Field.prototype.initialize.call(this, options);
        console.log("Blockeditfield called");
    },

    /**
     * Called when rendering the field
     * @private
     */
    _render: function() {
        // Do we have a field name?
        if (this.def.name != undefined) {
            // Set the field name
            this.fieldname = this.def.name;
        }
        // Set the record id
        this.record = this.model.get("id");
        // Render this value
        app.view.Field.prototype._render.call(this);        
    },

    /**
     * Called when formatting the value for display
     * @param value
     */
    format: function(value) {
        return this._super('format', [value]);
    },

    /**
     * Called when unformatting the value for storage
     * @param value
     */
    unformat: function(value) {
        return this._super('unformat', [value]);
    }
})
