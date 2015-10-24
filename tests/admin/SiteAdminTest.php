<?php

class SiteAdminTest extends TestCase {

    public function testAdminSite()
    {
        $storeParams = ['parent' => 1, 'path' => 'test7', 'name' => 'Test7', 'content' => 'test content7'];
        $updateParams = ['parent' => 2, 'path' => 'test2', 'name' => 'Test2', 'content' => 'test content2'];
        
//        $id = 4;
//        $response = $this->call('POST', '/admin/site', $storeParams + ['_token' => csrf_token()]);
//        
//        print_r(Illuminate\Support\Facades\Input::all());
//        
//        $result = json_decode($response->getContent());
//        print_r($result);
//        
//        $id = $result->model->id;
//       // Illuminate\Support\Facades\Input::replace($updateParams);
//        $response = $this->call('PUT', '/admin/site/' . $id, $updateParams + ['_token' => csrf_token()]);
//        
//        print_r(Illuminate\Support\Facades\Input::all());
//        
//        $result = json_decode($response->getContent());
//        print_r($result);
//        exit;        
        
        //$this->_updateAction(4, 'site', $updateParams);
        
        $this->_simpleAdminController('site', $storeParams, $updateParams);
        //$this->_simpleAdminControllerSoftDeletes('site', $storeParams);
    }
      
    public function testAdminSite2()
    {
//        $storeParams = ['parent' => 1, 'path' => 'test7', 'name' => 'Test7', 'content' => 'test content7'];
//        $updateParams = ['parent' => 2, 'path' => 'test2', 'name' => 'Test2', 'content' => 'test content2'];
        
//        $id = 13;
//        
//        $response = $this->call('PUT', '/admin/site/' . $id, $updateParams + ['_token' => csrf_token()]);
//        $result = json_decode($response->getContent());
//        print_r($result);
//        exit;        
        
        //$this->_updateAction(4, 'site', $updateParams);
        
        //$this->_simpleAdminController('site', $storeParams, $updateParams);
        //$this->_simpleAdminControllerSoftDeletes('site', $storeParams);
    }    
    
}