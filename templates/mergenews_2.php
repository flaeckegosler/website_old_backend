<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include("./head.inc"); 

$p = new Page();
$p->template = 'news_detail';
$p->parent = wire('pages')->get('/news/news-artikel/');
$p->news_title = $p->title = "Titel";
$p->news_intro = "<p>Introtext</p>";
$p->news_main = "<p>BodyText</p>";
$p->save();
// Upload Picture
/* DIESER BEFEHL KANN BEIM FELD CROPIMAGE NICHT ANGEWENDET WERDEN... LÖSUNG GESUCHT */
$p->news_image->add("D:\Users\Philippe\Pictures\b.jpg");
$p->save();

echo "Created ".$p->name."<br />";

include("./foot.inc"); 