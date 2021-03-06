<?php
/*
    WISPBill a PHP based ISP billing platform
    Copyright (C) 2015  Turtles2

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published
    by the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

	@turtles2 on ubiquiti community, DSLReports and Netonix 
 */
require_once('./session.php');
require_once('./fileloader.php');
$mysqli = new mysqli("$ip", "$username", "$password", "$db");
// Start of Clean up At some point this will be simpiler
$_SESSION['exitcode'] = '';
$_SESSION['exitcodev2'] = '';
$_SESSION['errorcode'] = '';
$_SESSION['id'] = '';
$_SESSION['id2'] = '';
$_SESSION['id3'] = '';
$_SESSION['email'] = '';
$_SESSION['errorcode'] ='';
$_SESSION['troubleshooting'] ='';
// Workflow CLeanup
$_SESSION['lead1'] = '';
$_SESSION['lead1pin'] = '';
// End of cleanup
$adminid = $_SESSION['adminid'];

if ($result = $mysqli->query("SELECT * FROM `admin_users` WHERE `idadmin` = $adminid")) {
    /* fetch associative array */
     while ($row = $result->fetch_assoc()) {
    $fname = $row["fname"];
    $lname = $row["lname"];
    $userimage = $row["img"];
}
       /* free result set */
    $result->close();
}// end if

