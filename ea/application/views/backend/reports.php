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
    <ul class="nav nav-tabs">
        <li class="current-tab tab active"><a><?php echo $this->lang->line('current'); ?></a></li>
        <li class="historic-tab tab"><a><?php echo $this->lang->line('historic'); ?></a></li>
        <li class="reports-dump">
            <button class="report_btn" data="reports_dump">Report Dump</button>
        </li>
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
            <h2>Tutors</h2>
            <?php getCurrentTutors(); ?>
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
        <div class="report-grid">
            <h2>Required Visit</h2>
            <?php getCurrentRequired(); ?>
        </div>
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
            <div id="overall_month">
                <?php getHistoricOverall('month'); ?>
            </div>
            <div id="overall_semester" style="display:none">
                <?php getHistoricOverall('semester'); ?>
            </div>
            <div id="overall_year" style="display:none">
                <?php getHistoricOverall('year'); ?>
            </div>
            <br />
            <button type="button" onclick="show_overall('overall_month');">Month</button>
            <button type="button" onclick="show_overall('overall_semester');">Semester</button>
            <button type="button" onclick="show_overall('overall_year');">Year</button>
        </div>
        <div class="report-grid">
            <h2>Tutors</h2>
            <div id="tutor_month">
                <?php getHistoricTutors('month'); ?>
            </div>
            <div id="tutor_semester" style="display:none">
                <?php getHistoricTutors('semester'); ?>
            </div>
            <div id="tutor_year" style="display:none">
                <?php getHistoricTutors('year'); ?>
            </div>
            <br />
            <button type="button" onclick="show_tutors('tutor_month');">Month</button>
            <button type="button" onclick="show_tutors('tutor_semester');">Semester</button>
            <button type="button" onclick="show_tutors('tutor_year');">Year</button>
        </div>
        <div class="report-grid">
            <h2>Service</h2>
            <div id="service_month">
                <?php getHistoricService('month'); ?>
            </div>
            <div id="service_semester" style="display:none">
                <?php getHistoricService('semester'); ?>
            </div>
            <div id="service_year" style="display:none">
                <?php getHistoricService('year'); ?>
            </div>
            <br />
            <button type="button" onclick="show_service('service_month');">Month</button>
            <button type="button" onclick="show_service('service_semester');">Semester</button>
            <button type="button" onclick="show_service('service_year');">Year</button>
        </div>
        <div class="report-grid">
            <h2>Academic Year</h2>
            <div id="year_month">
                <?php getHistoricYear('month'); ?>
            </div>
            <div id="year_semester" style="display:none">
                <?php getHistoricYear('semester'); ?>
            </div>
            <div id="year_year" style="display:none">
                <?php getHistoricYear('year'); ?>
            </div>
            <br />
            <button type="button" onclick="show_year('year_month');">Month</button>
            <button type="button" onclick="show_year('year_semester');">Semester</button>
            <button type="button" onclick="show_year('year_year');">Year</button>
        </div>
        <div class="report-grid">
            <h2>Major</h2>
            <div id="major_month">
                <?php getHistoricMajor('month'); ?>
            </div>
            <div id="major_semester" style="display:none">
                <?php getHistoricMajor('semester'); ?>
            </div>
            <div id="major_year" style="display:none">
                <?php getHistoricMajor('year'); ?>
            </div>
            <br />
            <button type="button" onclick="show_major('major_month');">Month</button>
            <button type="button" onclick="show_major('major_semester');">Semester</button>
            <button type="button" onclick="show_major('major_year');">Year</button>
        </div>
        <div class="report-grid">
            <h2>First Visit</h2>
            <div id="first_month">
                <?php getHistoricFirstVisit('month'); ?>
            </div>
            <div id="first_semester" style="display:none">
                <?php getHistoricFirstVisit('semester'); ?>
            </div>
            <div id="first_year" style="display:none">
                <?php getHistoricFirstVisit('year'); ?>
            </div>
            <br />
            <button type="button" onclick="show_firstVisit('first_month');">Month</button>
            <button type="button" onclick="show_firstVisit('first_semester');">Semester</button>
            <button type="button" onclick="show_firstVisit('first_year');">Year</button>
        </div>
        <div class="report-grid">
            <h2>English as Second Language</h2>
            <div id="esl_month">
                <?php getHistoricEnglish('month'); ?>
            </div>
            <div id="esl_semester" style="display:none">
                <?php getHistoricEnglish('semester'); ?>
            </div>
            <div id="esl_year" style="display:none">
                <?php getHistoricEnglish('year'); ?>
            </div>
            <br />
            <button type="button" onclick="show_esl('esl_month');">Month</button>
            <button type="button" onclick="show_esl('esl_semester');">Semester</button>
            <button type="button" onclick="show_esl('esl_year');">Year</button>
        </div>
        <div class="report-grid">
            <h2>Required Visit</h2>
            <div id="req_month">
                <?php getHistoricRequired('month'); ?>
            </div>
            <div id="req_semester" style="display:none">
                <?php getHistoricRequired('semester'); ?>
            </div>
            <div id="req_year" style="display:none">
                <?php getHistoricRequired('year'); ?>
            </div>
            <br />
            <button type="button" onclick="show_reqVisit('req_month');">Month</button>
            <button type="button" onclick="show_reqVisit('req_semester');">Semester</button>
            <button type="button" onclick="show_reqVisit('req_year');">Year</button>
        </div>
    </div>
    
</div>