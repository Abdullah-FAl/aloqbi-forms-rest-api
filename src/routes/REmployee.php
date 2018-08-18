<?php


use \AppClass\Controllers\CEmployee;

$app->group('/api/v1/employee',function() use ($app){


    $this->get('/info',                     (CEmployee::class . ':GetAllEmployeeInfo'));
    $this->get('/{employee_id}/tasks',      (CEmployee::class . ':GetEmployeeTasks'));
    $this->post('/add',                     (CEmployee::class . ':AddNewEmployeeInfo'));
    $this->put('/update',                   (CEmployee::class . ':UpdateEmployeeInfo'));
    $this->delete('/delete',                (CEmployee::class . ':DeleteEmployeeInfo'));
});


