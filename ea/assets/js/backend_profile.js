/**
 * Backend Customers javasript namespace. Contains the main functionality 
 * of the backend customers page. If you need to use this namespace in a 
 * different page, do not bind the default event handlers during initialization.
 *
 * @namespace BackendCustomers
 */
var BackendProfile = {
    /**
     * Determines the functionality of the page.
     * 
     * @type {bool}
     */
    manageMode: false,

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

        if (GlobalVariables.manageMode === undefined) {
            BackendProfile.manageMode = false; // Default Value
        } else {
            BackendProfile.manageMode = GlobalVariables.manageMode;
        }

        $('#select-date').datepicker({
            dateFormat: 'dd-mm-yy',
            firstDay: 1, // Monday
            minDate: 0,
            defaultDate: Date.today(),
           
            dayNames: [EALang['sunday'], EALang['monday'], EALang['tuesday'], EALang['wednesday'], EALang['thursday'], EALang['friday'], EALang['saturday']],
            dayNamesShort: [EALang['sunday'].substr(0,3), EALang['monday'].substr(0,3), 
                    EALang['tuesday'].substr(0,3), EALang['wednesday'].substr(0,3), 
                    EALang['thursday'].substr(0,3), EALang['friday'].substr(0,3),
                    EALang['saturday'].substr(0,3)],
            dayNamesMin: [EALang['sunday'].substr(0,2), EALang['monday'].substr(0,2), 
                    EALang['tuesday'].substr(0,2), EALang['wednesday'].substr(0,2), 
                    EALang['thursday'].substr(0,2), EALang['friday'].substr(0,2),
                    EALang['saturday'].substr(0,2)],
            monthNames: [EALang['january'], EALang['february'], EALang['march'], EALang['april'],
                    EALang['may'], EALang['june'], EALang['july'], EALang['august'], EALang['september'],
                    EALang['october'], EALang['november'], EALang['december']],
            prevText: EALang['previous'],
            nextText: EALang['next'],
            currentText: EALang['now'],
            closeText: EALang['close'],
            
            onSelect: function(dateText, instance) {
                BackendProfile.getAvailableHours(dateText);
                BackendProfile.updateConfirmFrame();
            }
        });

        BackendProfile.helper = new CustomersHelper();

        $('#customer-appointments').jScrollPane();

        if (bindEventHandlers) BackendProfile.bindEventHandlers();  

        // If the manage mode is true, the appointments data should be
        // loaded by default.
        if (BackendProfile.manageMode) {
            // BackendProfile.applyAppointmentData(GlobalVariables.appointmentData,
            //         GlobalVariables.providerData, GlobalVariables.customerData);
        } else {
            $('#select-service').trigger('change'); // Load the available hours.
        }      
    },

    /**
     * Binds the default event handlers of the backend reports page. Do not use this method
     * if you include the "BackendReports namespace on another page.
     */
    bindEventHandlers: function() {
        /**
         * Event: Selected Service "Changed"
         * 
         * When the user clicks on a service, its available providers should 
         * become visible. 
         */
        $('#select-service').change(function() {
            var currServiceId = $('#select-service').val();
            $('#select-provider').empty();

            $.each(GlobalVariables.availableProviders, function(indexProvider, provider) {
                $.each(provider['services'], function(indexService, serviceId) {
                    // If the current provider is able to provide the selected service,
                    // add him to the listbox. 
                    if (serviceId == currServiceId) { 
                        var optionHtml = '<option value="' + provider['id'] + '">' 
                                + provider['first_name']  + ' ' + provider['last_name'] 
                                + '</option>';
                        $('#select-provider').append(optionHtml);
                    }
                });
            });

            BackendProfile.getAvailableHours($('#select-date').val());
            BackendProfile.updateConfirmFrame();
            BackendProfile.updateServiceDescription($('#select-service').val(), $('#service-description'));
        });

        /**
         * Event: Selected Provider "Changed"
         * 
         * Whenever the provider changes the available appointment
         * date - time periods must be updated.
         */
        $('#select-provider').change(function() {
            BackendProfile.getAvailableHours(Date.parse($('#select-date').datepicker('getDate')).toString('dd-MM-yyyy'));
            BackendProfile.updateConfirmFrame();
        });

        $('#available-hours').on('click', '.available-hour', function() {
            $('.selected-hour').removeClass('selected-hour');
            $(this).addClass('selected-hour');
            BackendProfile.updateConfirmFrame();
        });

        /**
         * Event: Book Appointment Form "Submit"
         * 
         * Before the form is submitted to the server we need to make sure that
         * in the meantime the selected appointment date/time wasn't reserved by
         * another customer or event. 
         */
        $('#book-appointment-submit').click(function(event) {
            var formData = jQuery.parseJSON($('input[name="post_data"]').val());
            
            var postData = {
                'id_users_provider' : formData['appointment']['id_users_provider'],
                'id_services'       : formData['appointment']['id_services'],
                'start_datetime'    : formData['appointment']['start_datetime'],
                'group_size'        : formData['appointment']['group_size'],
                'req_visit'         : formData['appointment']['req_visit'],
                'first_visit'       : formData['appointment']['first_visit']
            };
            
            if (GlobalVariables.manageMode) {
                postData.exclude_appointment_id = GlobalVariables.appointmentData.id;
            }
            
            var postUrl = GlobalVariables.baseUrl + 'appointments/ajax_check_datetime_availability';
            
            $.post(postUrl, postData, function(response) {
                ////////////////////////////////////////////////////////////////////////
                console.log('Check Date/Time Availability Post Response :', response);
                ////////////////////////////////////////////////////////////////////////
                
                if (response.exceptions) {
                    response.exceptions = GeneralFunctions.parseExceptions(response.exceptions);
                    GeneralFunctions.displayMessageBox('Unexpected Issues', 'Unfortunately '
                            + 'the check appointment time availability could not be completed. '
                            + 'The following issues occurred:');
                    $('#message_box').append(GeneralFunctions.exceptionsToHtml(response.exceptions));
                    return false;
                } 
                
                if (response === true) {
                    $('#book-appointment-form').submit();
                } else {
                    GeneralFunctions.displayMessageBox('Appointment Hour Taken', 'Unfortunately '
                            + 'the selected appointment hour is not available anymore. Please select '
                            + 'another hour.');
                    BackendProfile.getAvailableHours($('#select-date').val());
                }
            }, 'json');
        });

        CustomersHelper.prototype.bindEventHandlers();
    },

    /**
     * This function makes an ajax call and returns the available 
     * hours for the selected service, provider and date.
     * 
     * @param {string} selDate The selected date of which the available
     * hours we need to receive.
     */
    getAvailableHours: function(selDate) {
        $('#available-hours').empty();
        
        // Find the selected service duration (it is going to 
        // be send within the "postData" object).
        var selServiceDuration = 15; // Default value of duration (in minutes).
        $.each(GlobalVariables.availableServices, function(index, service) {
            if (service['id'] == $('#select-service').val()) {
                selServiceDuration = service['duration']; 
            }
        });
        
        // If the manage mode is true then the appointment's start 
        // date should return as available too.
        var appointmentId = (BackendProfile.manageMode) 
                ? GlobalVariables.appointmentData['id'] : undefined;

        var postData = {
            'service_id': $('#select-service').val(),
            'provider_id': $('#select-provider').val(),
            'selected_date': selDate,
            'service_duration': selServiceDuration,
            'manage_mode': BackendProfile.manageMode,
            'appointment_id': appointmentId,
            'group_size': $('#group_size').val(),
            'req_visit': $('#req_visit').val(),
            'first_visit': $('#first_visit').val()
        };

        // Make ajax post request and get the available hours.
        var ajaxurl = GlobalVariables.baseUrl + 'appointments/ajax_get_available_hours';
        jQuery.post(ajaxurl, postData, function(response) {
            ///////////////////////////////////////////////////////////////
            console.log('Get Available Hours JSON Response:', response);
            ///////////////////////////////////////////////////////////////
            
            if (!GeneralFunctions.handleAjaxExceptions(response)) return;

            // The response contains the available hours for the selected provider and
            // service. Fill the available hours div with response data. 
            if (response.length > 0) {
                var currColumn = 1;
                $('#available-hours').html('<div style="width:50px; float:left;"></div>');

                $.each(response, function(index, availableHour) {
                    if ((currColumn * 10) < (index + 1)) {
                        currColumn++;
                        $('#available-hours').append('<div style="width:50px; float:left;"></div>');
                    }

                    $('#available-hours div:eq(' + (currColumn - 1) + ')').append(
                            '<span class="available-hour">' + availableHour + '</span><br/>');
                });

                if (BackendProfile.manageMode) {
                    // Set the appointment's start time as the default selection.
                    $('.available-hour').removeClass('selected-hour');
                    $('.available-hour').filter(function() {
                        return $(this).text() === Date.parseExact(
                                GlobalVariables.appointmentData['start_datetime'],
                                'yyyy-MM-dd HH:mm:ss').toString('HH:mm');
                    }).addClass('selected-hour');
                } else {
                    // Set the first available hour as the default selection.
                    $('.available-hour:eq(0)').addClass('selected-hour');
                }

                BackendProfile.updateConfirmFrame();
                
            } else {
                $('#available-hours').text(EALang['no_available_hours']);
            }
        }, 'json');
    },

    /**
     * Every time this function is executed, it updates the confirmation
     * page with the latest customer settigns and input for the appointment 
     * booking.
     */
    updateConfirmFrame: function() {
        // Appointment Details
        var selectedDate = $('#select-date').datepicker('getDate');
        if (selectedDate !== null) {
            selectedDate = Date.parse(selectedDate).toString('dd/MM/yyyy');
        }

        var selServiceId = $('#select-service').val();
        var servicePrice, serviceCurrency;
        $.each(GlobalVariables.availableServices, function(index, service) {
            if (service.id == selServiceId) {
                // servicePrice = '<br>' + service.price;
                // serviceCurrency = service.currency;
                return false; // break loop
            }
        });

        $('#confirm-details').html(
            '<h4>' + $('#select-service option:selected').text() + '</h4>' +  
            '<p>' 
                + '<strong class="text-info">' 
                    + $('#select-provider option:selected').text() + '<br>'
                    + selectedDate + ' ' +  $('.selected-hour').text() 
// Turn Off Currency                    + servicePrice + ' ' + serviceCurrency
                + '</strong>' + 
            '</p>'
        );

        // Customer Details
        $('#customer-details').html(
            '<h4>' + $('#first-name').val() + ' ' + $('#last-name').val() + '</h4>' + 
            '<p>' + 
 //             EALang['password'] + ': ' + $('#password').val() + 
 //             '<br/>' + 
                EALang['email'] + ': ' + $('#email').val() + 
                '<br/>' + 
                EALang['address'] + ': ' + $('#address').val() + 
                '<br/>' + 
                EALang['city'] + ': ' + $('#city').val() + 
                '<br/>' + 
                EALang['zip_code'] + ': ' + $('#zip-code').val() + 
            '</p>'
        );
            
        // Update appointment form data for submission to server when the user confirms
        // the appointment.
        var postData = new Object();
        
        postData['customer'] = {
            'last_name': GlobalVariables.customer.last_name,
            'first_name': GlobalVariables.customer.first_name,
            'email': GlobalVariables.customer.email,
            'major': GlobalVariables.customer.major,
            'year': GlobalVariables.customer.year,
            'esl': GlobalVariables.customer.esl
        };
        
        postData['appointment'] = {
            'start_datetime': $('#select-date').datepicker('getDate').toString('yyyy-MM-dd') 
                                    + ' ' + $('.selected-hour').text() + ':00',
            'end_datetime': BackendProfile.calcEndDatetime(),
            'notes': $('#notes').val(),
            'is_unavailable': false,
            'id_users_provider': $('#select-provider').val(),
            'id_services': $('#select-service').val(),
            'group_size': $('#group_size').val(),
            'req_visit': $('#req_visit').val(),
            'first_visit': $('#first_visit').val()
        };
        
        postData['manage_mode'] = BackendProfile.manageMode;
        
        if (BackendProfile.manageMode) {
            postData['appointment']['id'] = GlobalVariables.appointmentData['id'];
            postData['customer']['id'] = GlobalVariables.customerData['id'];
        }
        
        $('input[name="post_data"]').val(JSON.stringify(postData));
    },

    /** 
     * This method calculates the end datetime of the current appointment. 
     * End datetime is depending on the service and start datetime fieldss.
     * 
     * @return {string} Returns the end datetime in string format.
     */
    calcEndDatetime: function() {
        // Find selected service duration. 
        var selServiceDuration = undefined;
        
        $.each(GlobalVariables.availableServices, function(index, service) {
            if (service.id == $('#select-service').val()) {
                selServiceDuration = service.duration;
                return false; // Stop searching ... 
            }
        });
        
        // Add the duration to the start datetime.
        var startDatetime = $('#select-date').datepicker('getDate').toString('dd-MM-yyyy') 
                + ' ' + $('.selected-hour').text();
        startDatetime = Date.parseExact(startDatetime, 'dd-MM-yyyy HH:mm');
        var endDatetime = undefined;
        
        if (selServiceDuration !== undefined && startDatetime !== null) {
            endDatetime = startDatetime.add({ 'minutes' : parseInt(selServiceDuration) });
        } else {
            endDatetime = new Date();
        }
        
        return endDatetime.toString('yyyy-MM-dd HH:mm:ss');
    },

    /**
     * This method updates a div's html content with a brief description of the 
     * user selected service (only if available in db). This is usefull for the 
     * customers upon selecting the correct service.
     * 
     * @param {int} serviceId The selected service record id.
     * @param {object} $div The destination div jquery object (e.g. provide $('#div-id') 
     * object as value).
     */
    updateServiceDescription: function(serviceId, $div) {
        var html = ''; 
        
        $.each(GlobalVariables.availableServices, function(index, service) {
            if (service.id == serviceId) { // Just found the service.
                html = '<strong>' + service.name + ' </strong>';
                
                if (service.description != '' && service.description != null) {
                    html += '<br>' + service.description + '<br>';
                }
                
                if (service.duration != '' && service.duration != null) {
                    html += '[' + EALang['duration'] + ' ' + service.duration 
                            + ' ' + EALang['minutes'] + '] ';
                }
          
                html += '<br>';
                
                return false;
            }
        });
        
        $div.html(html);
        
        if (html != '') {
            $div.show();
        } else {
            $div.hide();
        }
        
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
        var appointmentID = $(this).attr('data-id');
        var appointment = {};

        $.each(GlobalVariables.user.appointments, function(index, a) {
            if (a.id == appointmentID) {
                appointment = a;
                return false;
            }
        });

        // $.each(BackendProfile.helper.filterResults, function(index, c) {
        //     $.each(c.appointments, function(index, a) {
        //         if (a.id == appointmentId) {
        //             appointment = a;
        //             return false;
        //         }
        //     });
        // });

        BackendProfile.helper.displayAppointment(appointment);
    });

};

/**
 * Display appointment details on customers backend page.
 * 
 * @param {object} appointment Appointment data
 */
CustomersHelper.prototype.displayAppointment = function(appointment) {
    var start = Date.parse(appointment.start_datetime).toString('MM/dd/yyyy HH:mm');
    var end = Date.parse(appointment.end_datetime).toString('MM/dd/yyyy HH:mm');

    var html = 
            '<div>' + 
                '<strong>' + appointment.service_name + '</strong><br>' + 
                appointment.provider_first_name + ' ' + appointment.provider_last_name + '<br>' +
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
        var start = Date.parse(appointment.start_datetime).toString('MM/dd/yyyy HH:mm');
        var end = Date.parse(appointment.end_datetime).toString(); //'dd/MM/yyyy HH:mm:ss');
        var html = 
                '<div class="appointment-row" data-id="' + appointment.id + '">' + 
                    start + /*' - ' + end  + */'<br>' +
                    appointment.service_name + ' with ' + 
                    appointment.provider_first_name + ' ' + appointment.provider_last_name +
                '</div>';   
        $('#customer-appointments').append(html);
    });
    $('#customer-appointments').jScrollPane({ mouseWheelSpeed: 70 });
    
    $('#appointment-details').empty();
};