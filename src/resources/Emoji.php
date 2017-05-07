<?php

namespace dibot\resources;

/**
 * Class Emoji
 */
class Emoji
{
    /** @var string emoji id */
    public $id;

    /** @var string emoji name */
    public $name;

    /** @var array roles this emoji is active for */
    public $roles = [];

    /** @var bool whether this emoji must be wrapped in colons */
    public $require_colons;

    /** @var bool whether this emoji is managed  */
    public $managed;

}
