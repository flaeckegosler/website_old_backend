<?php 
$right = $pages->get('/settings/right/');
$sponsors = $right->find("include=hidden, template=right_sponsors");
$i = 1; // Divs nummerieren

foreach($sponsors as $sponsor) {
	echo '<div id="sponsor'.$i.'">';
		// Insert Link, if nothing is present insert #
		echo '<a href="';
		if($sponsor->right_sponsor_url == NULL) {
			echo '#"';
		} else {
			echo $sponsor->right_sponsor_url.'" target="_blank"';
		}
		echo ' >';

		// Insert picture
		echo '<img src="';
		echo $sponsor->right_sponsor_img->url;
		echo '" width="160" height="'.$sponsor->right_sponsor_height.'" border="0" alt="';
		echo $sponsor->right_sponsor_img->description;
		echo '" /></a>';
		
		$i++;
	echo '</div>';
}

