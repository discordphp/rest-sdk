<?php

namespace DiscordPhp\REST\Support;

use JetBrains\PhpStorm\Pure;

final class Snowflake
{
    protected string $id;

    protected int $timestamp;

    protected int $workerId;

    protected int $processId;

    protected int $increment;

    public function __construct(string $id)
    {
        $this->id        = $id;
        $this->timestamp = ($this->id >> 22) + 1420070400000;
        $this->workerId  = ($this->id & 0x3E0000) >> 17;
        $this->processId = ($this->id & 0x1F000) >> 12;
        $this->increment = $this->id & 0xFFF;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return int
     */
    public function getWorkerId(): int
    {
        return $this->workerId;
    }

    /**
     * @return int
     */
    public function getProcessId(): int
    {
        return $this->processId;
    }

    /**
     * @return int
     */
    public function getIncrement(): int
    {
        return $this->increment;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getId();
    }
}