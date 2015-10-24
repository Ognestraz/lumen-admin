<?php

use Model\User;

class VideoAdminServiceTest extends TestCase {

    protected function _previewAdminVideo($params) 
    {
        
        $user = User::where(['name' => 'admin'])->first();
        $this->be($user);
        Session::start();
        
        $response = $this->call('POST', '/admin/video', $params + ['_token' => csrf_token()]);
  
        $result = json_decode($response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->result);        
        
        $this->assertNotEmpty($result->model->preview);
        
        $getHeaders = @get_headers($result->model->preview);
        $this->assertEquals(true, is_numeric(stripos($getHeaders[0], '200 OK')));
        $this->assertNotEmpty(exif_imagetype($result->model->preview));
        
        $response = $this->call('DELETE', '/admin/video/' . $result->model->id, ['_token' => csrf_token()]);
        $result = json_decode($response->getContent());
        $this->assertEquals(true, $result->result);
        
    }    
    
    public function testAdminVideo()
    {

        $previewParams = [
            'youtube' => ['name' => 'YouTube', 'description' => 'YouTube preview', 'url' => 'http://youtube.com/watch?v=UbrNH5pj_5g'],
            'vimeo' => ['name' => 'Vimeo', 'description' => 'Vimeo preview', 'url' => 'https://vimeo.com/100974127'],
            'vk' => ['name' => 'VK', 'description' => 'VK preview', 'url' => '<iframe src="//vk.com/video_ext.php?oid=-30315369&id=171405908&hash=6c8047ac29f791eb&hd=2" width="853" height="480"  frameborder="0"></iframe>']
        ];

        $this->_previewAdminVideo($previewParams['youtube']);
        $this->_previewAdminVideo($previewParams['vimeo']);
        $this->_previewAdminVideo($previewParams['vk']);

    }

}
