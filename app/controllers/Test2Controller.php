<?php

use Phalcon\Http\Request;
use \Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class Test2Controller extends Controller
{
    public function indexAction()
    {
        if ($this->request->isPost()) {
            $name = $this->request->getPost('name');

            $url = 'https://api.openweathermap.org/data/2.5/weather?lat=43.3211301&lon=21.8959232&appid=60825efadeb08154a146559d1016ff34';
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            $user = new Test2();
            $user->name = $name;
            $user->weather = $data['main']['temp'];

            if ($user->save()) {
                $this->flash->success('Podaci su uspešno sačuvani.');
            } else {
                $this->flash->error('Greska');
            }
        }
    }
}