<?php

use \AppClass\Controllers\CLogin;

$app->group('/api/auth',function(){

    $this->post('/login', (CLogin::class .  ':loginON'));
    $this->get('/loginout', (CLogin::class . ':loginOFF'));
});
