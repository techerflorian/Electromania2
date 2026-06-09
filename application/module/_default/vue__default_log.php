<?php
$recentLogs = Logger::getLast(50);

//echo "<pre>";
foreach ($recentLogs as $log) {
    echo $log . "<br><br>";
}
//echo "</pre>";
?>
