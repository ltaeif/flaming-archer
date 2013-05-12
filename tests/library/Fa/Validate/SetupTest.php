<?php

namespace Fa\Validate;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-03 at 20:58:10.
 */
class SetupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Setup
     */
    protected $validator;
    
    /**
     * @var array
     */
    protected $setupData;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->validator = new Setup();
        
        $this->setupData = array(
            'name' => 'Jeremy Kendall',
            'email' => 'jeremy@example.com',
            'flickr_api_key' => '65a85f6cf16bb97b44b455af71ce0d1b',
            'password' => 'secretpassword',
            'confirm_password' => 'secretpassword'
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->validator = null;
    }

    public function testValidateValidData()
    {
        $this->assertTrue($this->validator->isValid($this->setupData));
        $this->assertEquals($this->setupData, $this->validator->getValues());
    }
    
    public function testValidateInvalidData()
    {
        $this->setupData['email'] = 'not an email address';
        $this->setupData['confirm_password'] = 'does not match';
        
        $this->assertFalse($this->validator->isValid($this->setupData));
        $this->assertEquals($this->setupData, $this->validator->getValues());
        $messages = $this->validator->getMessages();
        $this->assertInternalType('array', $messages);
        $this->assertEquals(2, count($messages));
        $this->assertArrayHasKey('email', $messages);
        $this->assertArrayHasKey('emailAddressInvalidFormat', $messages['email']);
        $this->assertArrayHasKey('confirm_password', $messages);
        $this->assertArrayHasKey('notSame', $messages['confirm_password']);
    }
    
    public function testFilterValues()
    {
        $this->setupData['name'] = '  <h1>Jeremy Kendall</h1>   ';
        $this->setupData['email'] = '     <b>me@example.com</b>';
        $this->assertTrue($this->validator->isValid($this->setupData));
        $data = $this->validator->getValues();
        $this->assertEquals('Jeremy Kendall', $data['name']);
        $this->assertEquals('me@example.com', $data['email']);
    }

}
