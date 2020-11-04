<?php
include 'payload.php'; // payload.php json data handler from Data Storage
// start page loading #page-content-wrapper
// example index.php?page=sensor&id=dhtsensor05
if(isset($_GET["page"])) { // load page template
  $pageID = $_GET['page'];
} else {
	$pageID = "dashboard"; // load this page when no page in url
}
if(isset($_GET["id"])) { // load sensor by deviceID name payload.php line: 6
	$sensorID = $_GET['id'];
} else {
	$sensorID = "noData"; // fallback when no or wrong sensor is called
}
// end page loading #page-content-wrapper
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/template.css" rel="stylesheet">
    <!-- chartJS and fontawesome.js from cloud -->
    <script src="https://kit.fontawesome.com/2bb590dacb.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  </head>
<body>

<div class="d-flex" id="wrapper">
  <!-- left navigation menu -->
  <?php include 'templates/sidemenu.php'; ?>

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <!-- top nav bar page -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <button class="btn btn-primary" id="menu-toggle">Toggle</button>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <li class="nav-item active">
        <a class="nav-link" href="#">Login <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">Info</a>
        </li>
      </ul>
    </div>
    </nav>
    <!-- #page-content-wrapper -->
    <div class="container-fluid">
      <?php include 'templates/'. $pageID .'.php'; ?>
    </div>
  </div>
</div>
  <!-- Bootstrap and jquery core JavaScript -->
  <script src="assets/jquery/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>
</html>
