<?php 

// namespace erd\core\reg;

// use erd\core\reg\registry\Registry;
use erd\Backend\Controller\User\UserController as UserController;
use erd\core\routing\RouteControl;
use erd\core\render\Render;

RouteControl::get('/', fn() =>Render::view("main"));
RouteControl::get('/test', fn() =>UserController::index());
// RouteControl::get('/index', []);