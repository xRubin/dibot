<?php

namespace dibot\resources\invite;

use dibot\interfaces\GuildInterface;

/**
 * Class InviteGuild
 */
class InviteGuild implements GuildInterface
{
    /** @var string guild id */
    public $id;

    /** @var string guild name */
    public $name;

    /** @var string icon hash */
    public $icon;

    /** @var string splash hash */
    public $splash;
    
}
