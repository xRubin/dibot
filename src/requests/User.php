<?php
namespace dibot\requests;

use dibot\interfaces\ConnectionInterface;
use dibot\interfaces\UserInterface;
use dibot\oauth2\Api;

class User
{
    /**
     * Returns the user object of the requester's account. For OAuth2, this requires the identify scope,
     * which will return the object without an email, and optionally the email scope,
     * which returns the object with an email.
     * @return UserInterface
     */
    public static function getCurrent()
    {
        $result = Api::get(
            '/users/@me'
        );

        return UserFactory::instatiate($result->getBody());
    }

    /**
     * Modify the requester's user account settings. Returns a user object on success.
     * @return UserInterface
     */
    public static function modifyCurrent()
    {
        $result = Api::patch(
            '/users/@me',
            [
                /**
                 * username	string	users username, if changed may cause the users discriminator to be randomized.
                avatar	avatar data	if passed, modifies the user's avatar
                 */
            ]
        );

        return UserFactory::instatiate($result->getBody());
    }

    // =======================

    /**
     * Returns a list of user guild objects the current user is a member of. Requires the guilds OAuth2 scope.
     * @return UserGuildInterface
     */
    public static function getCurrentGuilds()
    {
        $result = Api::get(
            '/users/@me/guilds',
            [
                /**
                 * This endpoint returns 100 guilds by default, which is the maximum number of guilds a non-bot user can join. Therefore, pagination is not needed for integrations that need to get a list of users' guilds.
                Query String Params
                Field	Type	Description	Required	Default
                before	snowflake	get guilds before this guild ID	false	absent
                after	snowflake	get guilds after this guild ID	false	absent
                limit	integer	max number of guilds to return (1-100)	false	100
                 */
            ]
        );

        return array_map([UserGuildFactory::class, 'instatiate'], $result->getBody());
    }

    /**
     * Leave a guild. Returns a 204 empty response on success.
     * @param string $guild_id
     * @return bool
     */
    public static function leaveGuild($guild_id)
    {
        $result = Api::delete(
            '/users/@me/guilds/' . $guild_id
        );

        return $result->getStatus() === 204;
    }

    // =========================

    /**
     * Returns a list of DM channel objects.
     * @return DMChannelInterface[]
     */
    public static function getDMs()
    {
        $result = Api::get(
            '/users/@me/channels'
        );

        return array_map([DMChannelFactory::class, 'instatiate'], $result->getBody());
    }

    /**
     * Create a new DM channel with a user. Returns a DM channel object.
     * @return DMChannelInterface
     */
    public static function createDM()
    {
        $result = Api::post(
            '/users/@me/channels',
            [
                /**
                 * recipient_id	snowflake	the recipient to open a DM channel with
                 */
            ]
        );

        return DMChannelFactory::instatiate($result->getBody());
    }

    /**
     * Create a new group DM channel with multiple users. Returns a DM channel object.
     * @return DMChannelInterface
     */
    public static function createGroupDM()
    {
        $result = Api::post(
            '/users/@me/channels',
            [
                /**
                 * access_tokens	array of strings	access tokens of users that have granted your app the gdm.join scope
                nicks	dict	a dictionary of user ids to their respective nicknames
                 */
            ]
        );

        return DMChannelFactory::instatiate($result->getBody());
    }

    // =======================

    /**
     * Returns a list of connection objects. Requires the connections OAuth2 scope.
     * @return ConnectionInterface[]
     */
    public static function getConnections()
    {
        $result = Api::get(
            '/users/@me/connections'
        );

        return array_map([ConnectionFactory::class, 'instatiate'], $result->getBody());
    }

    // =======================

    /**
     * Returns a user for a given user ID.
     * @param string $user_id
     * @return UserInterface
     */
    public static function get($user_id)
    {
        $result = Api::get(
            '/users/' . $user_id
        );

        return UserFactory::instatiate($result->getBody());
    }

}