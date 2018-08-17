<?php


use \AppClass\Controllers\CTasks;

$app->group('/api/v1/tasks',function() use ($app){

    $this->get('/{tasks_id}/standard',  (CTasks::class . ':GetStandardOfTasks'));
    $this->get('/info',      (CTasks::class . ':GetAllTasksInfo'));
    $this->post('/add',      (CTasks::class . ':AddNewTasksInfo'));
    $this->put('/update',    (CTasks::class . ':UpdateTasksInfo'));
    $this->delete('/delete', (CTasks::class . ':DeleteTasksInfo'));
});


