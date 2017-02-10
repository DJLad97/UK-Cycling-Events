<?php
require('includes/conn.inc.php');
$sortBy = filter_var(strip_tags(trim($_POST['sortBy'])), FILTER_SANITIZE_STRING);


if($sortBy == 'MTB')
  $_SESSION['event'] = "SELECT * FROM races WHERE RaceType = 'MTB'";
else if($sortBy == 'Road')
  $_SESSION['event'] = "SELECT * FROM races WHERE RaceType = 'Road'";
else {
  $_SESSION['event'] = "SELECT * FROM races";
}

switch($sortBy){
    case 'MTB':
        $_SESSION['event'] = "SELECT * FROM races WHERE RaceType = 'MTB'";
        break;
    case 'Road':
        $_SESSION['event'] = "SELECT * FROM races WHERE RaceType = 'Road'";
        break;
    case 'RaceDate':
        $_SESSION['event'] = "SELECT * FROM races ORDER BY RaceDate ASC";
        break;
    case 'ClosingEntryDate':
        $_SESSION['event'] = "SELECT * FROM races ORDER BY ClosingEntryDate ASC";
        break;
}

header('Location: race-listings.php');

?>
