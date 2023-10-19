<?php

use Phalcon\Http\Request;
use \Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class TestController extends Controller
{
    public function indexAction()
    {
        $response = new \Phalcon\Http\Response();

        try {
            $file = $this->request->getUploadedFiles();
//            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $maxFileSize = 5242880; // 5 MB

//            if (in_array($file->getExtension(), $allowedExtensions) && $file->getSize() <= $maxFileSize) {
//                $newFileName = uniqid() . '.' . $file->getExtension(); //uslov proveri i sredi
            $newFileName = uniqid();

            //poziv weather api-ja
            $url = 'https://api.openweathermap.org/data/2.5/weather?lat=43.3211301&lon=21.8959232&appid=60825efadeb08154a146559d1016ff34';
            $response = file_get_contents($url);
//dd ($response);
            $data = json_decode($response, true);

            //cuvam podatke o vremenu u bazi
            $fileRecord = new File();
//                $fileRecord->name = $file->getName();
            $fileRecord->link = $newFileName;
            $fileRecord->temperature = $data['main']['temp'];
            $fileRecord->uploadTime = date('Y-m-d H:i:s');
            $fileRecord->weatherDescription = $data['weather'][0]['description'];
            $fileRecord->save();

//                $response->setJsonContent(['message' => 'Fajl uspešno uploadovan']);
//            } else {
//                $response->setJsonContent(['message' => 'Nevažeći tip fajla ili veličina']);
//            }
        } catch (\Exception $e) {
//            $response->setJsonContent(['message' => $e->getMessage()]);
        }

        $message = $fileRecord->temperature = $data['main']['temp'];
        return $this->view->message = $message;
//    }
    }
    public function listAction()
    {
        $response = new Response();
        $request = new Request();

        if ($request->isGet()) {
            //uslov - izlistaj sve fajlove koji nisu oznaceni kao obrisani, jer oni koji jesu umesto null imaju trenutno vreme - soft delete
//            $files = File::find([
//                'conditions' => 'deletedAt IS NULL',
//            ]);
//            $files = File::find();

            $fileList = [];
            foreach ($files as $file) {
                $fileList[] = [
                    'id' => $file->id,
                    'name' => $file->name,
                    'link' => $file->link,
                    'temperature' => $file->temperature,
                    'weatherDescription' => $file->weatherDescription,
                    'uploadTime' => $file->uploadTime
                ];
            }

            $response->setJsonContent($fileList);
        } else {
            $response->setJsonContent(['message' => 'Samo GET zahtevi su dozvoljeni']);
        }

        return $response;
    }

    public function deleteAction($id)
    {
        $response = new Response();
        $request = new Request();

        if ($request->isDelete()) {
            //nadji fajl po id-u
            $file = File::findFirst($id);

            if ($file) {
                //posstavi deletedAt na trenutno vreme za "meko" brisanje
                $file->deletedAt = date('Y-m-d H:i:s');
                $file->save();

                $response->setJsonContent(['message' => 'Fajl uspešno obrisan']);
            } else {
                $response->setJsonContent(['message' => 'Fajl nije pronađen']);
            }
        } else {
            $response->setJsonContent(['message' => 'Samo DELETE zahtevi su dozvoljeni']);
        }

        return $response;
    }
}