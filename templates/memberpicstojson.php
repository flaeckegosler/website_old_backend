<?php

$arr = array();

$cropRatio = 0.81;
$moveUpPercent = 0.12;

$placeholderURL = "https://flaeckegosler.ch".$config->urls->templates."styles/images/portrait_placeholder_140x210.jpg";

foreach($pages->get("/mitglieder/aktivmitglieder/")->children as $page) {
    $mitglieder = $page->mitglieder;

    foreach($mitglieder as $mitglied) {
        if(count($mitglied->mitglieder_image)) {
            $portrait = $mitglied->mitglieder_image;
            $w = $portrait->width();

            $portraitSquareUncropped = $portrait->size($w, $w);
            $newWidth = $w*$cropRatio;
            $startPxL = (($w-$newWidth)/2);
            $startPxT = ($startPxL*(1-$moveUpPercent));
            $portraitSquareURL = $portraitSquareUncropped->crop($startPxL, $startPxT, $newWidth, $newWidth)->httpUrl;
        } else {
            $portraitSquareURL = $placeholderURL;
        }

        array_push($arr, array(
            'pictureDescription' => strip_tags($mitglied->body),
            'picturePortraitSquare' => $portraitSquareURL
        ));
    }
}

header('Content-Type: application/json');
echo json_encode($arr, JSON_FORCE_OBJECT);
