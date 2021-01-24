<?php

include("./head.inc");

echo '<h1>Nimm mit uns Kontakt auf</h1><br /><br />';

echo $modules->get('SimpleContactForm')->render();

include("./foot.inc");
