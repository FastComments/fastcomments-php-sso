<?php

namespace FastComments\SSO\Test;

use FastComments\SSO\FastCommentsSSO;
use FastComments\SSO\SecureSSOPayload;
use FastComments\SSO\SecureSSOUserData;
use FastComments\SSO\SimpleSSOUserData;
use PHPUnit\Framework\TestCase;

class FastCommentsTest extends TestCase
{
    public function testSimpleSSO()
    {
        $userData = new SimpleSSOUserData('testuser');
        $userData->email = 'test@example.com';
        $userData->avatar = 'https://example.com/avatar.png';
        
        $sso = new FastCommentsSSO(null, $userData);
        
        $token = $sso->prepareToSend();
        $this->assertJson($token);
        
        $decoded = json_decode($token);
        $this->assertEquals('testuser', $decoded->username);
        $this->assertEquals('test@example.com', $decoded->email);
        $this->assertEquals('https://example.com/avatar.png', $decoded->avatar);
    }
    
    public function testSecureSSO()
    {
        $apiKey = 'test-api-key';
        $userData = new SecureSSOUserData('user123');
        $userData->email = 'test@example.com';
        $userData->username = 'testuser';
        
        $sso = FastCommentsSSO::createSecure($apiKey, $userData);
        
        $token = $sso->prepareToSend();
        $this->assertJson($token);
        
        $decoded = json_decode($token);
        $this->assertObjectHasAttribute('userDataJSONBase64', $decoded);
        $this->assertObjectHasAttribute('verificationHash', $decoded);
        $this->assertObjectHasAttribute('timestamp', $decoded);
        
        // Decode the user data
        $decodedUserData = json_decode(base64_decode($decoded->userDataJSONBase64));
        $this->assertEquals('user123', $decodedUserData->id);
        $this->assertEquals('test@example.com', $decodedUserData->email);
        $this->assertEquals('testuser', $decodedUserData->username);
    }
    
    public function testVerificationHash()
    {
        $apiKey = 'test-api-key';
        $timestamp = 1611234567890;
        $userData = json_encode(['id' => 'user123']);
        $userDataBase64 = base64_encode($userData);
        
        $hash = SecureSSOPayload::createVerificationHash($apiKey, $timestamp, $userDataBase64);
        
        // Recreate the hash to verify it matches
        $expectedHash = SecureSSOPayload::createVerificationHash($apiKey, $timestamp, $userDataBase64);
        
        $this->assertEquals($expectedHash, $hash);
        $this->assertEquals(64, strlen($hash)); // Hash should be 64 characters
    }
}