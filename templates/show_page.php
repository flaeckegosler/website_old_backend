<?php

/*
 * Redirects to another page
 */

$forw = $page->forward;
$forwany = $page->forward_any;

if($forw) {
  $session->redirect($forw->url);
} elseif($forwany) {
  $session->redirect($forwany);
} else {
  $session->redirect($pages->get("/http404/"));
}