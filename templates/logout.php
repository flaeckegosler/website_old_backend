<?php

include("./head.inc"); 

$session->logout();

echo "<h1>Logout</h1><br />
      Du wurdest abgemeldet.";
        
include("./foot.inc"); 

?>