<?php

namespace dibot\resources\invite;

use dibot\interfaces\ChannelInterface;

/**
 * Class InviteChannel
 */
class InviteChannel implements ChannelInterface
{
    /** @var string id of the channel */
    public $id;

    /** @var string name of the channel */
    public $name;

    /** @var string 'text' or 'voice' */
    public $type;

}
