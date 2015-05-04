/**
 * Backend Customers javasript namespace. Contains the main functionality 
 * of the backend customers page. If you need to use this namespace in a 
 * different page, do not bind the default event handlers during initialization.
 *
 * @namespace BackendCustomers
 */
var BackendProfile = {
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

        BackendProfile.helper = new CustomersHelper();

        $('#customer-appointments').jScrollPane();

        if (bindEventHandlers) BackendProfile.bindEventHandlers();        
    },

    /**
     * Binds the default event handlers of the backend reports page. Do not use this method
     * if you include the "BackendReports namespace on another page.
     */
    bindEventHandlers: function() {
        CustomersHelper.prototype.bindEventHandlers();
    }
};

/**
 * This class contains the methods that are used in the backend customers page.
 * 
 * @class CustomersHelper
 */
var CustomersHelper = function() {
    this.filterResults = {};
};

/**
 * Binds the default event handlers of the backend customers page.
 */
CustomersHelper.prototype.bindEventHandlers = function() {
	BackendProfile.helper.display(GlobalVariables.user);
	
    /**
     * Event: Appointment Row "Click"
     * 
     * Display appointment data of the selected row.
     */
    $(document).on('click', '.appointment-row', function() {
        $('#customer-appointments .selected-row').removeClass('selected-row');
        $(this).addClass('selected-row');

        var customerId = GlobalVariables.user.id;
        var appointmentId = $(this).attr('data-id');
        var appointment = {};

        $.each(BackendProfile.helper.filterResults, function(index, c) {
            $.each(c.appointments, function(index, a) {
                if (a.id == appointmentId) {
                    appointment = a;
                    return false;
                }
            });
        });

        BackendProfile.helper.displayAppointment(appointment);
    });

};

/**
 * Display appointment details on customers backend page.
 * 
 * @param {object} appointment Appointment data
 */
CustomersHelper.prototype.displayAppointment = function(appointment) {
    var start = Date.parse(appointment.start_datetime).toString('dd/MM/yyyy HH:mm');
    var end = Date.parse(appointment.end_datetime).toString('dd/MM/yyyy HH:mm');

    var html = 
            '<div>' + 
                '<strong>' + appointment.service.name + '</strong><br>' + 
                appointment.provider.first_name + ' ' + appointment.provider.last_name + '<br>' +
                start + ' - ' + end + '<br>' +
            '</div>';

    $('#appointment-details').html(html);
};

/**
 * Display a customer record into the form.
 * 
 * @param {object} customer Contains the customer record data.
 */
CustomersHelper.prototype.display = function(customer) {
    $('#customer-appointments').data('jsp').destroy();
    $('#customer-appointments').empty();
    $.each(customer.appointments, function(index, appointment) {
        var start = Date.parse(appointment.start_datetime).toString('dd/MM/yyyy HH:mm');
        var end = Date.parse(appointment.end_datetime).toString('dd/MM/yyyy HH:mm');
        var html = 
                '<div class="appointment-row" data-id="' + appointment.id + '">' + 
                    start + ' - ' + end + '<br>' +
                    appointment.service.name + ', ' + 
                    appointment.provider.first_name + ' ' + appointment.provider.last_name +
                '</div>';   
        $('#customer-appointments').append(html);
    });
    $('#customer-appointments').jScrollPane({ mouseWheelSpeed: 70 });
    
    $('#appointment-details').empty();
};