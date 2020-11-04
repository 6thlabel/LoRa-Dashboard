    <!-- Sidebar -->
<div class="bg-dark border-right" id="sidebar-wrapper">
  <div class="sidebar-heading"><img src="./logo.png" /></div>
    <div class="list-group list-group-flush ">
      <a href='index.php?page=dashboard' class="list-group-item list-group-item-action"><i class="fas fa-chart-line"></i>&nbsp;&nbsp;Dashboard</a>
<?php
  foreach ($deviceID as $value) { // createlink for the deviceID payload.php line: 6
  echo "<a href='index.php?page=sensor&id=". $value . "' class='list-group-item list-group-item-action'><i class='fas fa-database'></i>&nbsp;&nbsp;". $value ."</a>";
  }
?>
      <a href='index.php?page=settings' class="list-group-item list-group-item-action"><i class="fas fa-cogs"></i>&nbsp;&nbsp;Settings</a>
    </div>
</div>
    <!-- /#sidebar-wrapper -->
