<?php

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

use Libs\Routing\RouteList;
function printRouteList()
{
    $routeList = RouteList::getInstance();
    $routeList->print();
}