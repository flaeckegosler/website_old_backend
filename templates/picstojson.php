 <?php
    
$galleryalbums = $pages->find("template=gallery_album, sort=-created");

$arr = array();

$out = "";
foreach($galleryalbums as $album) {
	$tmp = array();

    array_push($arr, array(
                        'menuTitle' => $album->title,
                        'albumTitle' => $album->artikel_titel,
                        'bodyText' => $album->body,
                        'dateUnix' => $album->created,
                        'dateFormatted' => strftime("%A, %d.%m.%Y %H:%M", $album->created),
                        'pictures' => $album->gallery_images->explode('httpUrl')));
}

header('Content-Type: application/json');
echo json_encode($arr, JSON_FORCE_OBJECT);

//$album = $galleryalbums->first();
//echo json_encode($album->gallery_images->explode('url'));
