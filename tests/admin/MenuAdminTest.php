<?php

class MenuAdminTest extends TestCase {

    public function testAdminFile()
    {
        $storeParams = ['name' => 'Test', 'preview' => 'test preview', 'path' => 'test'];
        $updateParams = ['name' => 'Test2', 'preview' => 'test preview2', 'path' => 'test2'];
        $this->_simpleAdminController('menu', $storeParams, $updateParams);
    }
      
}