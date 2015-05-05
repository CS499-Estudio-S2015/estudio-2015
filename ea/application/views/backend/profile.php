<script type="text/javascript" 
        src="<?php echo $base_url; ?>assets/js/backend_profile.js"></script>

<script type="text/javascript">    
    var GlobalVariables = {
        'baseUrl': <?php echo '"' . $base_url . '"'; ?>,
        'availableProviders'    : <?php echo json_encode($available_providers); ?>,
        'availableServices'     : <?php echo json_encode($available_services); ?>,  
        'manageMode'            : <?php echo ($manage_mode) ? 'true' : 'false'; ?>,
        'customer'              : <?php echo json_encode($customer); ?>,
        'user'                  : {
            'id'            : <?php echo $user_id; ?>,
            'email'         : <?php echo '"' . $user_email . '"'; ?>,
            'role_slug'     : <?php echo '"' . $role_slug . '"'; ?>,
            'privileges'    : <?php echo json_encode($privileges); ?>,
            'appointments'  : <?php echo json_encode($appointments); ?>
        }
    };

    $(document).ready(function() {
        BackendProfile.initialize(true);
    });
</script>

<div id="profile-page" class="row-fluid">
    <div class="details span3 row-fluid">
        <div class="span6">
            <h2><?php echo $this->lang->line('appointments'); ?></h2>
            <button id="insert-appointment" class="btn btn-info" style="margin: 10px 0px 10px 0px;"
                    title="<?php echo $this->lang->line('new_appointment_hint'); ?>">
                <i class="icon-plus icon-white"></i>
                <span><?php echo $this->lang->line('new_appointment'); ?></span>
            </button>
            <div id="customer-appointments"></div>
            <div id="appointment-details"></div>
        </div>
    </div>
    <div class="make span6 row-fluid">
        <div class="span6">
            <div class="span5">
                <label for="select-service">
                    <strong><?php echo $this->lang->line('select_service'); ?></strong>
                </label>
                
                <select id="select-service">
                    <?php 
                        // Group services by category, only if there is at least one service 
                        // with a parent category.
                        foreach($available_services as $service) {
                            if ($service['category_id'] != NULL) {
                                $has_category = TRUE;
                                break;
                            }
                        }
                        
                        if ($has_category) {
                            $grouped_services = array();

                            foreach($available_services as $service) {
                                if ($service['category_id'] != NULL) {
                                    if (!isset($grouped_services[$service['category_name']])) {
                                        $grouped_services[$service['category_name']] = array();
                                    }

                                    $grouped_services[$service['category_name']][] = $service;
                                } 
                            }

                            // We need the uncategorized services at the end of the list so
                            // we will use another iteration only for the uncategorized services.
                            $grouped_services['uncategorized'] = array();
                            foreach($available_services as $service) {
                                if ($service['category_id'] == NULL) {
                                    $grouped_services['uncategorized'][] = $service;
                                }
                            }

                            foreach($grouped_services as $key => $group) {
                                $group_label = ($key != 'uncategorized')
                                        ? $group[0]['category_name'] : 'Uncategorized';
                                
                                if (count($group) > 0) {
                                    echo '<optgroup label="' . $group_label . '">';
                                    foreach($group as $service) {
                                        echo '<option value="' . $service['id'] . '">' 
                                            . $service['name'] . '</option>';
                                    }
                                    echo '</optgroup>';
                                }
                            }
                        }  else {
                            foreach($available_services as $service) {
                                echo '<option value="' . $service['id'] . '">' 
                                            . $service['name'] . '</option>';
                            }
                        }
                    ?>
                </select>

                <label for="select-provider">
                    <strong><?php echo $this->lang->line('select_provider'); ?></strong>
                </label>
                
                <select id="select-provider"></select>

                <label for="group_size">
                    <strong><?php echo $this->lang->line('group_size'); ?></strong>
                </label>
                
                <select id="group_size">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>

                <label for="req_visit">
                    <strong><?php echo $this->lang->line('req_visit'); ?></strong>                         
                </label>
                <select id="req_visit">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                    
                <label for="first_visit"> 
                    <strong><?php echo $this->lang->line('first_visit'); ?></strong>
                </label>
                <select id="first_visit">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>
        <div class="span6">
            <div class="span10">
                <div id="select-date"></div>
                <?php // Available hours are going to be fetched via ajax call. ?>
                <div id="available-hours"></div>
                <form id="book-appointment-form" style="display:inline-block;" method="post">
                    <button id="book-appointment-submit" type="button" class="btn btn-success">
                        <i class="icon-ok icon-white"></i>
                        <?php
                            echo (!$manage_mode) ? $this->lang->line('confirm')
                                    : $this->lang->line('update');
                        ?>
                    </button>
                    <input type="hidden" name="post_data" />
                </form>
            </div>
        </div>
    </div>    
</div>