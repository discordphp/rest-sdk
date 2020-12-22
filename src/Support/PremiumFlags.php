<?php

namespace DiscordPhp\REST\Support;

final class PremiumFlags
{
    public const NITRO_CLASSIC = 1;
    public const NITRO         = 2;

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