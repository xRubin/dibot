<?php

namespace dibot\resources;

use dibot\resources\user\User;

/**
 * Class Integration
 */
class Integration
{
    /** @var string integration id */
    public $id;

    /** @var string integration name */
    public $name;

    /** @var string integration type (twitch, youtube, etc) */
    public $type;

    /** @var bool is this integration enabled */
    public $enabled;

    /** @var bool is this integration syncing */
    public $syncing;

    /** @var string id that this integration uses for "subscribers" */
    public $role_id;

    /** @var integer the behavior of expiring subscribers */
    public $expire_behavior;

    /** @var integer the grace period before expiring subscribers */
    public $expire_grace_period;

    /** @var User user for this integration */
    public $user;

    /** @var IntegrationAccount integration account information */
    public $account;

    /** @var integer when this integration was last synced */
    public $synced_at;

}
