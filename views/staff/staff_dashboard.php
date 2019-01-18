<div id="content">
        <script type="text/javascript" src="js/raphael-min.js?9ae093d"></script>
<script type="text/javascript" src="js/g.raphael.js?9ae093d"></script>
<script type="text/javascript" src="js/g.line-min.js?9ae093d"></script>
<script type="text/javascript" src="js/g.dot-min.js?9ae093d"></script>
<script type="text/javascript" src="js/dashboard.inc.js?9ae093d"></script>

<link rel="stylesheet" type="text/css" href="css/dashboard.css?9ae093d">

<form method="post" action="dashboard.php">
<div id="basic_search">
    <div style="min-height:25px;">
        <!--<p></p>-->
            <input type="hidden" name="__CSRFToken__" value="203c8c8ae43c0cf914fe97b76fe5f8932bead146">            <label>
                Report timeframe:
                <input type="text" class="dp input-medium search-query hasDatepicker" name="start" placeholder="Last month" value="" id="dp1541037050124"><button type="button" class="ui-datepicker-trigger"><img src="./images/cal.png" alt="..." title="..."></button>
            </label>
            <label>
                period:
                <select name="period">
                    <option value="now" selected="selected">
                        Up to today                    </option>
                    <option value="+7 days">
                        One Week                    </option>
                    <option value="+14 days">
                        Two Weeks                    </option>
                    <option value="+1 month">
                        One Month                    </option>
                    <option value="+3 months">
                        One Quarter                    </option>
                </select>
            </label>
            <button class="green button action-button muted" type="submit">
                Refresh            </button>
            <i class="help-tip icon-question-sign" href="#report_timeframe"></i>
    </div>
</div>
<div class="clear"></div>
<div style="margin-bottom:20px; padding-top:5px;">
    <div class="pull-left flush-left">
        <h2><i class="help-tip icon-question-sign" href="#ticket_activity"></i> Ticket Activity</h2>
    </div>
