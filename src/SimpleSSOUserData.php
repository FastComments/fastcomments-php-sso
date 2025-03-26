<?php

namespace FastComments\SSO;

/**
 * An object that represents a user, for SimpleSSO.
 */
class SimpleSSOUserData
{
    /**
     * This must be unique when paired with an email.
     * @var string
     */
    public string $username;

    /**
     * The user's email.
     * @var string|null
     */
    public ?string $email = null;

    /**
     * The user's avatar.
     * @var string|null
     */
    public ?string $avatar = null;

    /**
     * The user's website, blog, or personal account page.
     * @var string|null
     */
    public ?string $websiteUrl = null;

    /**
     * Constructor with username.
     *
     * @param string $username The username
     */
    public function __construct(string $username = null)
    {
        if ($username !== null) {
            $this->username = $username;
        }
    }

    /**
     * Create with username, email, and avatar.
     *
     * @param string $username The username
     * @param string|null $email The email
     * @param string|null $avatar The avatar URL
     * @return SimpleSSOUserData
     */
    public static function create(string $username, ?string $email = null, ?string $avatar = null): SimpleSSOUserData
    {
        $userData = new self($username);
        $userData->email = $email;
        $userData->avatar = $avatar;
        return $userData;
    }
}