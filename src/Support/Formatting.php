<?php

namespace DiscordPhp\REST\Support;

use DiscordPhp\REST\Entities\Channel;
use DiscordPhp\REST\Entities\Emoji;
use DiscordPhp\REST\Entities\Role;
use DiscordPhp\REST\Entities\User;
use JetBrains\PhpStorm\Pure;

final class Formatting
{
    #[Pure]
    public static function username(User|Snowflake|string $id): string
    {
        return self::user($id);
    }

    public static function user(User|Snowflake|string $id, bool $nickname = false): string
    {
        return '<@' . ($nickname ? '!' : '') . ($id instanceof User ? $id->id : $id) . '>';
    }

    #[Pure]
    public static function nickname(User|Snowflake|string $id): string
    {
        return self::user($id, true);
    }

    public static function channel(Channel|Snowflake|string $id): string
    {
        return '<#' . ($id instanceof Channel ? $id->id : $id) . '>';
    }

    public static function role(Role|Snowflake|string $id): string
    {
        return '<@&' . ($id instanceof Role ? $id->id : $id)  . '>';
    }

    public static function emoji(Emoji $emoji, ?string $name = null, Snowflake|string|null $id = null, bool $animated = false)
    {
        return
            '<'
            . ($animated ? 'a' : '')
            . ':'
            . ($name ?? $emoji->name)
            . ':'
            . ($id ?? $emoji->id)
            . '>';
    }
}