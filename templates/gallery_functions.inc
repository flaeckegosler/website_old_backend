<?php

/*
 * Zeigt den Titel und Text an...
 */
function albumInfo() {
    $thisPage = wire("page");
    
    echo "<h1>{$thisPage->artikel_titel}</h1>";
    echo $thisPage->body;
}

/*
 * Zeigt eine Übersicht der Unteralben
 */
function showChildrenAlbums() {
    $thisPage = wire("page");
    $children = $thisPage->children;
    $thumbsize = getThumbSize($thisPage);
    
    $out = "";
    $out .="<div id='album'>";
    $out .= "<h1>{$thisPage->artikel_titel}</h1>";
    $out .= "<br />";
    foreach ($children as $child) {
        if(strcmp($child->template, "gallery_listchildalbums")==0) {
          $thumb = $child->child->gallery_images->first()->size($thumbsize, $thumbsize);
        } elseif(strcmp($child->template, "gallery_album")==0) {
          $thumb = $child->gallery_images->first()->size($thumbsize, $thumbsize);
        } else {
          continue;
        }
        $out .="<div class='albumimg'>";
        $out .="<a href='{$child->url}'>";
        $out .="<img src='{$thumb->url}' width='{$thumbsize}' height='{$thumbsize}' alt='' />";
        $out .="<div class='gallery-caption'>{$child->title}</div>";
        $out .="</a></div>";
    }
    //}
    $out .="</div>";
    echo $out;
}

/*
 * Zeigt ein Album mit Seitenunterteilung, welche von dem JS-Script per AJAX nachgeladen werden
 */
function albumShow() {
        
        $thisPage = wire("page");
        //$get = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        //$actualPage = $get == 0 ? 1:$get; 
        $limit = getLimitNumber($thisPage);
        //$start = $limit*($actualPage-1);
        //$albumimages = $thisPage->gallery_images->find("start={$start}, limit={$limit}");
        $numPictures = count($thisPage->gallery_images);
        
        $start = (wire("input")->pageNum - 1) * $limit;
        $total = count($thisPage->gallery_images);
        $images = $thisPage->gallery_images->slice($start, $limit);
        $a = new PageArray();
        foreach($images as $unused) $a->add(new Page());
        $a->setTotal($total);
        $a->setLimit($limit);
        $a->setStart($start);
        
	$out =" ";
	// Slides
	$out .="<div id='album'>";
        $out .= listThumbs($images, $thisPage);
        $out .="</div>";
        
        $out .= $a->renderPager();
    
        // Generate Pagination with the given limit
        /*
        $numPagination = intval(($numPictures/$limit)+0.999, 10);
        $i = 1;
        $out .="<ul id='pagination'>";
        do {
            $go = ($i == ($actualPage+1)) ? " class='next'":"";
            $out .="<li{$go}><a href='?page={$i}'>| Seite {$i} |</a></li>";
            $numPagination--;
            $i++;
        } while($numPagination > 0);
        $out .="</ul>";*/
        
        
        
	echo $out;
}

/*
 * Gibt ein HTML Text zurück mit divs in denen die Thumbnails enthalten sind mit links und allem
 * @output formatted Images in HTML
 * @input image Array
 */
function listThumbs($images, $actualPage) {
    $images->sort("basename");
    $thumbsize = getThumbSize($actualPage);
    $out = "";
    foreach ($images as $albumimage) {
        $thumb = $albumimage->size($thumbsize, $thumbsize);
        $out .="<div class='albumimg'>";
        $out .="<a href='{$albumimage->url}' data-lightbox='{$actualPage->title}' data-title='{$albumimage->description}'>";
        $out .="<img src='{$thumb->url}' width='{$thumbsize}' height='{$thumbsize}' alt='' />";
        $out .="<div class='gallery-caption'>{$albumimage->description}</div>";
        $out .="</a></div>";
    }
    return $out;
}

/*
 * Thumbnail Size auslesen, je nachdem wo etwas drin steht...
 */
function getThumbSize($actualPage) {
    
    $thumbSize =  intval($actualPage->parent->gallery_thumbnail_size);
    
    if($thumbSize == 0) {
        $thumbSize = intval($actualPage->parent->parent->gallery_thumbnail_size);
        if($thumbSize == 0) {
            $thumbSize = intval($actualPage->rootParent->gallery_thumbnail_size);
            if($thumbSize == 0) {
                $thumbSize == 150; /* Standard Value */
    }   }   }
    
    return $thumbSize;
}

/*
 * Limit auslesen um Bilder darzustellen, je nachdem wo etwas drin steht...
 */
function getLimitNumber($actualPage) {
    $limit = intval($actualPage->parent->gallery_limit);
    
    if($limit == 0) {
        $limit = intval($actualPage->parent->parent->gallery_limit);
        if($limit == 0) {
            $limit = intval($actualPage->rootParent->gallery_limit);
            if($limit == 0) {
                $limit = 20;
    }   }   }
    
    return $limit;
}

/*
 * Generate Pagination using PRocesswire
 */
function generatePagination($images) {
    $start = (wire("input")->pageNum - 1) * $limit;
    $total = count($images);
    $images = 
    $a = new PageArray();
    foreach($images as $unused) $a->add(new Page());
}