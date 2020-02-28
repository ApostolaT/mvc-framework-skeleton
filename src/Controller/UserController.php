<?php


namespace Framework\Controller;

use Framework\Http\Request;
use Psr\Http\Message\RequestInterface;

class UserController extends AbstractController
{
//    public function getId(RequestInterface $request, array $requestAttr) {
//        $response = $this->renderer->renderJson($requestAttr);
//        return $response;
//    }
    public function getId(RequestInterface $request, array $requestAttr) {
        $response = $this->renderer->renderView("render.phtml", $requestAttr);
        return $response;
    }
}