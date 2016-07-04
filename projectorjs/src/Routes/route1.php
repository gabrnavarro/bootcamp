<?php


$app->get('/', 'LoginController:login_redirect');

$app->post('/', 'LoginController:postSignup');

$app->get('/projects', 'LoginController:projects_redirect')->add('LoginController:login_check');

$app->get('/logout', 'LoginController:logout');

$app->get('/projects/create', 'ProjectController:create_redirect')->add('LoginController:login_check');

$app->post('/projects/create', 'ProjectController:create_form_submit');

$app->get('/persons/create', 'PersonsController:create_redirect')->add('LoginController:login_check');

$app->post('/persons/create', 'PersonsController:create_form_submit')->add('LoginController:login_check');

$app->get('/projects/assignments', 'ProjectController:assign_project_redirect')->add('LoginController:login_check');

$app->get('/projects/member_info', 'ProjectAssignController:send_member_info');

$app->get('/projects/nonmember_info', 'ProjectAssignController:send_nonmember_info');

$app->post('/projects/assign', 'ProjectAssignController:add_member');

$app->post('/projects/unassign', 'ProjectAssignController:remove_member');

$app->get('/session', 'LoginController:session');