if ($result = $mysqli->query("SELECT *
FROM   customer_info
WHERE  (SELECT customer_info_idcustomer_info
                   FROM   customer_users
                   WHERE  customer_info.idcustomer_info = customer_users.customer_info_idcustomer_info)
                             and `idcustomer_plans` is not NULL")) {
      /* fetch associative array */
      $custotal = $result->num_rows;
}
if ($result = $mysqli->query("SELECT *
FROM   customer_info
WHERE  NOT EXISTS (SELECT customer_info_idcustomer_info
                   FROM   customer_users
                   WHERE  customer_info.idcustomer_info = customer_users.customer_info_idcustomer_info)")) {
      /* fetch associative array */
      $leadtotal = $result->num_rows;
}

$time= time();

$dayagotime = $time - 86400;

if ($result = $mysqli->query("SELECT * FROM `history` WHERE `event` = 'Customer Contact type call' and `date` > '$dayagotime'")) {
      /* fetch associative array */
      $calltotal = $result->num_rows;
}
    if ($result = $mysqli->query("SELECT COUNT( * ) FROM  `ip_address` 
WHERE  `status` =  '0' AND  `devices_iddevices` IS NOT NULL")){
     while ($row = $result->fetch_assoc()) {
						 $devicedown = $row["COUNT( * )"];
						
						 }
 }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WISP Bill</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="AdminLTE2/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLTE2/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="AdminLTE2/dist/css/skins/<?php echo"$guiskin";?>.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition <?php echo"$guiskin";?> sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="dashbored.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>WISP</b> Bill</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>WISP</b> Bill</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-<?php echo "$noticode"; ?>"><?php echo "$notitotal"; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo "$notitotal"; ?> messages</li>
              <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="viewnotifications.php?id=<?php echo "$notiid"; ?>">
                      <div class="pull-left">
                        <!-- User Image -->
                        <img src="<?php echo "$notiimage"; ?>" class="img-circle" alt="User Image">
                      </div>
                      <!-- Message title and timestamp -->
                      <h4>
                        <?php echo "$notisource"; ?>
                        <small><i class="fa fa-clock-o"></i><?php echo "$notitime"; ?></small>
                      </h4>
                      <!-- The message -->
                      <p><?php echo "$notimesg"; ?></p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
                <!-- /.menu -->
              </li>
              <li class="footer"><a href="viewnotifications.php">See All Messages</a></li>
            </ul>
          </li>
          <!-- /.messages-menu -->
 
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?php echo "$userimage"; ?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo "$fname $lname"; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?php echo "$userimage"; ?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo "$fname $lname"; ?> 
                </p>
              </li>
              <!-- Menu Body -->    
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="settings.php" class="btn btn-default btn-flat">Settings</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="settings.php" ><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo "$userimage"; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo "$fname $lname"; ?></p>
          
        </div>
      </div>
<?php
// Get Menu all echo login is in file
 require_once("$menue");
?>
     

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashbored.php"><i class="fa fa-dashboard"></i> Dashbored</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

       <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo "$leadtotal"?></h3>

              <p>Leads</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="viewlead.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo "$custotal";?></h3>

              <p>Customers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="viewcustomer.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo "$calltotal";?></h3>

              <p>Calls in the last 24 hours</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-call"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo "$devicedown";?></h3>

              <p>Devices Down</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            <a href="viewdown.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Network Traffic in the last day</h3>

            <div class="box-body">
              <div class="chart">
                <canvas id="canvas" ></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <?php echo "$rightfooter";?>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2015 <a href="<?php echo "$companysite";?>"><?php echo "$company";?></a>.</strong> All rights reserved.
  </footer>

<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="AdminLTE2/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="AdminLTE2/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE2/dist/js/app.min.js"></script>
 <script src="AdminLTE2/plugins/chartjs/beta2.js"></script>

  <?php
  require_once('./fileloader.php');
  $mysqli = new mysqli("$ip", "$username", "$password", "$db");
$time = time();
  $time1dayago = $time-86400;

// Bulid array of Devcices

if ($result = $mysqli->query("SELECT * FROM `devices` WHERE `type`
                              = 'cpe' and `field_status` = 'customer' limit 0,1")) {
       /* fetch associative array */
     while ($row = $result->fetch_assoc()) {
    $id = $row["iddevices"];
}
}

$master = array();
	if ($result = $mysqli->query("SELECT * FROM  `cpe_data` WHERE  `datetime` >=  '$time1dayago' and `devices_iddevices` = '$id'")) {
       /* fetch associative array */
	   
     while ($row = $result->fetch_assoc()) {
		array_push($master, $row["datetime"]);
}
	}
	$master2 = (array_chunk($master, 2));
	$stamp = array();
	$down  = array();
	$up = array();
	
	foreach($master2 as $key=>$set){
      
		$start = $set["0"];
        if(isset($set["1"])){
		$end = $set["1"];
		if ($result = $mysqli->query("SELECT avg(datetime) as datetime FROM `cpe_data` WHERE  `datetime` >=  '$start' and `datetime` <  '$end'")) {
       /* fetch associative array */
	          while ($row = $result->fetch_assoc()) {
		     $avgtime = $row["datetime"];
			 $avgtime = round($avgtime);
			 array_push($stamp, $avgtime);
}
}
if ($result = $mysqli->query("select sum(rxrate) as down from `cpe_data` WHERE  `datetime` >=  '$start' and `datetime` <  '$end'")) {
       /* fetch associative array */
	          while ($row = $result->fetch_assoc()) {
		     $rxrate = $row["down"];
			  array_push($down, $rxrate);
}
}
if ($result = $mysqli->query("select sum(txrate) as up from `cpe_data` WHERE  `datetime` >=  '$start' and `datetime` <  '$end'")) {
       /* fetch associative array */
	          while ($row = $result->fetch_assoc()) {
		     $txrate = $row["up"];
			  array_push($up, $txrate);
}
}
$next = $key + 1;
if(isset($master2["$next"])){
$nextset = $master2["$next"];
$start = $end;
$end = $nextset["0"];
	if ($result = $mysqli->query("SELECT avg(datetime) as datetime FROM `cpe_data` WHERE  `datetime` >=  '$start' and `datetime` <  '$end'")) {
       /* fetch associative array */
	          while ($row = $result->fetch_assoc()) {
		     $avgtime = $row["datetime"];
			 $avgtime = round($avgtime);
			 array_push($stamp, $avgtime);
}
}
if ($result = $mysqli->query("select sum(rxrate) as down from `cpe_data` WHERE  `datetime` >=  '$start' and `datetime` <  '$end'")) {
       /* fetch associative array */
	          while ($row = $result->fetch_assoc()) {
		     $rxrate = $row["down"];
			  array_push($down, $rxrate);
}
}
if ($result = $mysqli->query("select sum(txrate) as up from `cpe_data` WHERE  `datetime` >=  '$start' and `datetime` <  '$end'")) {
       /* fetch associative array */
	          while ($row = $result->fetch_assoc()) {
		     $txrate = $row["up"];
			  array_push($up, $txrate);
}
}
}// End if
        }else{
          
        }// End set loop
	}// End loop
  ?>  
    <script>

        var config = {
            type: 'line',
            data: {
                labels: [<?php foreach($stamp as $value){
                  $value = date("g:i A","$value");
       echo "\"$value\",";
      }
      ?>],
                
                datasets: [{
                    label: "Download in Mbps",
                    borderColor: "rgba(210, 214, 222, 1)",
                    backgroundColor: "rgba(210, 214, 222, 1)",
                    pointBorderColor: "rgba(255, 255, 255, .0)",
                    pointBackgroundColor: "rgba(255, 255, 255, .0)",
                    pointBorderWidth: 0,
                    pointHoverRadius: 0,
                    pointRadius: 0,
                    data: [<?php foreach($down as $value){
                      $value = $value/1000000;
       echo "$value,";
      }
      ?>],
                }, {
                    label: "Upload in Mbps",
                    borderColor: "rgba(60,141,188,0.8)",
                    backgroundColor: "rgba(60,141,188,0.9)",
                    pointBorderColor: "rgba(60,141,188,.0)",
                    pointBackgroundColor: "rgba(60,141,188,.0)",
                    pointBorderWidth: 0,
                    pointHoverRadius: 0,
                    pointRadius: 0,
                    data: [<?php foreach($up as $value){
                      $value = $value/1000000;
       echo "$value,";
      }
      ?>],
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'label',
                    callbacks: {
                        // beforeTitle: function() {
                        //     return '...beforeTitle';
                        // },
                        // afterTitle: function() {
                        //     return '...afterTitle';
                        // },
                        // beforeBody: function() {
                        //     return '...beforeBody';
                        // },
                        // afterBody: function() {
                        //     return '...afterBody';
                        // },
                        // beforeFooter: function() {
                        //     return '...beforeFooter';
                        // },
                        // footer: function() {
                        //     return 'Footer';
                        // },
                        // afterFooter: function() {
                        //     return '...afterFooter';
                        // },
                    }
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            show: true,
                            labelString: "Time of Day",
                            fontSize: 20,
                        },
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                          fontSize: 16,
                        }
                        
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            show: true,
                            labelString: "Megabits per Second",
                            fontSize: 20,
                        },
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                          fontSize: 20,
                        }
                        
                    }]
                }
            }
        };
       
        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);
            
        };
     
        
    </script>

</body>
</html>