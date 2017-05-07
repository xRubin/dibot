<?php

namespace dibot\requests;

use dibot\interfaces\InviteInterface;
use dibot\oauth2\Api;

class Invite
{
    /**
     * Returns an invite object for the given code.
     * @param string $invite_code
     * @return InviteInterface
     */
    public static function get($invite_code)
    {
        $result = Api::get(
            '/invited/' . $invite_code
        );

        return InviteFactory::instatiate($result->getBody());
    }

    /**
     * Delete an invite. Requires the MANAGE_CHANNELS permission. Returns an invite object on success.
     * @param string $invite_code
     * @return InviteInterface
     */
    public static function delete($invite_code)
    {
        $result = Api::delete(
            '/invited/' . $invite_code
        );

        return InviteFactory::instatiate($result->getBody());
    }

    /**
     * Accept an invite. This is not available to bot accounts,
     * and requires the guilds.join OAuth2 scope to accept on behalf of normal users.
     * Returns an invite object on success.
     * @param string $invite_code
     * @return InviteInterface
     */
    public static function accept($invite_code)
    {
        $result = Api::post(
            '/invited/' . $invite_code
        );

        return InviteFactory::instatiate($result->getBody());
    }
}
