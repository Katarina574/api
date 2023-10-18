<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
class UploadController extends Controller
{
    public function indexAction()
    {
        $response = new \Phalcon\Http\Response();

        try {
            $file = $this->request->getUploadedFiles()[0];
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $maxFileSize = 5242880; // 5 MB

            if (in_array($file->getExtension(), $allowedExtensions) && $file->getSize() <= $maxFileSize) {
                $newFileName = uniqid() . '.' . $file->getExtension();

                //poziv weather api-ja
                $url = 'https://api.openweathermap.org/data/2.5/weather?lat=43.3211301&lon=21.8959232&appid=60825efadeb08154a146559d1016ff34';
                $response = file_get_contents($url);
//dd ($response);
                $data = json_decode($response, true);

                //cuvam podatke o vremenu u bazi
                $fileRecord = new FileModel();
                $fileRecord->name = $file->getName();
                $fileRecord->link = $newFileName;
                $fileRecord->temperature = $data['main']['temp'];
                $fileRecord->uploadTime = date('Y-m-d H:i:s');
                $fileRecord->weatherDescription = $data['weather'][0]['description'];
                $fileRecord->save();

                $response->setJsonContent(['message' => 'Fajl uspešno uploadovan']);
            } else {
                $response->setJsonContent(['message' => 'Nevažeći tip fajla ili veličina']);
            }
        } catch (\Exception $e) {
            $response->setJsonContent(['message' => $e->getMessage()]);
        }
        return $response;
    }
}