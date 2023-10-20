<?php
use Phalcon\Http\Request;
use \Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class Test2Controller extends Controller
{
public function indexAction()
{
$message = ""; // Initialize the message variable

if ($this->request->isPost()) {
$name = $this->request->getPost('name');
$this->view->uploadedFiles = $_FILES;

if ($this->request->hasFiles() && $this->request->getUploadedFiles('file')) {
$files = $this->request->getUploadedFiles('file');
if (count($files) === 1) {
$file = $files[0];

$url = 'https://api.openweathermap.org/data/2.5/weather?lat=43.3211301&lon=21.8959232&appid=60825efadeb08154a146559d1016ff34';
$response = file_get_contents($url);
$data = json_decode($response, true);

$user = new Test2();
$user->name = $name;
$user->weather = $data['main']['temp'];

// Assuming the database column name is 'file_data'
$user->file_data = file_get_contents($file->getTempName());

$success = $user->save();

if ($success) {
$message = "Thanks for registering!";
} else {
$message = "Greska pri registraciji;";
}
} else {
$message = "Samo jedan fajl molim";
}
}

$tempDir = sys_get_temp_dir();
$td = "System temporary directory je: " . $tempDir;
$this->view->setVar('td', $td);
if (is_writable($tempDir)) {
$a = "The directory is writable.";
$this->view->setVar('a', $a);
} else {
$a = "The directory is not writable.";
$this->view->setVar('a', $a);
}
}

$this->view->message = $message;
}
}
