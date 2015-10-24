<?php

class FileAdminTest extends TestCase {

    public function testAdminFile()
    {
        copy(base_path() . '/resources/test/1.css', base_path() . '/resources/test/test1.css');
        copy(base_path() . '/resources/test/2.css', base_path() . '/resources/test/test2.css');
        $uploadedFile1 = new \Symfony\Component\HttpFoundation\File\UploadedFile(base_path() . '/resources/test/test1.css', 'test1.css', 'text/css', null, null, true);
        $uploadedFile2 = new \Symfony\Component\HttpFoundation\File\UploadedFile(base_path() . '/resources/test/test2.css', 'test2.css', 'text/css', null, null, true);

        $storeParams = ['name' => 'Test', 'description' => 'test preview', 'filename' => $uploadedFile1];
        $updateParams = ['name' => 'Test2', 'description' => 'test preview2', 'filename' => $uploadedFile2];
        $this->_simpleAdminController('file', $storeParams, $updateParams, ['filename']);
    }
      
}
