<?php


use \AppClass\Controllers\CStandard;

$app->group('/api/v1/standard',function() use ($app){


    $this->get('/info',      (CStandard::class . ':GetAllStandardInfo'));
    $this->post('/add',      (CStandard::class . ':AddNewStandardInfo'));
    $this->put('/update',    (CStandard::class . ':UpdateStandardInfo'));
    $this->delete('/delete', (CStandard::class . ':DeleteStandardInfo'));
});


