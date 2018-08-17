<?php


use \AppClass\Controllers\CEvaluationResults;

$app->group('/api/v1/evaluation',function() use ($app){

    $this->get('/report/employee/{employee_id}/tasks',                 (CEvaluationResults::class . ':GetEvaluationEmployeeTasks'));
    $this->get('/report/employee/{employee_id}/tasks/{tasks_id}',      (CEvaluationResults::class . ':GetEvaluationEmployeeTasksStandard'));
    $this->post('/employee/add',                                       (CEvaluationResults::class . ':AddNewEvaluationResultsData'));



    $this->get('/report/quick/employee/{employee_id}',          (CEvaluationResults::class . ':GetQuickEvaluationEmployee'));
    $this->post('/quick/employee/add',                          (CEvaluationResults::class . ':AddNewQuickEvaluationResultsData'));

});


