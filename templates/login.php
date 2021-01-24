<?php

include("./head.inc"); 

if($user->isLoggedin()) {
    // user is already logged in, so they don't need to be here
    $session->redirect($pages->get("/intern/")->url); 
}

// check for login before outputting markup
if($input->post->user && $input->post->pass) {

    $user = $sanitizer->username($input->post->user);
    $pass = $input->post->pass; 

    if($session->login($user, $pass)) {
        // login successful
        $session->redirect($pages->get("/intern/")->url); 
    }
}

if($input->post->user) echo "<h2 class='error'>Login failed</h2>";

echo "<form action='./' method='post'>
        <p><label>User <input type='text' name='user' /></label></p>
        <p><label>Password <input type='password' name='pass' /></label></p>
        <p><input type='submit' name='submit' value='Login' /></p>
      </form>
      <p>Registrieren</p>";
        
include("./foot.inc"); 

?>