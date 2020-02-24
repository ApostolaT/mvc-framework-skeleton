<?php

namespace Framework\Contracts;

use Framework\Http\Request;
use Framework\Routing\RouteMatch;

interface RouterInterface
{
    public function route(Request $request): RouteMatch;
}
