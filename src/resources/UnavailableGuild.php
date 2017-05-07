<?php

namespace dibot\resources;

use dibot\oauth2\GuildInterface;

/**
 * Class UnavailableGuild
 * Represents an Offline Guild, or a Guild whose information has not been provided through Guild Create events
 * during the Gateway connect.
 */
class UnavailableGuild implements GuildInterface
{
    /** @var string guild id */
    public $id;

    /** @var bool should always be true */
    public $unavailable = true;
}
