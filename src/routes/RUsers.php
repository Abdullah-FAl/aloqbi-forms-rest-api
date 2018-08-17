<?php

use \AppClass\Controllers\CUsers;
use \AppClass\Controllers\CUserGroup;

$app->group('/api/v1', function () use ($app){

$app->group('/users',function(){
    $this->get('/user/{user_id}',           (CUsers::class .  ':getUserById'));
    $this->get('/all',                      (CUsers::class .  ':getAllUsers'));
    $this->post('/add',                     (CUsers::class .  ':addUser'));
    $this->post('/user/{user_id}/update',   (CUsers::class .    ':updateUser'));
    $this->delete('/user/{user_id}/delete', (CUsers::class .  ':deleteUser'));
});


$app->group('/users/groups',function(){
    $this->get('/group/{group_id}',            (CUserGroup::class .  ':getGroupByID'));
    $this->get('/all',                         (CUserGroup::class .  ':getallGroup'));
    $this->post('/add',                        (CUserGroup::class .  ':addGroup'));
    $this->post('/group/{group_id}/update',    (CUserGroup::class .  ':updateUser'));
    $this->delete('/group/{user_id}/delete',   (CUserGroup::class .  ':deleteUser'));
});




});