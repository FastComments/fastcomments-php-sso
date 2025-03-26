<?php

namespace FastComments\SSO;

/**
 * An object that represents a user, for SecureSSO.
 */
class SecureSSOUserData
{
    /**
     * Required. 1k Characters Max.
     * @var string
     */
    public string $id;

    /**
     * Required. 1k Characters Max. Must be unique.
     * @var string
     */
    public string $email;

    /**
     * Required. 1k Characters Max. Note: The username cannot be an email.
     * @var string
     */
    public string $username;

    /**
     * Optional. 3k Characters Max for URLs. Default is from gravatar based on email.
     * @var string|null
     */
    public ?string $avatar = null;

    /**
     * Optional. Default false.
     * @var bool|null
     */
    public ?bool $optedInNotifications = null;

    /**
     * Optional. 100 Characters Max.
     * @var string|null
     */
    public ?string $displayLabel = null;

    /**
     * Optional. 500 Characters Max.
     * @var string|null
     */
    public ?string $displayName = null;

    /**
     * Optional. 2k Characters Max.
     * @var string|null
     */
    public ?string $websiteUrl = null;

    /**
     * Optional. Up to 100 groups per user.
     * @var array|null
     */
    public ?array $groupIds = null;

    /**
     * Optional. Denotes the user as an administrator.
     * @var bool|null
     */
    public ?bool $isAdmin = null;

    /**
     * Optional. Denotes the user as a moderator.
     * @var bool|null
     */
    public ?bool $isModerator = null;

    /**
     * Optional, default true.
     * @var bool|null
     */
    public ?bool $isProfileActivityPrivate = null;

    /**
     * Constructor with required ID.
     *
     * @param string $id The user ID
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Create with ID, email, username, and avatar.
     *
     * @param string $id The user ID
     * @param string $email The email
     * @param string $username The username
     * @param string|null $avatar The avatar URL
     * @return SecureSSOUserData
     */
    public static function create(string $id, string $email, string $username, ?string $avatar = null): SecureSSOUserData
    {
        $userData = new self($id);
        $userData->email = $email;
        $userData->username = $username;
        $userData->avatar = $avatar;
        return $userData;
    }
}