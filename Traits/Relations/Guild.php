<?php

namespace Apolune\Guilds\Traits\Relations;

trait Guild
{
    /**
     * Retrieve the guild owner.
     *
     * @return \Apolune\Contracts\Account\Player
     */
    public function owner()
    {
        return $this->belongsTo('player', 'ownerid');
    }

    /**
     * Retrieve the guild properties.
     *
     * @return \Apolune\Contracts\Guilds\GuildProperties
     */
    public function properties()
    {
        return $this->hasOne('guild.properties');
    }

    /**
     * Retrieve all of the guild ranks.
     *
     * @return \Illuminate\Support\Collection
     */
    public function ranks()
    {
        return $this->hasMany('guild.rank');
    }

    /**
     * Retrieve all of the guild members.
     *
     * @return \Illuminate\Support\Collection
     */
    public function players()
    {
        return $this->hasManyThrough('player', 'guild.member', 'guild_id', 'id');
    }

    /**
     * Retrieve all of the guild leaders.
     *
     * @return \Illuminate\Support\Collection
     */
    public function leaders()
    {
        return $this->players->filter(function ($member) {
            return $member->isGuildLeader();
        });
    }

    /**
     * Retrieve all of the guild vice-leaders.
     *
     * @return \Illuminate\Support\Collection
     */
    public function viceLeaders()
    {
        return $this->players->filter(function ($member) {
            return $member->isGuildViceLeader();
        });
    }

    /**
     * Retrieve all of the guild members.
     *
     * @return \Illuminate\Support\Collection
     */
    public function members()
    {
        return $this->players->filter(function ($member) {
            return ! $member->isGuildLeader() and ! $member->isGuildViceLeader();
        });
    }
}
