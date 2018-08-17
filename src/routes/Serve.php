<?php

use \AppClass\Controllers\Serve;



$app->group('/hello',function(){

    $this->get('/add', (Serve::class . ':add'));

});



