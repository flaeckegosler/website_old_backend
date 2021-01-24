 <?php
   
$limitPerPage = $pages->get("/news/")->news_limitperpage;
$dateLimit = $pages->get("/news/")->news_archiv_limit;
$dateInSec = $dateLimit*24*3600;
$dateLimit = time() - $dateInSec;

$start = ($input->pageNum - 1) * $limitPerPage;
    
$news = $pages->find("template=news_detail, sort=-created");

$arr = array();

$out = "";
foreach($news as $child) {

    /* prepare images */
    if(count($child->news_image)) {
        $image = $child->news_image;
        $imageurl = $image->httpUrl;
        $thumburl = $image->getCrop('thumbnail')->httpUrl;
    } else {
        $imageurl = $thumburl = $config->urls->templates."styles/images/news_placeholder.gif";
    }

    /* prepare created date */
    if($child->date) {
        $dateUnix = $child->date;
        $dateFormatted = strftime("%A, %d.%m.%Y %H:%M", $child->date);
    } else {
        $dateUnix = $child->created;
        $dateFormatted = strftime("%A, %d.%m.%Y %H:%M", $child->created);
    }

    /* prepare author */
    if($child->news_author == NULL) {
        $author = $child->createdUser->user_real_name;
    } else {
        $author = $child->news_author;
    }

    array_push($arr, array(
                        'newsTitle' => $child->news_title, 
                        'imageURL' => $imageurl,
                        'cropImageURL' => $thumburl,
                        'timeCreatedUnix' => $dateUnix,
                        'timeCreatedFormatted' => $dateFormatted,
                        'newsCreatedBy' => $author,
                        'newsIntroText' => $child->news_intro,
                        'newsMainText' => $child->news_main,
                        'imageDescription' => $child->news_image->description,
                        'newsTags' => $child->news_tags,
                        'galleryLink' => $child->link));
}

header('Content-Type: application/json');
echo json_encode($arr, JSON_FORCE_OBJECT);
