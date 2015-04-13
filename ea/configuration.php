<?php
class SystemConfiguration {
    // General Settings
    public static $base_url    = 'http://localhost/estudio-2015/ea/';
    
    // Database Settings
    public static $db_host     = 'localhost';
    // public static $db_name     = 'test_db';
    public static $db_name     = 'estudio_beta';
    public static $db_username = 'root';
    public static $db_password = '';
    
    // Google Calendar API Settings
    public static $google_sync_feature  = FALSE; // Enter TRUE or FALSE;
    public static $google_product_name  = '';
    public static $google_client_id     = '';
    public static $google_client_secret = '';
    public static $google_api_key       = '';
}

/* End of file configuration.php */
/* Location: ./configuration.php */