</div>
<div class="clear"></div>
<!-- Create a graph and fetch some data to create pretty dashboard -->
<div style="position:relative">
    <div id="line-chart-here" style="height:300px"><svg height="300" version="1.1" width="908" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.890625px; top: -0.109375px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="40" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10-18-2018</tspan></text><text x="137.65078" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10-20-2018</tspan></text><text x="235.30156" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10-22-2018</tspan></text><text x="332.95234" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10-23-2018</tspan></text><text x="430.60312" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10-25-2018</tspan></text><text x="528.2538999999999" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10-27-2018</tspan></text><text x="625.9046799999999" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10-29-2018</tspan></text><text x="723.5554599999998" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10-30-2018</tspan></text><text x="821.2062399999998" y="275.20624" text-anchor="middle" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">11-01-2018</tspan></text><path fill="none" stroke="#000000" d="M40,263.70624L821.20624,263.70624M40.5,263.20624L40.5,268.20624M138.15078,263.20624L138.15078,268.20624M235.80156,263.20624L235.80156,268.20624M333.45234,263.20624L333.45234,268.20624M431.10312,263.20624L431.10312,268.20624M528.7538999999999,263.20624L528.7538999999999,268.20624M626.4046799999999,263.20624L626.4046799999999,268.20624M724.0554599999998,263.20624L724.0554599999998,268.20624M821.7062399999998,263.20624L821.7062399999998,268.20624" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="35" y="263.20624" text-anchor="end" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5031149999999798" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><text x="35" y="141.60312" text-anchor="end" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.50936999999999" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1</tspan></text><text x="35" y="20" text-anchor="end" font="11px 'Fontin Sans', Fontin-Sans, sans-serif" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font: 11px &quot;Fontin Sans&quot;, Fontin-Sans, sans-serif;"><tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2</tspan></text><path fill="none" stroke="#000000" d="M40.5,263.20624L40.5,20M36,263.70624L41,263.70624M36,142.10312L41,142.10312M36,20.5L41,20.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#2f69bf" d="M40,20L319.0022285714286,141.60312L430.60312,141.60312L542.2040114285714,263.20624L653.8049028571429,20L709.6053485714285,141.60312L765.4057942857143,141.60312" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round" stroke-dasharray="-1.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); stroke-linejoin: round; stroke-linecap: round;"></path><circle cx="40" cy="20" r="4.800000000000001" fill="#2f69bf" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="319.0022285714286" cy="141.60312" r="4.800000000000001" fill="#2f69bf" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="430.60312" cy="141.60312" r="4.800000000000001" fill="#2f69bf" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="542.2040114285714" cy="263.20624" r="4.800000000000001" fill="#2f69bf" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="653.8049028571429" cy="20" r="4.800000000000001" fill="#2f69bf" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="709.6053485714285" cy="141.60312" r="4.800000000000001" fill="#2f69bf" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="765.4057942857143" cy="141.60312" r="4.800000000000001" fill="#2f69bf" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="none" stroke="#a2bf2f" d="M40,263.20624L319.0022285714286,263.20624L430.60312,141.60312L542.2040114285714,263.20624L653.8049028571429,263.20624L709.6053485714285,263.20624L765.4057942857143,263.20624" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round" stroke-dasharray="-1.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); stroke-linejoin: round; stroke-linecap: round;"></path><circle cx="40" cy="263.20624" r="4.800000000000001" fill="#a2bf2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="319.0022285714286" cy="263.20624" r="4.800000000000001" fill="#a2bf2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="430.60312" cy="141.60312" r="4.800000000000001" fill="#a2bf2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="542.2040114285714" cy="263.20624" r="4.800000000000001" fill="#a2bf2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="653.8049028571429" cy="263.20624" r="4.800000000000001" fill="#a2bf2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="709.6053485714285" cy="263.20624" r="4.800000000000001" fill="#a2bf2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="765.4057942857143" cy="263.20624" r="4.800000000000001" fill="#a2bf2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="none" stroke="#bf5a2f" d="M40,141.60312L319.0022285714286,263.20624L430.60312,263.20624L542.2040114285714,141.60312L653.8049028571429,263.20624L709.6053485714285,263.20624L765.4057942857143,263.20624" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round" stroke-dasharray="-1.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); stroke-linejoin: round; stroke-linecap: round;"></path><circle cx="40" cy="141.60312" r="4.800000000000001" fill="#bf5a2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="319.0022285714286" cy="263.20624" r="4.800000000000001" fill="#bf5a2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="430.60312" cy="263.20624" r="4.800000000000001" fill="#bf5a2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="542.2040114285714" cy="141.60312" r="4.800000000000001" fill="#bf5a2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="653.8049028571429" cy="263.20624" r="4.800000000000001" fill="#bf5a2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="709.6053485714285" cy="263.20624" r="4.800000000000001" fill="#bf5a2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="765.4057942857143" cy="263.20624" r="4.800000000000001" fill="#bf5a2f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="none" stroke="#bfa22f" d="M40,263.20624L319.0022285714286,141.60312L430.60312,141.60312L542.2040114285714,263.20624L653.8049028571429,20L709.6053485714285,263.20624L765.4057942857143,20" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round" stroke-dasharray="-1.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); stroke-linejoin: round; stroke-linecap: round;"></path><circle cx="40" cy="263.20624" r="4.800000000000001" fill="#bfa22f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="319.0022285714286" cy="141.60312" r="4.800000000000001" fill="#bfa22f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="430.60312" cy="141.60312" r="4.800000000000001" fill="#bfa22f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="542.2040114285714" cy="263.20624" r="4.800000000000001" fill="#bfa22f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="653.8049028571429" cy="20" r="4.800000000000001" fill="#bfa22f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="709.6053485714285" cy="263.20624" r="4.800000000000001" fill="#bfa22f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="765.4057942857143" cy="20" r="4.800000000000001" fill="#bfa22f" stroke="none" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><rect x="29" y="0" width="150.5011142857143" height="283.20624" r="0" rx="0" ry="0" fill="#000000" stroke="none" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></rect><rect x="178.5011142857143" y="0" width="196.30156" height="283.20624" r="0" rx="0" ry="0" fill="#000000" stroke="none" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></rect><rect x="373.80267428571426" y="0" width="112.60089142857143" height="283.20624" r="0" rx="0" ry="0" fill="#000000" stroke="none" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></rect><rect x="485.4035657142857" y="0" width="112.60089142857146" height="283.20624" r="0" rx="0" ry="0" fill="#000000" stroke="none" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></rect><rect x="597.0044571428572" y="0" width="84.70066857142854" height="283.20624" r="0" rx="0" ry="0" fill="#000000" stroke="none" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></rect><rect x="680.7051257142857" y="0" width="56.80044571428567" height="283.20624" r="0" rx="0" ry="0" fill="#000000" stroke="none" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></rect><rect x="736.5055714285713" y="0" width="66.80044571428573" height="283.20624" r="0" rx="0" ry="0" fill="#000000" stroke="none" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></rect></svg></div>
    <div style="position:absolute;right:0;top:0" id="line-chart-legend"><span class="label" style="margin-left: 0.5em; background-color: rgb(47, 105, 191);">created</span><br><span class="label" style="margin-left: 0.5em; background-color: rgb(162, 191, 47);">reopened</span><br><span class="label" style="margin-left: 0.5em; background-color: rgb(191, 90, 47);">assigned</span><br><span class="label" style="margin-left: 0.5em; background-color: rgb(191, 162, 47);">overdue</span><br></div>
