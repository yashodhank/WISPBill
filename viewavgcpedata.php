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
<link href="d3chart/c3.css" rel="stylesheet" type="text/css">

<!-- Load d3.js and c3.js -->
<script src="d3chart/d3.min.js" charset="utf-8"></script>
<script src="d3chart/c3.min.js"></script>
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
        View Average CPE Preformance Data
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">CPE Preformance Data</li>
      </ol>
    </section>
<?php
require_once('./fileloader.php');

if(empty($_POST["data"])){
    
}elseif(empty($_POST["time"])){
    
}else{
    $intdata = $_POST["data"];
$timeframe = $_POST["time"];

$intdata = inputcleaner($intdata,$mysqli);
$timeframe = inputcleaner($timeframe,$mysqli);

$time = time();
  $time1dayago = $time-$timeframe;

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
	$gdata  = array();
	
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
if ($result = $mysqli->query("select avg($intdata) as data from `cpe_data` WHERE  `datetime` >=  '$start' and `datetime` <  '$end'")) {
       /* fetch associative array */
	          while ($row = $result->fetch_assoc()) {
		     $data = $row["data"];
             $data = abs($data);
			  array_push($gdata, $data);
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
if ($result = $mysqli->query("select avg($intdata) as data from `cpe_data` WHERE  `datetime` >=  '$start' and `datetime` <  '$end'")) {
       /* fetch associative array */
	          while ($row = $result->fetch_assoc()) {
		     $data = $row["data"];
              $data = abs($data);
			  array_push($gdata, $data);
}
}
}// End if
        }else{
          
        }// End set loop
	}// End loop
}// End if 

?>
    <!-- Main content -->
    <section class="content">

         <!-- general form elements disabled -->
          <div class="box box-warning">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="viewavgcpedata.php"method="post">
                <!-- text input -->
			<label>Data of Interest</label>
                <div class="form-group">
                <select class="form-control" name="data" required>
				  <option value="" selected disabled>Please Select Data Type</option>
                  <option value="signallev" >Signal Strength</option>
                  <option value="noise" >Noise Floor</option>
                  <option value="ccq" >Transmit CCQ</option>
                  <option value="latency" >Latency</option>
                </select>
                  </div>
                
                <label>Select Timeframe</label>
                <div class="form-group">
                <select class="form-control" name="time" required>
				  <option value="" selected disabled>Please Select Timeframe</option>
                  <option value="3600" >Hour</option>
                  <option value="86400" >Day</option>
                  <option value="604800" >Week</option>
                  <option value="2592000" >Month</option>
                  <option value="31536000" >Year</option>
                </select>
                  </div>
				<div class="box-footer">
                <button type="submit""><i class="fa fa-repeat"></i> Refresh View</button>
              </div>
				  
              </form>
        
                 </div>
            </div>
            <div class="box box-success">
            <div class="box-header with-border">
                <h3>Data Viewer</h3>
            </div>
  <div id="chart"></div>
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

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<!-- Select2 -->
<script src="AdminLTE2/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="AdminLTE2/plugins/input-mask/jquery.inputmask.js"></script>
<script src="AdminLTE2/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="AdminLTE2/plugins/input-mask/jquery.inputmask.extensions.js"></script>

 <script>
    var chart = c3.generate({
    bindto: '#chart',
    data: {
      x: 'x',
      columns: [
        ['x',<?php foreach($stamp as $value){
                  $value = $value *1000;
       echo "$value,";
      }
       
      ?> ],
        [<?php echo "'$intdata',";
        foreach($gdata as $value){              
       echo "$value,";
      }
       
      ?>]
      ],
        types: {
            data1: 'area',

            // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
        },
        groups: [[<?php echo "'$intdata'"; ?>]]
    },
    zoom: {
        enabled: true
    },
    subchart: {
        show: true
    },
     axis: {
        x: {
            type: 'timeseries',
            tick: {
                format: '%I:%M %p %m/%e/%y'
            }
        }
    }
});
  </script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
</body>
</html>