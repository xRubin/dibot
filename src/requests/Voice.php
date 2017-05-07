<?php
namespace dibot\requests;

use dibot\oauth2\Api;

class Voice
{
    /**
     * Returns an array of voice region objects that can be used when creating servers.
     * @return VoiceRegionInterface
     */
    public static function listRegions()
    {
        $result = Api::get(
            '/voice/regions'
        );

        return array_map([VoiceRegionFactory::class, 'instatiate'], $result->getBody());
    }
    
}