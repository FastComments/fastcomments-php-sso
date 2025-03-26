<?php

namespace FastComments\SSO;

/**
 * Represents a secure SSO payload for FastComments.
 */
class SecureSSOPayload
{
    /**
     * The user's data (SecureSSOUserData) represented as JSON, then Base64'd.
     * Leave empty for an unauthenticated user.
     * @var string
     */
    public string $userDataJSONBase64;

    /**
     * The HMAC-SHA256 hash of the userDataJSONBase64 field, using your secret key.
     * @var string
     */
    public string $verificationHash;

    /**
     * The timestamp of when the verificationHash was created.
     * @var int
     */
    public int $timestamp;

    /**
     * Constructor to initialize a SecureSSOPayload.
     *
     * @param string $userDataJSONBase64 Base64 encoded user data JSON
     * @param string $verificationHash Verification hash
     * @param int $timestamp Timestamp when hash was created
     */
    public function __construct(string $userDataJSONBase64, string $verificationHash, int $timestamp)
    {
        $this->userDataJSONBase64 = $userDataJSONBase64;
        $this->verificationHash = $verificationHash;
        $this->timestamp = $timestamp;
    }

    /**
     * Creates a verification hash for secure SSO.
     *
     * @param string $apiKey Your FastComments API key
     * @param int $timestamp Current timestamp
     * @param string $userDataJSONBase64 Base64 encoded user data JSON
     * @return string The HMAC-SHA256 hash
     */
    public static function createVerificationHash(string $apiKey, int $timestamp, string $userDataJSONBase64): string
    {
        $data = $timestamp . $userDataJSONBase64;
        $hash = hash_hmac('sha256', $data, $apiKey, true);
        return self::getBytesAsHex($hash);
    }

    /**
     * Converts binary data to a hexadecimal string.
     *
     * @param string $bytes Binary data
     * @return string Hexadecimal representation
     */
    private static function getBytesAsHex(string $bytes): string
    {
        $hex = bin2hex($bytes);
        // Ensure the string is exactly 64 characters long, padding with leading zeros if necessary
        return str_pad($hex, 64, '0', STR_PAD_LEFT);
    }
}