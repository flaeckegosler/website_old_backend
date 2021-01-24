<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("./head.inc"); 

echo "<h2>Aktuelles:</h2>";

$limitPerPage = $pages->get("/news/")->news_limitperpage;
$dateLimit = $pages->get("/news/")->news_archiv_limit;
$dateInSec = $dateLimit*24*3600;
$dateLimit = time() - $dateInSec;

$start = ($input->pageNum - 1) * $limitPerPage;

$news = $pages->find("template=news_detail, sort=-created, created<{$dateLimit}, start={$start}, limit={$limitPerPage}");

foreach($news as $child) {
    $out = "";
    if(count($child->news_image)) {
       $image = $child->news_image;
       $imageurl = $image->url;
       $thumburl = $image->getCrop('thumbnail')->url;
   } else {
       $imageurl = $thumburl = $config->urls->templates."styles/images/news_placeholder.gif";
       $image = new Page();
   }
    
    $out .= "<div class='news-latest-item'>"; 
    $out .= "<span class='news-latest-date'>".strftime("%d.%m.%y %H:%M", $child->created)."</a></span>";
    $out .= "<h3><a href='{$child->url}'>{$child->news_title}</a></h3>";   
    $out .= "<a href='{$child->url}'><img src='{$thumburl}' width='160' height='107' alt='{$image->description}' /></a>";
    $out .= $child->news_intro."";
    $out .= "<div class='news-latest-morelink'><a href='{$child->url}'>[mehr]</a></div>";
    $out .= "</div>";
    
    echo $out;
}

echo $news->renderPager();

include("./foot.inc"); 
