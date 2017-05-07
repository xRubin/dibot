<?php

namespace dibot\resources;

use dibot\oauth2\GuildInterface;

/**
 * Class Guild
 * Guilds in Discord represent a collection of users and channels into an isolated "server".
 */
class Guild implements GuildInterface
{
    /** @var string guild id */
    public $id;

    /** @var string guild name */
    public $name;

    /** @var string icon hash */
    public $icon;

    /** @var string splash hash */
    public $splash;

    /** @var string id of owner */
    public $owner_id;

    /** @var string {voice_region.id} */
    public $region;

    /** @var string id of afk channel */
    public $afk_channel_id;

    /** @var integer afk timeout in seconds */
    public $afk_timeout;

    /** @var bool is this guild embeddable (e.g. widget) */
    public $embed_enabled;

    /** @var string id of embedded channel */
    public $embed_channel_id;

    /** @var integer level of verification */
    public $verification_level;

    /** @var integer default message notifications level */
    public $default_message_notifications;

    /** @var array array of role objects */
    public $roles = [];

    /** @var array array of emoji objects */
    public $emojis = [];

    /** @var array array of guild features */
    public $features = [];

    /** @var integer required MFA level for the guild */
    public $mfa_level;

    /**
     * * These fields are only sent within the GUILD_CREATE event
     *
     * joined_at *    datetime    date this guild was joined at
     * large *    bool    whether this is considered a large guild
     * unavailable *    bool    is this guild unavailable
     * member_count *    integer    total number of members in this guild
     * voice_states *    array    array of voice state objects (without the guild_id key)
     * members *    array    array of guild member objects
     * channels *    array    array of channel objects
     * presences *    array    array of simple presence objects, which share the same fields as Presence Update event sans a roles or guild_id key
     */
}
