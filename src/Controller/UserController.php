<?php

namespace Framework\Controller;

use Psr\Http\Message\RequestInterface;

class UserController extends AbstractController
{
    public function getId(RequestInterface $request) {
        $response = $this->renderer->renderView("render.phtml", $request->getRequestParameters());
        return $response;
    }

    // TODO finish postAll to send body with arguments
    public function postAll(RequestInterface $request) {
        $postBody = $request->getBody();
        $postBody = $postBody->getContents();

        return $this->renderer->renderView("render.phtml", $request->getRequestParameters());
    }

    public function deleteUser(RequestInterface $request) {
        return  $this->renderer->renderJson($request->getRequestParameters());
    }
}