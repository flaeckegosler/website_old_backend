<?php 

/**
 * Page template
 *
 */
$large = NULL;
$thumb = NULL;

if(($page->images->first() != NULL) && ($page->basic_page_show_image)) {
    $large = $page->images->first();
    $thumb = $large->width(250);
}

include("./head.inc"); 

echo '<div class="csc-header csc-header-n1">';
echo '<h1>';
echo $page->artikel_titel;
echo '</h1>';
echo '</div>';

if($thumb != NULL) {echo '<a href="'.$large->url.'" data-lightbox="image-1" data-title="'.$large->description.'"><img id="lboximg" src="'.$thumb->url.'" /></a>';}
echo $page->body;


include("./foot.inc"); 

