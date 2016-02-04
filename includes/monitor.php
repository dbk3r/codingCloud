
<?php




?>
<p align=right><img onClick="reloadJobs();" valign=middle  class=clRelProc src=img/refresh.png></p>
<br><br>
<div id="monitortabs">
  <ul>
    <li><a href="#Tab-Encoder">Encoder</a></li>
    <li><a href="#Tab-Jobs">Jobs</a></li>
    
  </ul>
  <div id="Tab-Encoder">
  	<?php include_once 'read_encoder.php'; ?>
     </div>
  <div id="Tab-Jobs">
  	<?php include_once 'read_jobs.php'; ?>
    </div>
  
</div>

