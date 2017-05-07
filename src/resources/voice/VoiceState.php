<?php

namespace dibot\resources\voice;

/**
 * Class VoiceState
 * Used to represent a user's voice connection status.
 */
class VoiceState
{
    /** @var string the guild id this voice state is for */
    public $guild_id;

    /** @var string the channel id this user is connected to */
    public $channel_id;

    /** @var string the user id this voice state is for */
    public $user_id;

    /** @var string the session id for this voice state */
    public $session_id;

    /** @var bool whether this user is deafened by the server */
    public $deaf;

    /** @var bool whether this user is muted by the server */
    public $mute;

    /** @var bool whether this user is locally deafened */
    public $self_deaf;

    /** @var bool whether this user is locally muted */
    public $self_mute;

    /** @var bool whether this user is muted by the current user */
    public $suppress;

}
