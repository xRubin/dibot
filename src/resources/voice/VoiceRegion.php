<?php

namespace dibot\resources\voice;

/**
 * Class VoiceRegion
 */
class VoiceRegion
{
    /** @var string unique ID for the region */
    public $id;

    /** @var string name of the region */
    public $name;

    /** @var string an example hostname for the region */
    public $sample_hostname;

    /** @var integer an example port for the region */
    public $sample_port;

    /** @var bool true if this is a vip-only server */
    public $vip;

    /** @var bool true for a single server that is closest to the current user's client */
    public $optimal;

    /** @var bool whether this is a deprecated voice region (avoid switching to these) */
    public $deprecated;

    /** @var bool whether this is a custom voice region (used for events/etc) */
    public $custom;
}
