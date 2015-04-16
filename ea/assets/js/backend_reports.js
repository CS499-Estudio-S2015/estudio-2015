var BackendReports = {
    /**
     * Contains the basic record methods for the page.
     * 
     */
    helper: {},
    
    /**
     * Default initialize method of the page.
     * 
     * @param {bool} bindEventHandlers (OPTIONAL) Determines whether to bind the 
     * default event handlers (default: true).
     */
    initialize: function(bindEventHandlers) {
        if (bindEventHandlers === undefined) bindEventHandlers = true;
        $('#historic').hide();

        if (bindEventHandlers) BackendReports.bindEventHandlers();        
    },
        
    /**
     * Binds the default event handlers of the backend reports page. Do not use this method
     * if you include the "BackendReports namespace on another page.
     */
    bindEventHandlers: function() {
        /**
         * Event: Page Tab Button "Click"
         * 
         * Changes the displayed tab.
         */
        $('.tab').click(function() {
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').hide();
            
            if ($(this).hasClass('current-tab')) {          // display current tab
                $('#current').show();
            } else if ($(this).hasClass('historic-tab')) {  // display historic tab
                $('#historic').show();
            }
        });

    }
};