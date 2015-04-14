<?php include('reports_methods.php'); ?>

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
</script>

<div id="reports-page" class="row-fluid">
    <ul class="nav nav-tabs">
        <li class="current-tab tab active"><a><?php echo $this->lang->line('current'); ?></a></li>
        <li class="historic-tab tab"><a><?php echo $this->lang->line('historic'); ?></a></li>
    </ul>
    
    <?php
        // -------------------------------------------------------------- 
        //        
        // CURRENT REPORTS TAB 
        // 
        // --------------------------------------------------------------
    ?>
    <!-- CONTENT BOX -->
    <div id="current" class="tab-content">   
        <div class="report-grid">
            <h2>Overall Performance</h2>
            <?php getCurrentOverall(); ?>
        </div>
        <div class="report-grid">
            <h2>Service</h2>
            <?php getCurrentService(); ?>
        </div>
        <div class="report-grid">
            <h2>Academic Year</h2>
            <?php getCurrentYear(); ?>
        </div>
        <div class="report-grid">
            <h2>Major</h2>
            <?php getCurrentMajor(); ?>
        </div>
        <div class="report-grid">
            <h2>First Visit</h2>
            <?php getCurrentFirstVisit(); ?>
        </div>
        <div class="report-grid">
            <h2>English as Second Language</h2>
            <?php getCurrentEnglish(); ?>
        </div>
        <!--div class="report-grid">
            <?php 
                // TODO:
                // getCurrentRequired(); 
            ?>
        </div-->
    </div>


    <?php
        // -------------------------------------------------------------- 
        //        
        // HISTORIC REPORTS TAB 
        // 
        // --------------------------------------------------------------
    ?>
    <div id="historic" class="tab-content">   
        <div class="report-grid">
            <h2>Overall Performance</h2>
            <form action="" name="overall" method="post">
                <?php 
                    if (!isset($_POST['overall'])) {
                        $_POST['overall'] = "month";
                    }
                    getHistoricOverall($_POST['overall']); 
                    $overallMonthCheck = ($_POST['overall'] == "month") ? " checked" : "";
                    $overallSemCheck = ($_POST['overall'] == "semester") ? " checked" : "";
                    $overallYearCheck = ($_POST['overall'] == "year") ? " checked" : "";

                    echo "\t\t\t\t<br />\n";
                    echo "\t\t\t\t<input type='radio' name='overall' onclick='javascript: submit()' value='month'" . $overallMonthCheck . ">Monthly\n";
                    echo "\t\t\t\t<input type='radio' name='overall' onclick='javascript: submit()' value='semester'" . $overallSemCheck . ">Semester\n";
                    echo "\t\t\t\t<input type='radio' name='overall' onclick='javascript: submit()' value='year'" . $overallYearCheck . ">Yearly\n";
                ?>              
            </form>
        </div>
        <div class="report-grid">
            <h2>Service</h2>
            <form action="" name="service" method="post">
                <?php 
                    if (!isset($_POST['service'])) {
                        $_POST['service'] = "month";
                    }
                    getHistoricService($_POST['service']); 
                    $servMonthCheck = ($_POST['service'] == "month") ? " checked" : "";
                    $servSemCheck = ($_POST['service'] == "semester") ? " checked" : "";
                    $servYearCheck = ($_POST['service'] == "year") ? " checked" : "";

                    echo "\t\t\t\t<br />\n";
                    echo "\t\t\t\t<input type='radio' name='service' onclick='javascript: submit()' value='month'" . $servMonthCheck . ">Monthly\n";
                    echo "\t\t\t\t<input type='radio' name='service' onclick='javascript: submit()' value='semester'" . $servSemCheck . ">Semester\n";
                    echo "\t\t\t\t<input type='radio' name='service' onclick='javascript: submit()' value='year'" . $servYearCheck . ">Yearly\n";
                ?>              
            </form>
        </div>
        <div class="report-grid">
            <h2>Academic Year</h2>
            <form action="" name="year" method="post">
                <?php 
                    if(!isset($_POST['year'])) {
                        $_POST['year'] = "month";
                    }
                    getHistoricYear($_POST['year']); 
                    
                    $yearMonthCheck = ($_POST['year'] == "month") ? " checked" : "";
                    $yearSemCheck = ($_POST['year'] == "semester") ? " checked" : "";
                    $yearYearCheck = ($_POST['year'] == "year") ? " checked" : "";
                    

                    echo "\t\t\t\t<br />\n";
                    echo "\t\t\t\t<input type='radio' name='year' onclick='javascript: submit()' value='month'" . $yearMonthCheck . ">Monthly\n";
                    echo "\t\t\t\t<input type='radio' name='year' onclick='javascript: submit()' value='semester'" . $yearSemCheck . ">Semester\n";
                    echo "\t\t\t\t<input type='radio' name='year' onclick='javascript: submit()' value='year'" . $yearYearCheck . ">Yearly\n";
                ?>              
            </form>
        </div>
        <div class="report-grid">
            <h2>Major</h2>
            <form action="" name="major" method="post">
                <?php 
                    if(!isset($_POST['major'])) {
                        $_POST['major'] = "month";
                    }
                    getHistoricMajor($_POST['major']); 
                    
                    $majorMonthCheck = ($_POST['major'] == "month") ? " checked" : "";
                    $majorSemCheck = ($_POST['major'] == "semester") ? " checked" : "";
                    $majorYearCheck = ($_POST['major'] == "year") ? " checked" : "";
                    

                    echo "\t\t\t\t<br />\n";
                    echo "\t\t\t\t<input type='radio' name='major' onclick='javascript: submit()' value='month'" . $majorMonthCheck . ">Monthly\n";
                    echo "\t\t\t\t<input type='radio' name='major' onclick='javascript: submit()' value='semester'" . $majorSemCheck . ">Semester\n";
                    echo "\t\t\t\t<input type='radio' name='major' onclick='javascript: submit()' value='year'" . $majorYearCheck . ">Yearly\n";
                ?>              
            </form>
        </div>
        <div class="report-grid">
            <h2>First Visit</h2>
            <form action="" name="firstVisit" method="post">
                <?php 
                    if(!isset($_POST['firstVisit'])) {
                        $_POST['firstVisit'] = "month";
                    }
                    getHistoricFirstVisit($_POST['firstVisit']); 
                    
                    $firstVisitMonthCheck = ($_POST['firstVisit'] == "month") ? " checked" : "";
                    $firstVisitSemCheck = ($_POST['firstVisit'] == "semester") ? " checked" : "";
                    $firstVisitYearCheck = ($_POST['firstVisit'] == "year") ? " checked" : "";
                    

                    echo "\t\t\t\t<br />\n";
                    echo "\t\t\t\t<input type='radio' name='firstVisit' onclick='javascript: submit()' value='month'" . $firstVisitMonthCheck . ">Monthly\n";
                    echo "\t\t\t\t<input type='radio' name='firstVisit' onclick='javascript: submit()' value='semester'" . $firstVisitSemCheck . ">Semester\n";
                    echo "\t\t\t\t<input type='radio' name='firstVisit' onclick='javascript: submit()' value='year'" . $firstVisitYearCheck . ">Yearly\n";
                ?>              
            </form>
        </div>
        <div class="report-grid">
            <h2>English as Second Language</h2>
            <form action="" name="english" method="post">
                <?php 
                    if(!isset($_POST['english'])) {
                        $_POST['english'] = "month";
                    }
                    getHistoricEnglish($_POST['english']); 
                    
                    $englishMonthCheck = ($_POST['english'] == "month") ? " checked" : "";
                    $englishSemCheck = ($_POST['english'] == "semester") ? " checked" : "";
                    $englishYearCheck = ($_POST['english'] == "year") ? " checked" : "";
                    

                    echo "\t\t\t\t<br />\n";
                    echo "\t\t\t\t<input type='radio' name='english' onclick='javascript: submit()' value='month'" . $englishMonthCheck . ">Monthly\n";
                    echo "\t\t\t\t<input type='radio' name='english' onclick='javascript: submit()' value='semester'" . $englishSemCheck . ">Semester\n";
                    echo "\t\t\t\t<input type='radio' name='english' onclick='javascript: submit()' value='year'" . $englishYearCheck . ">Yearly\n";
                ?>              
            </form>
        </div>
        <div class="report-grid">
            <?php 
                // TODO:
                // getHistoricRequired(); 
            ?>
        </div>
    </div>


    <?php 
        // -------------------------------------------------------------- 
        //        
        // SERVICES TAB 
        // 
        // --------------------------------------------------------------
