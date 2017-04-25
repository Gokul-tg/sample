<!DOCTYPE html>
<html lang="en">
<head>
  <title>::TestProject::</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="../admin/css/style1.css"> -->
  <link rel="stylesheet" href="css/style-dashbord.css">
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> 
  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
  <script src="facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="facefiles/facebox.js" type="text/javascript"></script>
  <script src="js/jquery-latest.js"></script>
  <script src="js/jscolor.js"></script>
  <script src="js/bootstrap.min.js"></script>
    <!--  <script src="../admin/js/smoothscroll.js"></script> -->
</head>
<body>
 <div id="wrapper">
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		   <a class="navbar-brand" href="index.html">
		   <span><img src="images/sample.png" height="50px"></span>
		   </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
		  <div class="msg">
          <ul class="nav navbar-nav navbar-right navbar-user">
           <li><a href="#">Home</a></li>
			<li><a href="#">Contact Us</a></li>
			<li><a href="index.php">Logout</a></li>
			<li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"> Welcome </i> {$Users.0.Name} </a>
              <ul class="dropdown-menu">
              </ul>
            </li>
          </ul>
		  
		  </div>
        </div><!-- /.navbar-collapse -->
      </nav>