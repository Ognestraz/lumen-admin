<?php

class UserAdminTest extends TestCase {

    public function testAdminFile()
    {
        $storeRand = rand(0, 1000000);
        $storeParams = ['name' => 'TestUser' . $storeRand, 'email' => 'testa' . $storeRand . '@gmail.com', 'password' => 'testpassword'];
        $updateRand = rand(0, 1000000);
        $updateParams = ['name' => 'TestUser' . $updateRand, 'email' => 'test' . $updateRand . '@gmail.com', 'password' => 'testpassword2'];
        $this->_simpleAdminController('user', $storeParams, $updateParams, ['password']);
    }
      
}