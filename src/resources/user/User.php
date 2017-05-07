<?php

namespace dibot\resources\user;

/**
 * Class User
 * Users in Discord are generally considered the base entity. Users can spawn across the entire platform,
 * be members of guilds, participate in text and voice chat, and much more. Users are separated by a distinction
 * of "bot" vs "normal." Although they are similar, bot users are automated users that are "owned" by another user.
 * Unlike normal users, bot users do not have a limitation on the number of Guilds they can be a part of.
 */
class User
{
    /** @var string the user's id */
    public $id;

    /** @var string the user's username, not unique across the platform */
    public $username;

    /** @var string the user's username, not unique across the platform */
    public $discriminator;

    /** @var string the user's avatar hash */
    public $avatar;

    /** @var bool whether the user belongs to an OAuth2 application */
    public $bot;

    /** @var bool whether the user has two factor enabled on their account */
    public $mfa_enabled;

    /** @var bool whether the email on this account has been verified */
    public $verified;

    /** @var string the user's email */
    public $email;

}
