<?php

namespace dibot\resources\user;

use dibot\interfaces\ConnectionInterface;

/**
 * Class Connection
 * The connection object that the user has attached.
 */
class Connection implements ConnectionInterface
{
    /** @var string id of the connection account */
    public $id;

    /** @var string the username of the connection account */
    public $name;

    /** @var string the service of the connection (twitch, youtube) */
    public $type;

    /** @var bool whether the connection is revoked */
    public $revoked;

    /** @var array an array of partial server integrations */
    public $integrations = [];
}
