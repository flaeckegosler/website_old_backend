<?php

include("./head.inc"); 
include("./gallery_functions.inc");

echo "<div id='albumcontent'>";
// Give the news index page a title an a bit of an intro
albumInfo();

echo '<br />';

// Render the Album List
albumShow();
echo "</div>";

// Start the jQuery Plugin "Infinite AJAX Scroll"
    //$out = "<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>"; <-- Was the original jquery code used for this plugin
    $out ="<script type='text/javascript' src='{$config->urls->templates}scripts/jquery-ias.min.js'></script>";
    $out .="<script type='text/javascript' src='{$config->urls->templates}scripts/startInfiniteAjaxScroll.js'></script>";
    echo $out;

include("./foot.inc");