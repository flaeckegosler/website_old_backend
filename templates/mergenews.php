<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include("./head.inc"); 



// Hier wird die Gosler-Datenbank angezapft
$server = "localhost";
$database = "flaeckimerge";
$user = "root";
$pass = "root";

$link = mysqli_connect($server, $pass, $user);
if (!$link) {
    die('Verbindung schlug fehl: ' . mysqli_error());
}
echo 'Erfolgreich verbunden<br />';

$db = mysqli_select_db($link, $database);

/* De ganz gagi met UTF8 */
$strQuery = "SET character_set_results = 'utf8', 
  character_set_client = 'utf8', 
  character_set_connection = 'utf8', 
  character_set_database = 'utf8', 
  character_set_server = 'utf8'";
mysqli_query($link, $strQuery);  

$filelist = find_all_files($config->paths->templates."uploads");

if($db) {
    $res = mysqli_query($link, "SELECT * from `tt_news`");
    //echo "<table>";
    $i = 1;
    while ($row = mysqli_fetch_array($res, MYSQL_ASSOC)) {
        // ausgabe wie gewünscht
        $title = $row["title"];
        $intro = "<p>".$row["short"]."</p>";
        $body = "<p>".$row["bodytext"]."</p>";
        $createDate = $row["datetime"]; // Unix Format Date in UMT+00
        $picname = $row["image"];
        
        $dateformatted = strftime("%A, %d.%m.%Y %H:%M.%S", $createDate);
        
        $picarr = str_getcsv($picname, ',');
        $picpath = find_file($filelist, $picarr[0]);
        
        
        $p = new Page();
        $p->template = 'news_detail';
        $p->parent = wire('pages')->get('/news/news-artikel/');
        $p->news_title = $p->title = $title;
        $p->news_intro = $intro;
        $p->news_main = $body;
        $p->save();
        // Upload Picture
        //echo $picpath;
        if($picpath != NULL) {
            /* DIESER BEFEHL KANN BEIM FELD CROPIMAGE NICHT ANGEWENDET WERDEN... LÖSUNG GESUCHT */
            $p->news_image->add($picpath);
            $p->save();
        }
        // Creation Date in DB
        $sql = "UPDATE `pages` SET `created` = '".date('Y-m-d H:i:s', $createDate)."', `modified` = '".date('Y-m-d H:i:s', $createDate)."' WHERE `name` = '".$p->name."';";
        $update = wire('db')->query($sql);
        
        echo "Created ".$i.":".$p->name."<br />";
        
        /*
        $pic = "<img src='".$picpath."' alt='' />";
        $out = "";
        $out .= "<tr ><td style='border: 1px solid'>Title ".$i.": ".$title."</td>";
        $out .= "<td style='border: 1px solid'>Introtext: ".$intro."</td>";
        $out .= "<td style='border: 1px solid'>Bodytext: ".$body."</td>";
        $out .= "<td style='border: 1px solid'>Date: ".$dateformatted."</td>";
        $out .= "</tr></table>".$pic."<table>";
        echo $out;*/
        $i++;
        //if($i > 3) { break; }
    }
    //echo "</table>";
}

mysqli_close($link);


// Ab Hier Pwire Tests
/*
include("./TUT_header.inc");

$page = $pages->get("/news/testpage1/");
$cdate = $page->created;
$mdate = $page->modified;

$out = "";
$out .= $page->body;
$out .= "<br />";
$out .= "Creation Date: ".strftime("%A, %d.%m.%Y %H:%M.%S", $page->created)."<br />";
$out .= "Created From: ".$page->createdUser->name."<br />";
$out .= "Modified Date: ".strftime("%A, %d.%m.%Y %H:%M.%S", $page->modified)."<br />";
$out .= "Modified From: ".$page->modifiedUser->name."<br />";

// So wird das Datum in der SQL-DB geändert
$sql = "UPDATE `pages` SET `modified` = '".date('Y-m-d H:i:s', time())."' WHERE `name` = '".$page->name."';";
$update = wire('db')->query($sql);

$out .= "Modified Date after reset: ".strftime("%A, %d.%m.%Y %H:%M.%S", $page->modified)."<br />";

echo $out;

echo "llaksjdf".($page->siblings->getTotal()+1);
*/
// Create New Page Test
/*
$p = new Page();
$p->template = 'Article';
$p->parent = wire('pages')->get('/news/');
$p->name = $p->title = "Testpage".($page->siblings->getTotal()+1);

$p->body = "Lorem Ipsum ".time();
$p->save();

echo 'id: '.$p->id.'<br/>';
echo 'path: '.$p->path;*/

//include("./TUT_footer.inc");

function find_all_files($dir) 
{ 
    $root = scandir($dir); 
    foreach($root as $value) 
    { 
        if($value === '.' || $value === '..') {continue;} 
        if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;} 
        foreach(find_all_files("$dir/$value") as $value) 
        { 
            $result[]=$value; 
        } 
    } 
    return $result; 
}

function find_file($files, $wanted) {
    $i;
    foreach($files as $file) {
        if(basename($file)==basename($wanted)) {
            return $file;
        }
    }
    return NULL;
}

include("./foot.inc"); 