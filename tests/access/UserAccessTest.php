<?php

use Model\User;

class UserAccessTest extends TestCase {

    public function testAccessAdmin2Admin()
    {
        $user = User::where(['name' => 'admin'])->first();
        $this->be($user);
        $response = $this->call('GET', '/admin');
        //$this->assertEquals($response->original->getName(), 'admin.index');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAccessGuest2Admin()
    {
        $response = $this->call('GET', '/admin');
        //$this->assertEquals($response->original->getName(), 'admin.login');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAccessUser2Admin()
    {
        $user = User::where(['name' => 'user1'])->first();
        $this->be($user);
        $response = $this->call('GET', '/admin');
        $this->assertRedirectedTo('/');
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testAdmin2AdminSection()
    {
        $user = User::where(['name' => 'admin'])->first();
        $this->be($user);
        $this->_testGetAdmin(['getStatusCode' => 200]);
    }

    public function testGuest2AdminSection()
    {
        $this->_testGetAdmin(['assertRedirectedTo' => '/admin', 'getStatusCode' => 302]);
    }

    public function testUser2AdminSite()
    {
        $user = User::where(['name' => 'user1'])->first();
        $this->be($user);
        $this->_testGetAdmin(['assertRedirectedTo' => '/', 'getStatusCode' => 302]);
    }

    public function testAdminAuth2()
    {
        $user = new User(array('id' => 1));
        $this->be($user);
        $response = $this->call('GET', '/admin');
        $this->assertEquals(200, $response->getStatusCode());
    }

}
