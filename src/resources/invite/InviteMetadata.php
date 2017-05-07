<?php

namespace dibot\resources\invite;

use dibot\interfaces\UserInterface;

/**
 * Class InviteMetadata
 */
class InviteMetadata
{
    /** @var string the invite code (unique ID) */
    public $code;

    /** @var InviteGuild the guild this invite is for */
    public $guild;

    /** @var InviteChannel the channel this invite is for */
    public $channel;

    /** @var UserInterface a user object user who created the invite */
    public $inviter;

    /** @var integer number of times this invite has been used */
    public $uses;

    /** @var integer max number of times this invite can be used */
    public $max_uses;

    /** @var integer duration (in seconds) after which the invite expires */
    public $max_age;

    /** @var bool whether this invite only grants temporary membership */
    public $temporary;

    /** @var string when this invite was created */
    public $created_at;

    /** @var bool whether this invite is revoked */
    public $revoked;
    
}