</div>

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
                    <th>Service Time</th>
                    <th>Response Time</th>
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
                    <td>12.4</td>
                    <td>0.0</td>
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
                    <th>Service Time</th>
                    <th>Response Time</th>
                </tr>
            </tbody>

            <tbody>
                <?php foreach ($topic->result() as $topics) { ?>
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
                        <td>31.0</td>
                        <td>0.0</td>
                </tr>
                <?php }?>
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
                    <th>Service Time</th>
                    <th>Response Time</th>
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
                        <td>0.0</td>              
                        <td>0.0</td>
                </tr> 
            <?php } ?>
            </tbody>
        </table>

        <div style="margin-top: 5px">
            <input  class="link button" type="button" onclick="tableToExcel('agenttable', 'Agnet Stat Table')" value="Export">
        </div>
    </div>
</form>

<script>
    $.drawPlots({"times":[1539820800,1540252800,1540425600,1540598400,1540771200,1540857600,1540944000],"plots":{"created":[2,1,1,0,2,1,1],"reopened":[0,0,1,0,0,0,0],"assigned":[1,0,0,1,0,0,0],"overdue":[0,1,1,0,2,0,2]},"events":["created","reopened","assigned","overdue"]});
</script>
</div>
</div>
    <div id="footer" style="margin-bottom:10px;">
        Copyright © 2006-2018&nbsp;Panda Ticketing System&nbsp;All Rights Reserved.
    </div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0">
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
</div>
<div id="overlay"></div>
<div id="loading" style="top: 219px; left: 524.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 54.75px; left: 374.5px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display: none; top: 54.75px; left: 618.5px;" class="dialog" id="alert">
    <h3><i class="icon-warning-sign"></i> <span id="title"></span></h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <div id="body" style="min-height: 20px;"></div>
    <hr style="margin-top:3em">
    <p class="full-width">
        <span class="buttons pull-right">
            <input type="button" value="OK" class="close ok">
        </span>
     </p>
    <div class="clear"></div>
</div>

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

<script type="text/javascript" src="/helpdesk/js/jquery.pjax.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-typeahead.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/scp.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/jquery-ui-1.10.3.custom.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/filedrop.field.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/select2.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/tips.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-osticket.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-plugins.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.translatable.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.dropdown.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-tooltip.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/fabric.min.js?9ae093d"></script>
<link type="text/css" rel="stylesheet" href="/helpdesk/scp/css/tooltip.css?9ae093d">
<script type="text/javascript">
    getConfig().resolve({"lock_time":3600,"html_thread":true,"date_format":"Y-MM-dd","lang":"en_US","short_lang":"en","has_rtl":false,"lang_flag":"us","primary_lang_flag":"us","primary_language":"en-US","secondary_languages":[],"page_size":25});
</script>


<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div></body></html>