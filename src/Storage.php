<?php


namespace App;


use App\http\Request;

class Storage
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addToStorage()
    {
        $extension = pathinfo($_FILES['book']['name']);
        $extension = $extension['extension'];
        $bookName = $this->request->input('bookName');
        $tmpName = $_FILES['book']['tmp_name'];
        $fileName = $bookName . ".$extension";

        $filePath = APP_PATH . "/storage/$fileName";

        move_uploaded_file($tmpName, $filePath);
    }
}