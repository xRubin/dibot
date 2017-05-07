<?php

namespace dibot\structures\response;

use dibot\resources\User;

class Application
{
    /** @var string the id of the app */
    public $id;

    /** @var string the name of the app */
    public $name;

    /** @var string the icon hash of the app */
    public $icon;

    /** @var string the description of the app */
    public $description;

    /** @var array an array of rpc origin url strings, if rpc is enabled */
    public $rpc_origins = [];

    /** @var bool when false only app owner can join the app's bot to guilds */
    public $bot_public;

    /** @var bool when true the app's bot will only join upon completion of the full oauth2 code grant flow */
    public $bot_require_code_grant;

    /** @var User partial user object containing info on the owner of the application */
    public $owner;
}