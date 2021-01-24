<?php 

/**
 * Site map template
 *
 */

include("./head.inc"); 

function sitemapListPage($page) {
    
    if($page->numChildren) {
        echo "<ul>";
        foreach($page->children as $child) {
            echo "<li><a href='{$child->url}'>{$child->title}</a>";
            sitemapListPage($child);
            echo "</li>";
        }
        echo "</ul>";
    }
    
}

echo "<h1>Sitemap</h1>";
echo "<div class='csc-sitemap'>";
sitemapListPage($pages->get("/")); // List whole Menutree
sitemapListPage($pages->get("/icons/")); // List also IconPages
echo "</div>";

include("./foot.inc"); 