/*
    <div id="services" class="tab-content">
        <?php // FILTER SERVICES ?>
        <div id="filter-services" class="filter-records column span4">
            <form class="input-append">
                <input class="key span12" type="text" />
                <button class="filter btn" type="submit" title="<?php echo $this->lang->line('filter'); ?>">
                    <i class="icon-search"></i>
                </button>
                <button class="clear btn" type="button" title="<?php echo $this->lang->line('clear'); ?>">
                    <i class="icon-repeat"></i>
                </button>
            </form>
            
            <h2><?php echo $this->lang->line('services'); ?></h2>
            <div class="results"></div>
        </div>

        <div class="details column span7">
            <div class="btn-toolbar">
                <div class="add-edit-delete-group btn-group">
                    <button id="add-service" class="btn btn-primary">
                        <i class="icon-plus icon-white"></i>
                        <?php echo $this->lang->line('add'); ?>
                    </button>
                    <button id="edit-service" class="btn" disabled="disabled">
                        <i class="icon-pencil"></i>
                        <?php echo $this->lang->line('edit'); ?>
                    </button>
                    <button id="delete-service" class="btn" disabled="disabled">
                        <i class="icon-remove"></i>
                        <?php echo $this->lang->line('delete'); ?>
                    </button>
                </div>

                <div class="save-cancel-group btn-group" style="display:none;">
                    <button id="save-service" class="btn btn-primary">
                        <i class="icon-ok icon-white"></i>
                        <?php echo $this->lang->line('save'); ?>
                    </button>
                    <button id="cancel-service" class="btn">
                        <i class="icon-ban-circle"></i>
                        <?php echo $this->lang->line('cancel'); ?>
                    </button>
                </div>
            </div>
            
            <h2><?php echo $this->lang->line('details'); ?></h2>
            <div class="form-message alert" style="display:none;"></div>
            
            <input type="hidden" id="service-id" />
            
            <label for="service-name"><?php echo $this->lang->line('name'); ?> *</label>
            <input type="text" id="service-name" class="span12 required" />
            
            <label for="service-duration"><?php echo $this->lang->line('duration_minutes'); ?> *</label>
            <input type="text" id="service-duration" class="required"  />
            
            <label for="service-price"><?php echo $this->lang->line('price'); ?> *</label>
            <input type="text" id="service-price" class="span12 required" />
            
            <label for="service-currency"><?php echo $this->lang->line('currency'); ?></label>
            <input type="text" id="service-currency" class="span12" />
            
            <label for="service-category"><?php echo $this->lang->line('category'); ?></label>
            <select id="service-category" class="span12"></select>
            
            <label for="service-description"><?php echo $this->lang->line('description'); ?></label>
            <textarea id="service-description" rows="4" class="span12"></textarea>
            
            <br/><br/>
            <em id="form-message" class="text-error">
                <?php echo $this->lang->line('fields_are_required'); ?></em>
        </div>
    </div>
*/
    ?>
    <?php 
        // -------------------------------------------------------------- 
        //        
        // CATEGORIES TAB 
        // 
        // --------------------------------------------------------------
