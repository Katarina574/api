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
            if ($this->request->hasFiles()) {
                $files = $this->request->getUploadedFiles();
                if (count($files) === 1) {
                    $file = $files[0];
                    $fileName = $file->getName();
                } else {
                    $message = "Samo jedan fajl molim";
                }
            }
            $url = 'https://api.openweathermap.org/data/2.5/weather?lat=43.3211301&lon=21.8959232&appid=60825efadeb08154a146559d1016ff34';
            $response = file_get_contents($url);
            $data = json_decode($response, true);


//           var_dump($file->getTempName());
//            $realPath = $file->get
//            $fileContents = file_get_contents($realPath);

            $user = new Test2();
            $user->name = $name;
            $user->weather = $data['main']['temp'];
            $user->file = $file;

            $success = $user->save();

            if ($success) {
                $message = "Thanks for registering!";
            } else {
                $message = "Greska pri registraciji;";
            }
            $tempDir = sys_get_temp_dir();
            $td = "System temporary directory je: " . $tempDir;
            $this->view->setVar('td', $td);
            if (is_writable($tempDir)) {
                // The directory is writable.
                $a ="The directory is writable.";
                $this->view->setVar('a', $a);
            } else {
                $a ="The directory is not writable.";
                $this->view->setVar('a', $a);
            }
            $this->view->message = $message;
        }

    }
}
