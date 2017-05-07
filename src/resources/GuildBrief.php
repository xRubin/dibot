<?php

namespace dibot\resources;

/**
 * Class GuildBrief
 * A brief version of a Guild object
 */
class GuildBrief
{
    /** @var string guild.id */
    public $id;

    /** @var string guild.name */
    public $name;

    /** @var string guild.icon */
    public $icon;

    /** @var bool true if the user is an owner of the guild */
    public $owner;

    /** @var integer    bitwise of the user's enabled/disabled permissions */
    public $permissions;

}
