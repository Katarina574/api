<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class FileController extends Controller
{
    public function listAction()
    {
        $response = new Response();
        $request = new Request();

        if ($request->isGet()) {
            //uslov - izlistaj sve fajlove koji nisu oznaceni kao obrisani, jer oni koji jesu umesto null imaju trenutno vreme - soft delete
//            $files = File::find([
//                'conditions' => 'deletedAt IS NULL',
//            ]); //uslov nije dobar, pogledaj zasto i sredi

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
                //posstavi deletedAt na trenutno vreme za soft brisanje
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
