<script type="text/javascript" 
        src="<?php echo $base_url; ?>assets/js/backend_reports.js"></script>

<script type="text/javascript">    
    var GlobalVariables = {
        'baseUrl': <?php echo '"' . $base_url . '"'; ?>,
        'user'                  : {
            'id'        : <?php echo $user_id; ?>,
            'email'     : <?php echo '"' . $user_email . '"'; ?>,
            'role_slug' : <?php echo '"' . $role_slug . '"'; ?>,
            'privileges': <?php echo json_encode($privileges); ?>
        }
    };

    $(document).ready(function() {
        BackendReports.initialize(true);
    });

    $(".report_btn").click(function(){
   var url = $(this).attr("data");
       //alert(url);
       $.ajax ({
          url: url+".php",//pass the url here or you can use whatever I used .php. And do the other stuff etc.
       });
    });
</script>

<script type="text/javascript"
    src="<?php echo $base_url; ?>assets/js/backend_reports_select.js"></script>

<div id="reports-page" class="row-fluid">
    THIS PAGE WILL BE USED TO MAKE APPOINTMENTS
    <!--ul class="nav nav-tabs">
        <li class="current-tab tab active"><a><?php echo $this->lang->line('current'); ?></a></li>
        <li class="historic-tab tab"><a><?php echo $this->lang->line('historic'); ?></a></li>
    </ul-->
    
    <?php
        // -------------------------------------------------------------- 
        //        
        // CURRENT REPORTS TAB 
        // 
        // --------------------------------------------------------------
    ?>
    <!-- div to display all scheduled appointments for customer -->
    <div id="current" class="tab-content">   

    </div>


    <?php
        // -------------------------------------------------------------- 
        //        
        // HISTORIC REPORTS TAB 
        // 
        // --------------------------------------------------------------
    ?>
    <!-- div to make appointment; will probably need to pane like wizard -->
    <div id="historic" class="tab-content">   

    </div>
    
</div>