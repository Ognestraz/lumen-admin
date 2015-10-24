<?php

class ImageAdminTest extends TestCase {
        
    public function testAdminImage()
    {

        copy(base_path() . '/resources/test/1.jpg', base_path() . '/resources/test/test1.jpg');
        copy(base_path() . '/resources/test/2.jpg', base_path() . '/resources/test/test2.jpg');
        $uploadedFile1 = new \Symfony\Component\HttpFoundation\File\UploadedFile(base_path() . '/resources/test/test1.jpg', 'test1.jpg', 'image/jpeg', null, null, true);
        $uploadedFile2 = new \Symfony\Component\HttpFoundation\File\UploadedFile(base_path() . '/resources/test/test2.jpg', 'test2.jpg', 'image/jpeg', null, null, true);

        $storeParams = ['name' => 'Test', 'description' => 'test preview', 'filename' => $uploadedFile1];
        $updateParams = ['name' => 'Test2', 'description' => 'test preview2', 'filename' => $uploadedFile2];
        $this->_simpleAdminController('image', $storeParams, $updateParams, ['filename']);

    }
}
