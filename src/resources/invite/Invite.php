<?php

namespace dibot\resources\invite;

/**
 * Class Invite
 * Represents a code that when used, adds a user to a guild.
 */
class Invite
{
    /** @var string the invite code (unique ID) */
    public $code;

    /** @var InviteGuild the guild this invite is for */
    public $guild;

    /** @var InviteChannel the channel this invite is for */
    public $channel;
}
