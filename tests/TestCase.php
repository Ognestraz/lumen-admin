<?php

use Illuminate\Support\Facades\Artisan;
use Model\User;

class TestCase extends Laravel\Lumen\Testing\TestCase {

    protected static $oneStarted = true;

    protected $baseUrl = 'http://admin.loc';
    
    protected $adminSection = [
        'site' => [
            'create',
         //   'index'
        ],
        'block' => [
            'create',
         //   'index'
        ]
    ];
    
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }    
    
    /**
     * 
     * @param string $uri
     * @return string
     */
    protected function getUrl($uri)
    {
        $adminUrl = config('app.admin_url');
        
        if ('/' !== $adminUrl) {
            $adminUrl = '/' . $adminUrl . '/';
        }
        
        return $adminUrl . $uri;
    }
    
    /**
     * Call the given URI and return the Response.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array   $parameters
     * @param  array   $cookies
     * @param  array   $files
     * @param  array   $server
     * @param  string  $content
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        Illuminate\Support\Facades\Input::replace($parameters);
        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }    
    
    public static function setUpBeforeClass()
    {
        if (self::$oneStarted) {
           Artisan::call('migrate:reset');
           Artisan::call('migrate');
           Artisan::call('db:seed');
           self::$oneStarted = false;
        }
    }

    protected function _compareFields($params, $data, $ex = []) 
    {

        foreach ($params as $key => $value) {
            if (!in_array($key, $ex)) {
                $this->assertEquals($value, $data->$key);
            }
        }        
        
    }
    
    protected function _destroyAction($id, $controller)
    {
        
        $response = $this->call('DELETE', $this->getUrl($controller . '/' . $id), ['_token' => csrf_token()]);
        $result = json_decode($response->getContent());
        $this->assertEquals(true, $result->result);        
        
    }
    
    protected function _deleteAction($id, $controller) 
    {
        $response = $this->call('DELETE', $this->getUrl($controller . '/delete/' . $id), ['_token' => csrf_token()]);
        $result = json_decode($response->getContent());
        $this->assertEquals(true, $result->result);
    }
    
    protected function _restoreAction($id, $controller) 
    {
        $response = $this->call('GET', $this->getUrl($controller . '/restore/' . $id), ['_token' => csrf_token()]);
        $result = json_decode($response->getContent());
        $this->assertEquals(true, $result->result);        
    }
    
    protected function _indexAction($controller) 
    {
        $response = $this->call('GET', $this->getUrl($controller));
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    protected function _showAction($id, $controller, $params = [], $ex = []) 
    {
        $response = $this->call('GET', $this->getUrl($controller . '/' . $id));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($id, $response->original[$controller]->id);
        $this->_compareFields($params, $response->original[$controller], $ex);
    }
    
    protected function _editAction($id, $controller, $params = [], $ex = []) 
    {
        $response = $this->call('GET', $this->getUrl($controller . '/' . $id . '/edit'));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($id, $response->original[$controller]->id);
        $this->_compareFields($params, $response->original[$controller], $ex);
    }
    
    protected function _storeAction($controller, $params = [], $ex = []) 
    {
        $response = $this->call('POST', $this->getUrl($controller), $params + ['_token' => csrf_token()]);
        
        $result = json_decode($response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->result);

        $this->_compareFields($params, $result->model, $ex);
        
        return $result->model->id;
    }
    
    protected function _updateAction($id, $controller, $params = [], $ex = []) 
    {
        $response = $this->call('PUT', $this->getUrl($controller . '/' . $id), $params + ['_token' => csrf_token()]);
        $this->assertEquals(200, $response->getStatusCode());
        $result = json_decode($response->getContent());
        $this->assertEquals(true, $result->result);
        $this->assertEquals($id, $result->model->id);
        
        $this->_compareFields($params, $result->model, $ex);
    }
    
    protected function _showActionDeleted($id, $controller) 
    {
        $response = $this->call('GET', $this->getUrl($controller . '/' . $id));
        
        $this->assertEquals(404, $response->getStatusCode());    
    }
    
    protected function _simpleAdminController($controller, $storeParams = [], $updateParams = [], $ex = []) 
    {
        $user = User::where(['name' => 'admin'])->first();
        $this->be($user);
        Session::start();

        $this->_indexAction($controller);

        if ($storeParams) {
        
            $id = $this->_storeAction($controller, $storeParams, $ex);

            $this->_showAction($id, $controller, $storeParams, $ex);

            $this->_editAction($id, $controller, $storeParams, $ex);                                

            if ($updateParams) {
                $this->_updateAction($id, $controller, $updateParams, $ex);  

                $this->_showAction($id, $controller, $updateParams, $ex);
            }
            
            $this->_destroyAction($id, $controller);

            $this->_showActionDeleted($id, $controller, $ex);
            
        }
    }
    
    protected function _simpleAdminControllerSoftDeletes($controller, $storeParams = [], $ex = []) 
    {
        $user = User::where(['name' => 'admin'])->first();
        $this->be($user);
        Session::start();

        $this->_indexAction($controller);

        if ($storeParams) {
        
            $id = $this->_storeAction($controller, $storeParams, $ex);

            $this->_showAction($id, $controller, $storeParams, $ex);

            $this->_deleteAction($id, $controller);

            $this->_showActionDeleted($id, $controller, $ex);
            
            $this->_restoreAction($id, $controller);

            $this->_showAction($id, $controller, $storeParams, $ex);
            
            $this->_destroyAction($id, $controller);
            
            $this->_showActionDeleted($id, $controller, $ex);
            
            $id = $this->_storeAction($controller, $storeParams, $ex);
            
            $this->_deleteAction($id, $controller);
            
            $this->_destroyAction($id, $controller);
            
        }
    }
    
    protected function _testGetAdmin($param = []) 
    {
        foreach ($this->adminSection as $keySection => $section) {

            $response = $this->call('GET', $this->getUrl($keySection));
            
            if (isset($param['assertRedirectedTo'])) {
                $this->assertRedirectedTo($param['assertRedirectedTo']);
            }
            
            if (isset($param['getStatusCode'])) {
                $this->assertEquals($param['getStatusCode'], $response->getStatusCode());
            }

            if ($section) {
                foreach ($section as $subSection) {

                    $response = $this->call('GET', $this->getUrl($keySection . '/' . $subSection));
                    if (isset($param['assertRedirectedTo'])) {
                        $this->assertRedirectedTo($param['assertRedirectedTo']);
                    }

                    if (isset($param['getStatusCode'])) {
                        $this->assertEquals($param['getStatusCode'], $response->getStatusCode());
                    }

                }
            }

        }
    }
    
}