/*   
    <div id="categories" class="tab-content" style="display:none;">
        <div id="filter-categories" class="filter-records column span4">
            <form class="input-append">
                <input class="key span12" type="text" />
                <button class="filter btn" type="submit" title="<?php echo $this->lang->line('filter'); ?>">
                    <i class="icon-search"></i>
                </button>
                <button class="clear btn" type="button" title="<?php echo $this->lang->line('clear'); ?>">
                    <i class="icon-repeat"></i>
                </button>
            </form>

            <h2><?php echo $this->lang->line('categories'); ?></h2>
            <div class="results"></div>
        </div>

        <div class="details span7">
            <div class="btn-toolbar">
                <div class="add-edit-delete-group btn-group">
                    <button id="add-category" class="btn btn-primary">
                        <i class="icon-plus icon-white"></i>
                        <?php echo $this->lang->line('add'); ?>
                    </button>
                    <button id="edit-category" class="btn" disabled="disabled">
                        <i class="icon-pencil"></i>
                        <?php echo $this->lang->line('edit'); ?>
                    </button>
                    <button id="delete-category" class="btn" disabled="disabled">
                        <i class="icon-remove"></i>
                        <?php echo $this->lang->line('delete'); ?>
                    </button>
                </div>

                <div class="save-cancel-group btn-group" style="display:none;">
                    <button id="save-category" class="btn btn-primary">
                        <i class="icon-ok icon-white"></i>
                        <?php echo $this->lang->line('save'); ?>
                    </button>
                    <button id="cancel-category" class="btn">
                        <i class="icon-ban-circle"></i>
                        <?php echo $this->lang->line('cancel'); ?>
                    </button>
                </div>
            </div>
            
            <h2><?php echo $this->lang->line('details'); ?></h2>
            <div class="form-message alert" style="display:none;"></div>
            
            <input type="hidden" id="category-id" />
            
            <label for="category-name"><?php echo $this->lang->line('name'); ?> *</label>
            <input type="text" id="category-name" class="span12 required" />
            
            <label for="category-description"><?php echo $this->lang->line('description'); ?></label>
            <textarea id="category-description" rows="4" class="span12"></textarea>
        </div>
    </div>
*/
    ?>
</div>