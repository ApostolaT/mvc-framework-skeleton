<?php


namespace Framework\Controller;

use Framework\Http\Request;

class Controller extends AbstractController
{
    public function getUser(array $requestAttr) {
        $response = $this->renderer->renderJson($requestAttr);
        return $response;
    }
}