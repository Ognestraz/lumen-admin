<?php

class BlockAdminTest extends TestCase {

    public function testAdminFile()
    {
        $storeParams = ['name' => 'Test', 'content' => 'test content', 'parent' => 0];
        $updateParams = ['name' => 'Test2', 'content' => 'test content2'];
        $this->_simpleAdminController('block', $storeParams, $updateParams);
    }
      
}