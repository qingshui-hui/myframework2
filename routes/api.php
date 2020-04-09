<?php

use Libs\Routing\Route;

Route::post('/boards/registerPosition', 'BoardController@registerPosition');

Route::post('/testApi', 'TestController@testApi');