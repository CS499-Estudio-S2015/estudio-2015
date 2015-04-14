var BackendReports = {
    /**
     * Contains the basic record methods for the page.
     * 
     * @type ServicesHelper|CategoriesHelper
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
        
        // Fill available service categories listbox.
        // $.each(GlobalVariables.categories, function(index, category) {
        //     var option = new Option(category.name, category.id);
        //     $('#service-category').append(option);
        // });
        // $('#service-category').append(new Option('- ' + EALang['no_category'] + ' -', null)).val('null');
        
        // $('#service-duration').spinner({
        //     'min': 0,
        //     'disabled': true //default
        // });
        
        // Instantiate helper object (service helper by default).
        BackendReports.helper = new ServicesHelper();
        BackendReports.helper.resetForm();
        BackendReports.helper.filter('');
        
        // $('#filter-services .results').jScrollPane();
        // $('#filter-categories .results').jScrollPane();
        
        if (bindEventHandlers) BackendReports.bindEventHandlers();        
    },
        
    /**
     * Binds the default event handlers of the backend services page. Do not use this method
     * if you include the "BackendServices" namespace on another page.
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
            
            if ($(this).hasClass('current-tab')) { // display services tab
                $('#current').show();
                BackendReports..helper = new ServicesHelper();
            } else if ($(this).hasClass('historic-tab')) { // display categories tab
                $('#historic').show();
                BackendReports.helper = new CategoriesHelper();
            }
            
            BackendReports.helper.resetForm();
            BackendReports.helper.filter('');
            $('.filter-key').val('');
            //Backend.placeFooterToBottom();
        });
        
        // ServicesHelper.prototype.bindEventHandlers();
        // CategoriesHelper.prototype.bindEventHandlers();
        
    }
};