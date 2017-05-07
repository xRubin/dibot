<?php

namespace dibot\resources;

/**
 * Class GuildMember
 */
class GuildMember
{
    /** @var User user object */
    public $user;

    /** @var string this users guild nickname (if one is set) */
    public $nick;

    /** @var array array of role object id's */
    public $roles = [];

    /** @var string date the user joined the guild */
    public $joined_at;

    /** @var bool if the user is deafened */
    public $deaf;

    /** @var bool if the user is muted */
    public $mute;

}
