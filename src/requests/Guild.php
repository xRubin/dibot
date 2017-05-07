<?php

namespace dibot\requests;

use dibot\interfaces\GuildInterface;
use dibot\interfaces\GuildMemberInterface;
use dibot\interfaces\ChannelInterface;
use dibot\interfaces\RoleInterface;
use dibot\interfaces\UserInterface;
use dibot\oauth2\Api;

class Guild
{

    /**
     * Create a new guild. Returns a guild object on success. Fires a Guild Create Gateway event.
     * @return GuildInterface
     */
    public static function create()
    {
        $result = Api::post(
            '/guilds',
            [
                /**
                 * name    string    name of the guild (2-100 characters)
                 * region    string    {voice_region.id} for voice
                 * icon    string    base64 128x128 jpeg image for the guild icon
                 * verification_level    integer    guild verification level
                 * default_message_notifications    integer    default message notifications setting
                 * roles    array of role objects    new guild roles
                 * channels    array of create guild channel body objects    new guild's channels
                 */
            ]
        );

        return GuildFactory::instatiate($result->getBody());
    }

    /**
     * Returns the new guild object for the given id.
     * @param string $guild_id
     * @return GuildInterface
     */
    public static function get($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id
        );

        return GuildFactory::instatiate($result->getBody());
    }

    /**
     * Modify a guild's settings. Returns the updated guild object on success. Fires a Guild Update Gateway event.
     * @param string $guild_id
     * @return GuildInterface
     */
    public function modify($guild_id)
    {
        $result = $this->patch(
            '/guilds/' . $guild_id,
            [
                /**
                 * name    string    guild name
                 * region    string    guild {voice_region.id}
                 * verification_level    integer    guild verification level
                 * default_message_notifications    integer    default message notifications setting
                 * afk_channel_id    snowflake    id for afk channel
                 * afk_timeout    integer    afk timeout in seconds
                 * icon    string    base64 128x128 jpeg image for the guild icon
                 * owner_id    snowflake    user id to transfer guild ownership to (must be owner)
                 * splash    string    base64 128x128 jpeg image for the guild splash (VIP only)
                 */
            ]
        );

        return GuildFactory::instatiate($result->getBody());
    }

    /**
     * Delete a guild permanently. User must be owner. Returns the guild object on success.
     * Fires a Guild Delete Gateway event.
     * @param string $guild_id
     * @return GuildInterface
     */
    public static function delete($guild_id)
    {
        $result = Api::delete(
            '/guilds/' . $guild_id
        );

        return GuildFactory::instatiate($result->getBody());
    }

    // ================================

    /**
     * Returns a list of guild channel objects.
     * @param string $guild_id
     * @return ChannelInterface[]
     */
    public static function getChannels($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/channels'
        );

        return array_map([ChannelFactory::class, 'instatiate'], $result->getBody());
    }

    /**
     * Create a new channel object for the guild. Requires the 'MANAGE_CHANNELS' permission.
     * Returns the new channel object on success. Fires a Channel Create Gateway event.
     * @param string $guild_id
     * @return ChannelInterface
     */
    public static function createChannel($guild_id)
    {
        $result = Api::post(
            '/guilds/' . $guild_id . '/channels',
            [
                /**
                 * name    string    channel name (2-100 characters)
                 * type    string    "voice" or "text"
                 * bitrate    integer    the bitrate (in bits) of the voice channel (voice only)
                 * user_limit    integer    the user limit of the voice channel (voice only)
                 * permission_overwrites    an array of overwrite objects    the channel's permission overwrites
                 */
            ]
        );

        return ChannelFactory::instatiate($result->getBody());
    }

    /**
     * Modify the positions of a set of channel objects for the guild. Requires 'MANAGE_CHANNELS' permission.
     * Returns a list of all of the guild's channel objects on success. Fires multiple Channel Update Gateway events.
     * @param string $guild_id
     * @return ChannelInterface[]
     */
    public function modifyChannelPositions($guild_id)
    {
        $result = $this->patch(
            '/guilds/' . $guild_id . '/channels',
            [
                /**
                 * This endpoint takes a JSON array of parameters in the following format:
                 * id    snowflake    channel id
                 * position    integer    sorting position of the channel
                 *                 */
            ]
        );

        return array_map([ChannnelFactory::class, 'instatiate'], $result->getBody());
    }

    // ======================================

    /**
     * Returns a guild member object for the specified user.
     * @param string $guild_id
     * @param string $user_id
     * @return GuildMemberInterface
     */
    public static function getMember($guild_id, $user_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/members/' . $user_id
        );

        return GuildMemberFactory::insttiate($result->getBody());
    }

    /**
     * Returns a list of guild member objects that are members of the guild.
     * @param string $guild_id
     * @return GuildMemberInterface[]
     */
    public static function listMembers($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/members',
            [
                /**
                 * All parameters to this endpoint are optional
                 * limit    integer    max number of members to return (1-1000)    1
                 * after    snowflake    the highest user id in the previous page    0
                 */
            ]
        );

        return array_map([GuildMemberFactory::class, 'instatiate'], $result->getBody());
    }

    /**
     * Adds a user to the guild, provided you have a valid oauth2 access token for the user with the guilds.join scope.
     * Returns a 201 Created with the guild member as the body. Fires a Guild Member Add Gateway event.
     * Requires the bot to have the CREATE_INSTANT_INVITE permission.
     * @param string $guild_id
     * @param string $user_id
     * @return GuildMemberInterface
     */
    public static function addMember($guild_id, $user_id)
    {
        $result = Api::put(
            '/guilds/' . $guild_id . '/members/' . $user_id,
            [
                /**
                 * All parameters to this endpoint except for access_token are optional.
                 * JSON Params
                 * Field    Type    Description    Permission
                 * access_token    string    an oauth2 access token granted with the guilds.join to the bot's application for the user you want to add to the guild
                 * nick    string    value to set users nickname to    MANAGE_NICKNAMES
                 * roles    array    array of roles the member is assigned    MANAGE_ROLES
                 * mute    bool    if the user is muted    MUTE_MEMBERS
                 * deaf    bool    if the user is deafened    DEAFEN_MEMBERS
                 */
            ]
        );

        return GuildMemberFactory::instatiate($result->getBody());
    }

    /**
     * Modify attributes of a guild member. Returns a 204 empty response on success.
     * Fires a Guild Member Update Gateway event.
     * @param string $guild_id
     * @param string $user_id
     * @return GuildMemberInterface
     */
    public static function modifyMember($guild_id, $user_id)
    {
        $result = Api::patch(
            '/guilds/' . $guild_id . '/members/' . $user_id,
            [
                /**
                 * All parameters to this endpoint are optional. When moving members to channels, the API user must have permissions to both connect to the channel and have the MOVE_MEMBERS permission.
                 * JSON Params
                 * Field    Type    Description    Permission
                 * nick    string    value to set users nickname to    MANAGE_NICKNAMES
                 * roles    array    array of role ids the member is assigned    MANAGE_ROLES
                 * mute    bool    if the user is muted    MUTE_MEMBERS
                 * deaf    bool    if the user is deafened    DEAFEN_MEMBERS
                 * channel_id    snowflake    id of channel to move user to (if they are connected to voice)    MOVE_MEMBERS
                 */
            ]
        );

        return GuildMemberFactory::instatiate($result->getBody());
    }

    /**
     * Remove a member from a guild. Requires 'KICK_MEMBERS' permission. Returns a 204 empty response on success.
     * Fires a Guild Member Remove Gateway event.
     * @param string $guild_id
     * @param string $user_id
     * @return bool
     */
    public static function removeMember($guild_id, $user_id)
    {
        $result = Api::delete(
            '/guilds/' . $guild_id . '/members/' . $user_id
        );

        return $result->getStatus() === 204;
    }

    // ========================

    /**
     * Modifies the nickname of the current user in a guild. Returns a 200 with the nickname on success.
     * Fires a Guild Member Update Gateway event.
     * @param string $guild_id
     * @return string
     */
    public static function modifyCurrentUserNick($guild_id)
    {
        $result = Api::patch(
            '/guilds/' . $guild_id . '/members/@me/nick',
            [
                /**
                 * nick    string    value to set users nickname to    CHANGE_NICKNAME
                 */
            ]
        );

        return $result->getBody();
    }

    // =======================

    /**
     * Adds a role to a guild member. Requires the 'MANAGE_ROLES' permission. Returns a 204 empty response on success.
     * Fires a Guild Member Update Gateway event.
     * @param string $guild_id
     * @param string $user_id
     * @param string $role_id
     * @return bool
     */
    public static function addMemberRole($guild_id, $user_id, $role_id)
    {
        $result = Api::put(
            '/guilds/' . $guild_id . '/members/' . $user_id . '/roles/' . $role_id
        );

        return $result->getStatus() === 204;
    }

    /**
     * Removes a role from a guild member. Requires the 'MANAGE_ROLES' permission.
     * Returns a 204 empty response on success. Fires a Guild Member Update Gateway event.
     * Fires a Guild Member Update Gateway event.
     * @param string $guild_id
     * @param string $user_id
     * @param string $role_id
     * @return bool
     */
    public static function removeMemberRole($guild_id, $user_id, $role_id)
    {
        $result = Api::delete(
            '/guilds/' . $guild_id . '/members/' . $user_id . '/roles/' . $role_id
        );

        return $result->getStatus() === 204;
    }

    // ==================

    /**
     * Returns a list of user objects that are banned from this guild. Requires the 'BAN_MEMBERS' permission.
     * @param string $guild_id
     * @return UserInterface[]
     */
    public static function getBans($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/bans'
        );

        return array_map([UserFactory::class, 'instatiate'], $result->getBody());
    }

    /**
     * Create a guild ban, and optionally delete previous messages sent by the banned user.
     * Requires the 'BAN_MEMBERS' permission. Returns a 204 empty response on success.
     * Fires a Guild Ban Add Gateway event.
     * @param string $guild_id
     * @param string $user_id
     * @return bool
     */
    public static function createBan($guild_id, $user_id)
    {
        $result = Api::put(
            '/guilds/' . $guild_id . '/bans/' . $user_id,
            [
                // delete-message-days	integer	number of days to delete messages for (0-7)
            ]
        );


        return $result->getStatus() === 204;
    }

    /**
     * Remove the ban for a user. Requires the 'BAN_MEMBERS' permissions. Returns a 204 empty response on success.
     * Fires a Guild Ban Remove Gateway event.
     * @param string $guild_id
     * @param string $user_id
     * @return bool
     */
    public static function removeBan($guild_id, $user_id)
    {
        $result = Api::delete(
            '/guilds/' . $guild_id . '/bans/' . $user_id
        );

        return $result->getStatus() === 204;
    }

    // =========================

    /**
     * Returns a list of role objects for the guild. Requires the 'MANAGE_ROLES' permission.
     * @param string $guild_id
     * @return RoleInterface[]
     */
    public static function getRoles($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/roles'
        );

        return array_map([RoleFactory::class, 'instatiate'], $result->getBody());
    }

    /**
     * Create a new role for the guild. Requires the 'MANAGE_ROLES' permission. Returns the new role object on success.
     * Fires a Guild Role Create Gateway event.
     * @param string $guild_id
     * @return bool
     */
    public static function createRole($guild_id)
    {
        $result = Api::post(
            '/guilds/' . $guild_id . '/roles',
            [
                /**
                 * All JSON params are optional.
                JSON Params
                Field	Type	Description	Default
                name	string	name of the role	"new role"
                permissions	integer	bitwise of the enabled/disabled permissions	@everyone permissions in guild
                color	integer	RGB color value	0
                hoist	bool	whether the role should be displayed separately in the sidebar	false
                mentionable	bool	whether the role should be mentionable	false
                 */
            ]
        );


        return RoleFactory::instatiate($result->getBody);
    }

    /**
     * Modify the positions of a set of role objects for the guild. Requires the 'MANAGE_ROLES' permission.
     * Returns a list of all of the guild's role objects on success. Fires multiple Guild Role Update Gateway events.
     * @param string $guild_id
     * @return RoleInterface[]
     */
    public static function modifyRolePositions($guild_id)
    {
        $result = Api::patch(
            '/guilds/' . $guild_id . '/roles',
            [
                /**
                 * This endpoint takes a JSON array of parameters in the following format:
                JSON Params
                Field	Type	Description
                id	snowflake	role
                position	integer	sorting position of the role
                 */
            ]
        );

        return array_map([RoleFactory::class, 'instatiate'], $result->getBody());
    }

    /**
     * Modify a guild role. Requires the 'MANAGE_ROLES' permission. Returns the updated role on success.
     * Fires a Guild Role Update Gateway event.
     * @param string $guild_id
     * @param string $role_id
     * @return RoleInterface[]
     */
    public static function modifyRole($guild_id, $role_id)
    {
        $result = Api::patch(
            '/guilds/' . $guild_id . '/roles/' . $role_id,
            [
                /**
                 * JSON Params
                Field	Type	Description
                name	string	name of the role
                permissions	integer	bitwise of the enabled/disabled permissions
                color	integer	RGB color value
                hoist	bool	whether the role should be displayed separately in the sidebar
                mentionable	bool	whether the role should be mentionable
                 */
            ]
        );

        return RoleFactory::instatiate($result->getBody());
    }

    /**
     * Delete a guild role. Requires the 'MANAGE_ROLES' permission. Returns a 204 empty response on success.
     * Fires a Guild Role Delete Gateway event.
     * @param string $guild_id
     * @param string $role_id
     * @return bool
     */
    public static function deleteRole($guild_id, $role_id)
    {
        $result = Api::delete(
            '/guilds/' . $guild_id . '/roles/' . $role_id
        );

        return $result->getStatus() === 204;
    }

    // ===============

    /**
     * Returns an object with one 'pruned' key indicating the number of members that would be removed
     * in a prune operation. Requires the 'KICK_MEMBERS' permission.
     * @param $guild_id
     * @return int
     */
    public static function getPruneCount($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/prune',
            [
                'days' => 30 //number of days to count prune for (1 or more)
            ]
        );

        return $result->getBodyKey('pruned');
    }

    /**
     * Begin a prune operation. Requires the 'KICK_MEMBERS' permission. Returns an object with one 'pruned'
     * key indicating the number of members that were removed in the prune operation.
     * Fires multiple Guild Member Remove Gateway events.
     * @param $guild_id
     * @return int
     */
    public static function beginPrune($guild_id)
    {
        $result = Api::post(
            '/guilds/' . $guild_id . '/prune',
            [
                'days' => 30 //number of days to count prune for (1 or more)
            ]
        );

        return $result->getBodyKey('pruned');
    }

    // ========================

    /**
     * Returns a list of voice region objects for the guild. Unlike the similar /voice route,
     * this returns VIP servers when the guild is VIP-enabled.
     * @param string $guild_id
     * @return VoiceRegionInterface[]
     */
    public static function getVoiceRegions($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/regions'
        );

        return array_map([VoiceRegionFactory::class, 'instatiate'], $result->getBody());
    }

    // =====================

    /**
     * Returns a list of invite objects (with invite metadata) for the guild. Requires the 'MANAGE_GUILD' permission.
     * @param string $guild_id
     * @return InviteInterface[]
     */
    public static function getInvited($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/invites'
        );

        return array_map([InviteFactory::class, 'instatiate'], $result->getBody());
    }

    // ==========================

    /**
     * Returns a list of integration objects for the guild. Requires the 'MANAGE_GUILD' permission.
     * @param string $guild_id
     * @return IntegrationInterface[]
     */
    public static function getIntegrations($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/integrations'
        );

        return array_map([IntegrationFactory::class, 'instatiate'], $result->getBody());
    }

    /**
     * Attach an integration object from the current user to the guild. Requires the 'MANAGE_GUILD' permission.
     * Returns a 204 empty response on success. Fires a Guild Integrations Update Gateway event.
     * @param string $guild_id
     * @return bool
     */
    public static function createIntegration($guild_id)
    {
        $result = Api::post(
            '/guilds/' . $guild_id . '/integrations',
            [
                /**
                 * type	string	the integration type
                id	snowflake	the integration id
                 */
            ]
        );

        return $result->getStatus() === 204;
    }

    /**
     * Modify the behavior and settings of a integration object for the guild. Requires the 'MANAGE_GUILD' permission.
     * Returns a 204 empty response on success. Fires a Guild Integrations Update Gateway event.
     * @param string $guild_id
     * @param string $integration_id
     * @return RoleInterface[]
     */
    public static function modifyIntegration($guild_id, $integration_id)
    {
        $result = Api::patch(
            '/guilds/' . $guild_id . '/integrations/' . $integration_id,
            [
                /**
                 * expire_behavior	integer	the behavior when an integration subscription lapses (see the integration object documentation)
                expire_grace_period	integer	period (in seconds) where the integration will ignore lapsed subscriptions
                enable_emoticons	bool	whether emoticons should be synced for this integration (twitch only currently)
                 */
            ]
        );

        return $result->getStatus() === 204;
    }

    /**
     * Delete the attached integration object for the guild. Requires the 'MANAGE_GUILD' permission.
     * Returns a 204 empty response on success. Fires a Guild Integrations Update Gateway event.
     * @param string $guild_id
     * @param string $integration_id
     * @return bool
     */
    public static function deleteIntegration($guild_id, $integration_id)
    {
        $result = Api::delete(
            '/guilds/' . $guild_id . '/integrations/' . $integration_id
        );

        return $result->getStatus() === 204;
    }

    /**
     * Sync an integration. Requires the 'MANAGE_GUILD' permission. Returns a 204 empty response on success.
     * @param string $guild_id
     * @param string $integration_id
     * @return bool
     */
    public static function syncIntegration($guild_id, $integration_id)
    {
        $result = Api::post(
            '/guilds/' . $guild_id . '/integrations/' . $integration_id . '/sync'
        );

        return $result->getStatus() === 204;
    }

    // =========================


    /**
     * Returns the guild embed object. Requires the 'MANAGE_GUILD' permission.
     * @param string $guild_id
     * @return GuildEmbedInterface
     */
    public static function getEmbed($guild_id)
    {
        $result = Api::get(
            '/guilds/' . $guild_id . '/embed'
        );

        return GuildEmbedFactory::insttiate($result->getBody());
    }

    /**
     * Modify a guild embed object for the guild. All attributes may be passed in with JSON and modified.
     * Requires the 'MANAGE_GUILD' permission. Returns the updated guild embed object.
     * @param string $guild_id
     * @return GuildEmbedInterface
     */
    public static function modifyEmbed($guild_id)
    {
        $result = Api::patch(
            '/guilds/' . $guild_id . '/embed'
        );

        return GuildEmbedFactory::insttiate($result->getBody());
    }

}