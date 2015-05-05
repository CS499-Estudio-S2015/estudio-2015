<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
		
		// Set user's selected language.        
        if ($this->session->userdata('language')) {
        	$this->config->set_item('language', $this->session->userdata('language'));
        	$this->lang->load('translations', $this->session->userdata('language'));
        } else {
        	$this->lang->load('translations', $this->config->item('language')); // default
        }	
    }
    
    /**
     * Display the main backend page.
     * 
     * This method displays the main backend page. All users login permission can 
     * view this page which displays a calendar with the events of the selected 
     * provider or service. If a user has more priviledges he will see more menus  
     * at the top of the page.
     * 
     * @param string $appointment_hash If given, the appointment edit dialog will 
     * appear when the page loads.
     */
    public function index($appointment_hash = '') {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . 'backend');
        if (!$this->hasPrivileges(PRIV_APPOINTMENTS)) return;

        $this->load->model('appointments_model');
        $this->load->model('providers_model');
        $this->load->model('services_model');
        $this->load->model('customers_model');
        $this->load->model('settings_model');
        $this->load->model('roles_model');
        $this->load->model('user_model');
        $this->load->model('secretaries_model');
        
        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $view['active_menu'] = PRIV_APPOINTMENTS;
        $view['book_advance_timeout'] = $this->settings_model->get_setting('book_advance_timeout');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['available_providers'] = $this->providers_model->get_available_providers();
        $view['available_services'] = $this->services_model->get_available_services();
        $view['customers'] = $this->customers_model->get_batch();
        $this->setUserData($view);
        
        if ($this->session->userdata('role_slug') == DB_SLUG_SECRETARY) {
            $secretary = $this->secretaries_model->get_row($this->session->userdata('user_id'));
            $view['secretary_providers'] = $secretary['providers'];
        } else {
            $view['secretary_providers'] = array();
        }
        
        $results = $this->appointments_model->get_batch(array('hash' => $appointment_hash));
        if ($appointment_hash != '' && count($results) > 0) {
            $appointment = $results[0];
            $appointment['customer'] = $this->customers_model->get_row($appointment['id_users_customer']);
            $view['edit_appointment'] = $appointment; // This will display the appointment edit dialog on page load.
        } else {
            $view['edit_appointment'] = NULL;
        }
        
        $this->load->view('backend/header', $view);
        $this->load->view('backend/calendar', $view);
        $this->load->view('backend/footer', $view);
    }
    
    /**
     * Display the backend customers page.
     * 
     * In this page the user can manage all the customer records of the system.
     */
    public function customers() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . 'backend/customers');
    	if (!$this->hasPrivileges(PRIV_CUSTOMERS)) return;
    	
        $this->load->model('providers_model');
        $this->load->model('customers_model');
        $this->load->model('services_model');
        $this->load->model('settings_model');
        $this->load->model('user_model');
        
        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $view['active_menu'] = PRIV_CUSTOMERS;
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['customers'] = $this->customers_model->get_batch();
        $view['available_providers'] = $this->providers_model->get_available_providers();
        $view['available_services'] = $this->services_model->get_available_services();
        $this->setUserData($view);
        
        $this->load->view('backend/header', $view);
        $this->load->view('backend/customers', $view);
        $this->load->view('backend/footer', $view);
    }
    
    /**
     * Displays the backend services page. 
     * 
     * Here the admin user will be able to organize and create the services 
     * that the user will be able to book appointments in frontend. 
     * 
     * NOTICE: The services that each provider is able to service is managed 
     * from the backend services page. 
     */
    public function services() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . 'backend/services');
        if (!$this->hasPrivileges(PRIV_SERVICES)) return;
        
        $this->load->model('customers_model');
        $this->load->model('services_model');
        $this->load->model('settings_model');
        $this->load->model('user_model');
        
        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $view['active_menu'] = PRIV_SERVICES;
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['services'] = $this->services_model->get_batch();
        $view['categories'] = $this->services_model->get_all_categories();
        $this->setUserData($view);
        
        $this->load->view('backend/header', $view);
        $this->load->view('backend/services', $view);
        $this->load->view('backend/footer', $view);
    }
    
    /**
     * Display the backend users page.
     * 
     * In this page the admin user will be able to manage the system users. 
     * By this, we mean the provider, secretary and admin users. This is also
     * the page where the admin defines which service can each provider provide.
     */
    public function users() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . 'backend/users');
        if (!$this->hasPrivileges(PRIV_USERS)) return;
        
        $this->load->model('providers_model');
        $this->load->model('secretaries_model');
        $this->load->model('admins_model');
        $this->load->model('services_model');
        $this->load->model('settings_model');
        $this->load->model('user_model');
        
        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $view['active_menu'] = PRIV_USERS;
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['admins'] = $this->admins_model->get_batch();
        $view['providers'] = $this->providers_model->get_batch();
        $view['secretaries'] = $this->secretaries_model->get_batch();
        $view['services'] = $this->services_model->get_batch(); 
        $view['working_plan'] = $this->settings_model->get_setting('company_working_plan');
        $this->setUserData($view);
        
        $this->load->view('backend/header', $view);
        $this->load->view('backend/users', $view);
        $this->load->view('backend/footer', $view);
    }

    /**
     * Display the report interface.
     */
    public function reports() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . 'backend/reports');
        if (!$this->hasPrivileges(PRIV_REPORTS)) return;

        $this->load->model('settings_model');
        $this->load->model('user_model');

        $view['base_url'] = $this->config->item('base_url');
        $view['active_menu'] = PRIV_REPORTS;
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $this->setUserData($view);

        $this->load->view('backend/header', $view);
        $this->load->view('backend/reports', $view);
        $this->load->view('backend/footer', $view);
    }
    
    /**
     * Display the user/system settings.
     * 
     * This page will display the user settings (name, password etc). If current user is
     * an administrator, then he will be able to make change to the current Easy!Appointment 
     * installation (core settings like company name, book timeout etc). 
     */
    public function settings() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . 'backend/settings');
        if (!$this->hasPrivileges(PRIV_SYSTEM_SETTINGS, FALSE)
                && !$this->hasPrivileges(PRIV_USER_SETTINGS)) return;
        
        $this->load->model('settings_model');
        $this->load->model('user_model');
        
        $this->load->library('session');        
        $user_id = $this->session->userdata('user_id'); 
        
        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->user_model->get_user_display_name($user_id);
        $view['active_menu'] = PRIV_SYSTEM_SETTINGS;
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['role_slug'] = $this->session->userdata('role_slug');
        $view['system_settings'] = $this->settings_model->get_settings();
        $view['user_settings'] = $this->user_model->get_settings($user_id);
        $this->setUserData($view);
        
        $this->load->view('backend/header', $view);
        $this->load->view('backend/settings', $view);
        $this->load->view('backend/footer', $view);
    }

    /**
     * Displays interface for logged in customers to make an appointment.
     */
    public function profile() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . 'backend/profile');
        if (!$this->hasPrivileges(PRIV_MAKE)) return;

        $this->load->model('settings_model');
        $this->load->model('user_model');
        $this->load->model('appointments_model');
        $this->load->model('services_model');
        $this->load->model('providers_model');
        $this->load->model('customers_model');

        $view['base_url'] = $this->config->item('base_url');
        $view['active_menu'] = PRIV_MAKE;
        $view['available_providers'] = $this->providers_model->get_available_providers();
        $view['available_services'] = $this->services_model->get_available_services();
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['appointments'] = $this->appointments_model->get_profile_appt($this->session->userdata('user_id'));
        $view['manage_mode'] = FALSE;

        if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
            try {
                $post_data = json_decode($_POST['post_data'], true);
                var_dump($post_data);
                $appointment = $post_data['appointment'];
                $customer = $post_data['customer'];

                if ($this->customers_model->exists($customer)) 
                        $customer['id'] = $this->customers_model->find_record_id($customer);
                    
                $customer_id = $this->customers_model->add($customer);
                $appointment['id_users_customer'] = $customer_id; 
                
                $appointment['id'] = $this->appointments_model->add($appointment);
                $appointment['hash'] = $this->appointments_model->get_value('hash', $appointment['id']);
                
                $provider = $this->providers_model->get_row($appointment['id_users_provider']);
                $service = $this->services_model->get_row($appointment['id_services']);
                
                $company_settings = array( 
                    'company_name'  => $this->settings_model->get_setting('company_name'),
                    'company_link'  => $this->settings_model->get_setting('company_link'),
                    'company_email' => $this->settings_model->get_setting('company_email')
                );
                
                // :: SYNCHRONIZE APPOINTMENT WITH PROVIDER'S GOOGLE CALENDAR
                // The provider must have previously granted access to his google calendar account  
                // in order to sync the appointment.
                try {
                    $google_sync = $this->providers_model->get_setting('google_sync', 
                            $appointment['id_users_provider']);

                    if ($google_sync == TRUE) {
                        $google_token = json_decode($this->providers_model
                                ->get_setting('google_token', $appointment['id_users_provider']));

                        $this->load->library('google_sync');
                        $this->google_sync->refresh_token($google_token->refresh_token);

                        if ($post_data['manage_mode'] === FALSE) {
                            // Add appointment to Google Calendar.
                            $google_event = $this->google_sync->add_appointment($appointment, $provider, 
                                    $service, $customer, $company_settings);
                            $appointment['id_google_calendar'] = $google_event->id;
                            $this->appointments_model->add($appointment); 
                        } else {
                            // Update appointment to Google Calendar.
                            $appointment['id_google_calendar'] = $this->appointments_model
                                    ->get_value('id_google_calendar', $appointment['id']);

                            $this->google_sync->update_appointment($appointment, $provider,
                                    $service, $customer, $company_settings);
                        }
                    }  
                } catch(Exception $exc) {
                    $view['exceptions'][] = $exc;
                }
                
                // :: SEND NOTIFICATION EMAILS TO BOTH CUSTOMER AND PROVIDER
                try {
                    $this->load->library('Notifications');
                    
                    $send_provider = $this->providers_model
                            ->get_setting('notifications', $provider['id']);
                    
                    if (!$post_data['manage_mode']) {
                        $customer_title = $this->lang->line('appointment_booked');
                        $customer_message = $this->lang->line('thank_your_for_appointment');
                        $customer_link = $this->config->item('base_url') . 'appointments/index/' 
                                . $appointment['hash'];

                        $provider_title = $this->lang->line('appointment_added_to_your_plan');
                        $provider_message = $this->lang->line('appointment_link_description');
                        $provider_link = $this->config->item('base_url') . 'backend/index/' 
                                . $appointment['hash'];
                    } else {
                        $customer_title = $this->lang->line('appointment_changes_saved');
                        $customer_message = '';
                        $customer_link = $this->config->item('base_url') . 'appointments/index/' 
                                . $appointment['hash'];

                        $provider_title = $this->lang->line('appointment_details_changed');
                        $provider_message = '';
                        $provider_link = $this->config->item('base_url') . 'backend/index/' 
                                . $appointment['hash'];
                    }

                    $this->notifications->send_appointment_details($appointment, $provider, 
                            $service, $customer,$company_settings, $customer_title, 
                            $customer_message, $customer_link, $customer['email']);
                    
                    if ($send_provider == TRUE) {
                        $this->notifications->send_appointment_details($appointment, $provider, 
                                $service, $customer, $company_settings, $provider_title, 
                                $provider_message, $provider_link, $provider['email']);
                    }
                } catch(Exception $exc) {
                    $view['exceptions'][] = $exc;
                }
                
                // :: LOAD THE BOOK SUCCESS VIEW
                $view['appointment_data'] = $appointment;
                $view['provider_data'] = $provider;
                $view['service_data'] = $service;

            } catch(Exception $exc) {
                $view['exceptions'][] = $exc;
            }

            
        } else {
            
        }

        $this->setUserData($view);


        $view['customer'] = $this->customers_model->get_row($view['user_id']);
        
        $this->load->view('backend/header', $view);
        $this->load->view('backend/profile', $view);
        $this->load->view('backend/footer', $view);
    }
    
    /**
     * Check whether current user is logged in and has the required privileges to 
     * view a page. 
     * 
     * The backend page requires different privileges from the users to display pages. Not all
     * pages are avaiable to all users. For example secretaries should not be able to edit the
     * system users.
     * 
     * @see Constant Definition In application/config/constants.php
     * 
     * @param string $page This argument must match the roles field names of each section 
     * (eg "appointments", "users" ...).
     * @param bool $redirect (OPTIONAL - TRUE) If the user has not the required privileges
     * (either not logged in or insufficient role privileges) then the user will be redirected  
     * to another page. Set this argument to FALSE when using ajax.
     * @return bool Returns whether the user has the required privileges to view the page or
     * not. If the user is not logged in then he will be prompted to log in. If he hasn't the
     * required privileges then an info message will be displayed.
     */
    private function hasPrivileges($page, $redirect = TRUE) {       
        // Check if user is logged in.
        $user_id = $this->session->userdata('user_id');
        if ($user_id == FALSE) { // User not logged in, display the login view.
            if ($redirect) {
                header('Location: ' . $this->config->item('base_url') . 'user/login');
            }
            return FALSE;
        }
        
        // Check if the user has the required privileges for viewing the selected page.
        $role_slug = $this->session->userdata('role_slug');
        $role_priv = $this->db->get_where('ea_roles', array('slug' => $role_slug))->row_array();
        if ($role_priv[$page] < PRIV_VIEW) { // User does not have the permission to view the page.
             if ($redirect) {
                if ($role_slug == DB_SLUG_CUSTOMER) {
                    header('Location: ' . $this->config->item('base_url') . 'backend/profile');
                } else {
                    header('Location: ' . $this->config->item('base_url') . 'user/no_privileges');
                }
                
            }
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * Set the user data in order to be available at the view and js code.
     * 
     * @param array $view Contains the view data. 
     */
    public function setUserData(&$view) {
        $this->load->model('roles_model');
        
        // Get privileges
        $view['user_id'] = $this->session->userdata('user_id');
        $view['user_email'] = $this->session->userdata('user_email');
        $view['role_slug'] = $this->session->userdata('role_slug');
        $view['privileges'] = $this->roles_model->get_privileges($this->session->userdata('role_slug'));
    }

    /**
     * This method will update the installation to the latest available 
     * version in the server. IMPORTANT: The code files must exist in the
     * server, this method will not fetch any new files but will update 
     * the database schema.
     *
     * This method can be used either by loading the page in the browser
     * or by an ajax request. But it will answer with json encoded data.
     */
    public function update() {
        try {
            if (!$this->hasPrivileges(PRIV_SYSTEM_SETTINGS, TRUE)) 
                throw new Exception('You do not have the required privileges for this task!');

            $this->load->library('migration');

            if (!$this->migration->current()) 
                throw new Exception($this->migration->error_string());
            
            echo json_encode(AJAX_SUCCESS);

        } catch(Exception $exc) {
            echo json_encode(array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ));
        }       
    }
}

/* End of file backend.php */
/* Location: ./application/controllers/backend.php */