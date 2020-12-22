<?php

namespace DiscordPhp\REST\Support;

use Stringable;

final class UserFlags
{
    public const DISCORD_EMPLOYEE             = 0;
    public const PARTNERED_SERVER_OWNER       = 1;
    public const HYPESQUAD_EVENTS             = 2;
    public const BUG_HUNTER_LEVEL1            = 3;
    public const HOUSE_BRAVERY                = 6;
    public const HOUSE_BRILLIANCE             = 7;
    public const HOUSE_BALANCE                = 8;
    public const EARLY_SUPPORTER              = 9;
    public const TEAM_USER                    = 10;
    public const SYSTEM                       = 12;
    public const BUG_HUNTER_LEVEL2            = 14;
    public const VERIFIED_BOT                 = 16;
    public const EARLY_VERIFIED_BOT_DEVELOPER = 17;

    private int $flags;

    public function __construct(?int $flags = null)
    {
        $this->flags = $flags ?? 0;
    }

    public function is(int $flag): int
    {
        return $this->flags << $flag;
    }

    public function toBase(): int
    {
        return $this->flags;
    }
}