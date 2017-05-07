<?php

namespace dibot\interfaces;

interface GuildInterface
{
    /**
     * @return UserInterface
     */
    public function getOwner();
}