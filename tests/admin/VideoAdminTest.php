<?php

class VideoAdminTest extends TestCase {

    public function testAdminVideo()
    {

        $storeParams = ['name' => 'Test', 'description' => 'test preview', 'url' => 'http://youtube.com/watch?v=UbrNH5pj_5g'];
        $updateParams = ['name' => 'Test2', 'description' => 'test preview2', 'url' => 'https://vimeo.com/5861039', 'preview' => 'http://i.vimeocdn.com/video/482633600_250.jpg'];
        $this->_simpleAdminController('video', $storeParams, $updateParams);

    }

}
