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

if(isset($_GET["workflow"])){
 $workflow = $_GET["workflow"];
 
 if($workflow == 'lead1D'){
  require_once('./billingcon.php');
  $isworkflow = true;
  $workflowcusid = $_SESSION['lead1'];
  $pin= $_SESSION['lead1pin'];
  if ($result = $mysqli->query("SELECT * FROM `customer_info` WHERE `idcustomer_info` = '$workflowcusid'")) {
      /* fetch associative array */
      
    while ($row = $result->fetch_assoc()) {
     $cusemail= $row["email"];
	 $custel= $row["phone"];
    }

    } //end of mysql if
  } //  end of lead1b if
}else{
  $isworkflow = false;
  $cusemail= '';
	 $custel= '';

}

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
  <link rel="stylesheet" href="AdminLTE2/plugins/datatables/dataTables.bootstrap.css">
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
      Activate Customer and Select Billing Mode
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashbored.php"><i class="fa fa-dashboard"></i> Dashbored</a></li>
        <li class="active">Activate Customer</li>
      </ol>
    </section>

    <!-- Main content -->
	 <form role="form" action="activatecustomer2.php"method="post">
	<div class="row">
        <div class="col-xs-12">
    <section class="content">
	<div class="box">
            <div class="box-header">
			 <?php
// get error 
$error = $_SESSION['exitcodev2'];
$_SESSION['exitcodev2'] ='';
$errorlabel ='<label class="control-label" for="inputError" style="color: red;"><i class="fa fa-times-circle-o"></i> Input with
    error</label>';             
?> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
			  
			   <div class="form-group">
					<?php
					if($error == 'email' or $error == 'emailphone'){
						echo "$errorlabel";
					}else{
						echo '<label>Email</label>';
					}
					?>
                  <input type="text" class="form-control" name="email" id="first-choice"  placeholder="Enter Email" <?php if($isworkflow == true){
				   echo "value='$cusemail'";
				  }elseif($isworkflow == false){
				 
				  }//nothing
				  ?>required>
                </div>
			   
			   <div class="form-group">
                <?php
					if($error == 'pin'){
						echo "$errorlabel";
					}else{
						echo '<label>PIN</label>';
					}
					?>
                  
                  <?php if($isworkflow == true){
				   echo "<input type='hidden' name='pin' value='$pin'>";
				  }elseif($isworkflow == false){
				 echo '<input type="number" min="0" max="9999" class="form-control" name="pin" placeholder="Enter PIN" required>';
				  }//nothing
				  ?>
                </div>
<div class="form-group">
                  <?php
					if($error == 'mode'){
						echo "$errorlabel";
					}else{
						echo '<label>Billing Mode</label>';
					}
					?>
                  <select class="form-control" name="mode" required>
					<option value='' selected disabled>Please Select Billing Mode</option>
                    <option value="radius">Radius</option>
                    <option value="wispbill">Wispbill (No QOS)</option>
                    <option value="test">Test Mode (Customer Will Be Charged)</option>
                  </select>
                </div>
<?php
 if($error == 'location'){
						echo "$errorlabel";
					}else{
						echo '<label>Select Service Location</label>';
					}
                    ?>
                    <div class="form-group">
                <select class="form-control" name="location" id="second-choice" required>
				  <option value="" selected disabled>Please Enter Email First</option>
                </select>
                </div>
					
              <div class="form-group">
			  <?php
				 if ($result = $mysqli->query("SELECT * FROM `customer_plans` ")) {
    /* fetch associative array */
	
                if($error == 'plan'){
						echo "$errorlabel";
					}else{
						echo '<label>Service Plan</label>';
					}
                echo '<select class="form-control" name="plan" required>
				  <option value="" selected disabled>Please Select Plan</option>';
    while ($row = $result->fetch_assoc()) {
        $id = $row["idcustomer_plans"];
        $name = $row["name"];
        $up = $row["max_bandwith_up_kilo"];
        $down = $row["max_bandwith_down_kilo"]; 
        echo"<option value=$id>$name Upload $up Kbps Download $down Kbps</option>";
        }
 echo ' </select>
                </div>';
				$result->close();
	}else{
        echo'  <label class="control-label" for="inputError">Datebase
                    error contact your webmaster</label>';
    }?>
                 
			   
			  <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
		</div>
	 </form>
  
    </section>
    <!-- /.content -->
  
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
  <script type="text/javascript">
  $("#first-choice").change(function() {
  $("#second-choice").load("<?php echo"$url"; ?>/locationget.php?choice=" + $("#first-choice").val());});
  </script>
<!-- Bootstrap 3.3.5 -->
<script src="AdminLTE2/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE2/dist/js/app.min.js"></script>
<!-- DataTables -->
<script src="AdminLTE2/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="AdminLTE2/plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<script>
  $(function () {
    $('#example1').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false
    });
  });
</script>
</body>
</html>