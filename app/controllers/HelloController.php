<?php

use Phalcon\Mvc\Controller;

class HelloController extends Controller
{
    public function indexAction()
    {
        $response = [
            'message' => 'Hello from Phalcon!',
        ];

        return $this->response->setJsonContent($response);
    }
}
