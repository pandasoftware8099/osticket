<div id="content">
<script src="<?php echo base_url('asset/dist/js/Chart.js');?>"></script>
<form method="post" action="dashboard.php">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">







<div class="clear"></div>
<div style="margin-bottom:20px; padding-top:5px;">
    <div class="pull-left flush-left">
        <h2><i class="help-tip icon-question-sign" href="#ticket_activity"></i>
<?php if ($_REQUEST['a'] == 'y' ) { ?>
    All 
<?php } else if ($_REQUEST['a'] == 'n') { ?>
    Own 
<?php } ?>

         Ticket Activity</h2>
    </div>
<?php if ($_REQUEST['a'] == 'y' ) { ?>
    <div class="pull-right flush-right">
    <a class="action-button" id="assign" href="<?php echo site_url('staff_dashboard_controller/dashboard?a=n')?>" title="view own statistics"><i class="icon-user"></i>View own statistics</a>
    </div>
<?php } else if ($_REQUEST['a'] == 'n') { ?>
    <div class="pull-right flush-right">
    <a class="action-button" id="assign" href="<?php echo site_url('staff_dashboard_controller/dashboard?a=y')?>" title="view all statistics"><i class="fa fa-users"></i>View all statistics</a>
    </div>
<?php } ?>

</div>
<div class="clear"></div>



<canvas id="linechart" width="400" height="100"></canvas>
<script>
var canvas = document.getElementById("linechart");
var ctx = canvas.getContext('2d');

// Global Options:
Chart.defaults.global.defaultFontColor = 'black';
Chart.defaults.global.defaultFontSize = 16;

var data = {
  labels: [<?php for ($i = 1; $i <= 12; $i++) {
    $months = date("M", strtotime( date( 'Y-m-01' )." +$i months"));
    echo " ' ".$months." ' ,";
} ?>],
  datasets: [{
      label: "Tickets",
      fill: false,
      lineTension: 0.1,
      backgroundColor: "rgba(225,0,0,0.4)",
      borderColor: "red", // The main line color
      borderCapStyle: 'square',
      borderDash: [], // try [5, 15] for instance
      borderDashOffset: 0.0,
      borderJoinStyle: 'miter',
      pointBorderColor: "black",
      pointBackgroundColor: "white",
      pointBorderWidth: 1,
      pointHoverRadius: 8,
      pointHoverBackgroundColor: "yellow",
      pointHoverBorderColor: "brown",
      pointHoverBorderWidth: 2,
      pointRadius: 4,
      pointHitRadius: 10,
      // notice the gap in the data and the spanGaps: true
      data: [<?php foreach ($ticketcreated_graph->result() as $value) {
    foreach ($value as $value) {

    echo $value.',';
}
} ?>],
      
      
      spanGaps: true,
    }

  ]
};

// Notice the scaleLabel at the same level as Ticks
var options = {
  scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },
                /*scaleLabel: {
                     display: true,
                     labelString: 'Ticket',
                     fontSize: 20 
                  }*/
            }]            
        }  
};

// Chart declaration:
var myBarChart = new Chart(ctx, {
  type: 'line',
  data: data,
  options: options
});
</script>

