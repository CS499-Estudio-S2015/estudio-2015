<script type="text/javascript" 
        src="<?php echo $base_url; ?>assets/js/backend_profile.js"></script>

<script type="text/javascript">    
    var GlobalVariables = {
        'baseUrl': <?php echo '"' . $base_url . '"'; ?>,
        'user'                  : {
            'id'        : <?php echo $user_id; ?>,
            'email'     : <?php echo '"' . $user_email . '"'; ?>,
            'role_slug' : <?php echo '"' . $role_slug . '"'; ?>,
            'privileges': <?php echo json_encode($privileges); ?>,
            'customer' : <?php echo json_encode($customer); ?>
        }
    };

    $(document).ready(function() {
        BackendProfile.initialize(true);
    });
</script>

<div id="profile-page" class="row-fluid">
    <div class="details span7 row-fluid">
        <div class="span5">
            <h2><?php echo $this->lang->line('appointments'); ?></h2>
            <div id="customer-appointments"></div>
            <div id="appointment-details"></div>
        </div>
    </div>
    
    <?php
        // -------------------------------------------------------------- 
        //        
        // CURRENT REPORTS TAB 
        // 
        // --------------------------------------------------------------
    ?>

    
</div>