<canvas id="myChart" width="400" height="100"></canvas>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Tickets"],
        datasets: [{
            label: 'Open',
            data: [<?php echo $open ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                
            ],
            borderColor: [
                'rgba(255,99,132,1)',

            ],
            borderWidth: 1
        },{

            label: 'Closed',
            data: [ <?php echo $closed ?>],
            backgroundColor: [

                'rgba(54, 162, 235, 0.2)',

            ],
            borderColor: [

                'rgba(54, 162, 235, 1)',

            ],
            borderWidth: 1

        },{

            label: 'Resolved',
            data: [ <?php echo $resolved ?>],
            backgroundColor: [

                'rgba(255, 206, 86, 0.2)',

            ],
            borderColor: [

                'rgba(255, 206, 86, 1)',

            ],
            borderWidth: 1

        },{

            label: 'Overdue',
            data: [ <?php echo $overdue ?>],
            backgroundColor: [

                'rgba(75, 192, 192, 0.2)',

            ],
            borderColor: [

                'rgba(75, 192, 192, 1)',

            ],
            borderWidth: 1

        },{

            label: 'Assign',
            data: [ <?php echo $assign ?>],
            backgroundColor: [

                'rgba(153, 102, 255, 0.2)',

            ],
            borderColor: [

                'rgba(153, 102, 255, 1)',

            ],
            borderWidth: 1

        }



        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

<!-- <script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Open", "Closed", "Resolved", "Overdue", "Assigned"],
        datasets: [{
            label: 'Tickets',
            data: [<?php echo $open ?>, <?php echo $closed ?>, <?php echo $resolved ?>, <?php echo $overdue ?>, <?php echo $assign ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script> -->


<hr>
<h2>Statistics&nbsp;<i class="help-tip icon-question-sign" href="#statistics"></i></h2>
<p>Statistics of tickets organized by department, help topic, and agent.</p>

<div class="tab">
    <ul class="clean tabs">
        <li class="active"><a href="#dept">Department</a></li>
        <li class=""><a href="#topic">Topics</a></li>
        <li class=""><a href="#staff">Agent</a></li>
    </ul>
</div>

    <div class="tab_content " id="dept" style="overflow:auto;">
        <table class="dashboard-stats table" id="depttable">
            <tbody>
                <tr>
                    <th width="30%" class="flush-left">Department</th>
                    <th>Opened</th>
                    <th>Assigned</th>
                    <th>Overdue</th>
                    <th>Closed</th>
                    <th>Reopened</th>
                </tr>
            </tbody>

            <tbody>
            <?php foreach ($depart->result() as $department) { ?>
            <tr>
                <th class="flush-left"><?php echo $department->name;?></th>
                    <td><?php echo $this->db->query("
                        SELECT COUNT(*) as departopen FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND a.department = '".$department->name."'")->row('departopen');?></td>
                    <td><?php echo $this->db->query("
                        SELECT COUNT(*) as departassigned FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND assigned_to != '0' AND a.department = '".$department->name."'")->row('departassigned');?></td>
                    <td><?php echo $this->db->query("
                        SELECT COUNT(*) as departdue FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND duedate <= now() AND a.department = '".$department->name."'")->row('departdue');?></td>
                    <td><?php echo $this->db->query("
                        SELECT COUNT(*) as departclose FROM ost_ticket_test
                        WHERE status_guid = '3' AND department = '".$department->name."'")->row('departclose');?></td>
                    <td><?php echo $this->db->query("
                        SELECT COUNT(*) as departreopen FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND reopened != '0' AND a.department = '".$department->name."'")->row('departreopen');?></td>
            </tr>
            <?php }?>
            </tbody>
        </table>

        <div style="margin-top: 5px">
            <input  class="link button" type="button" onclick="tableToExcel('depttable', 'Department Stat Table')" value="Export">
        </div>


    </div>

    <div class="tab_content hiddens" id="topic" style="overflow:auto;">
        <table id="topictable" class="dashboard-stats table">
            <tbody>
                <tr>
                    <th width="30%" class="flush-left">Help Topic</th>
                    <th>Opened</th>
                    <th>Assigned</th>
                    <th>Overdue</th>
                    <th>Closed</th>
                    <th>Reopened</th>
                </tr>
            </tbody>

            <tbody>
                <?php 
                $staffid = $_SESSION['staffid'];

                foreach ($topic->result() as $topics) { ?>

                <tr>
                    <th class="flush-left"><?php echo $topics->topic;?></th>
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as topicopen FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND a.topic_guid = '".$topics->topic_guid."'")->row('topicopen');?></td>
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as topicassigned FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND a.assigned_to != '0' AND topic_guid = '".$topics->topic_guid."'")->row('topicassigned');?></td>
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as topicdue FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND duedate <= now() AND a.topic_guid = '".$topics->topic_guid."'")->row('topicdue');?></td>
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as topicclose FROM ost_ticket_test
                        WHERE status_guid = '3' AND topic_guid = '".$topics->topic_guid."'")->row('topicclose');?></td>
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as topicreopen FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND reopened != '0' AND a.topic_guid = '".$topics->topic_guid."'")->row('topicreopen');?></td>
                </tr>

               
                <?php  }?>
            </tbody>
        </table>

        <div style="margin-top: 5px">
            <input  class="link button" type="button" onclick="tableToExcel('topictable', 'Topics Stat Table')" value="Export">
        </div>
    </div>

    <div class="tab_content hiddens" id="staff" style="overflow:auto;">
        <table id="agenttable" class="dashboard-stats table">
            <tbody>
                <tr>
                    <th width="30%" class="flush-left">Agent</th>
                    <th>Opened</th>
                    <th>Assigned</th>
                    <th>Overdue</th>
                    <th>Closed</th>
                    <th>Reopened</th>
                </tr>
            </tbody>

            <tbody>
            <?php foreach ($staff->result() as $agent) { ?>   
                <tr> 
                    <th class="flush-left"><?php echo $agent->firstname;?> <?php echo $agent->lastname;?></th>
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as agentopen FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND a.assigned_to = '".$agent->staff_guid."'")->row('agentopen');?></td>                
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as agentassigned FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND a.assigned_to = '".$agent->staff_guid."'")->row('agentassigned');?></td>
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as agentdue FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND duedate <= now() AND a.assigned_to = '".$agent->staff_guid."'")->row('agentdue');?></td>                
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as agentclose FROM ost_ticket_test
                        WHERE status_guid = '3' AND assigned_to = '".$agent->staff_guid."'")->row('agentclose');?></td>               
                        <td><?php echo $this->db->query("
                        SELECT COUNT(*) as agentreopen FROM ost_ticket_test AS a 
                        INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid 
                        WHERE b.state = 'open' AND reopened != '0' AND a.assigned_to = '".$agent->staff_guid."'")->row('agentreopen');?></td>               
                </tr> 
            <?php } ?>
            </tbody>
        </table>

        <div style="margin-top: 5px">
            <input  class="link button" type="button" onclick="tableToExcel('agenttable', 'Agnet Stat Table')" value="Export">
        </div>
    </div>
</form>

<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
</div>
</div>