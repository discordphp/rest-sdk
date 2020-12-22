<?php

namespace DiscordPhp\REST;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use RuntimeException;

class Discord
{
    private static $instance;

    private ClientInterface $client;

    private array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public static function initialise(array $config): static
    {
        self::$instance = new static($config);

        return self::instance();
    }

    public static function instance(array $config = []): static
    {
        if (! isset(self::$instance)) {
            self::$instance = new static($config);
        }

        return self::$instance;
    }

    public function get(string $uri, array $options = [])
    {
        if (isset($options['query'])) {
            $uri .= (str_contains($uri, '?')
                    ? '&'
                    : '?'
                ) . (is_array($options['query'])
                    ? http_build_query($options['query'])
                    : $options['query']
                );
            unset($options['query']);
        }

        $response = $this->getClient()->request('get', ltrim($uri, '/'), $options);
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getClient(): ClientInterface
    {
        if (! isset($this->client)) {
            $this->buildClient();
        }

        return $this->client;
    }

    /**
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    public function buildClient(): ClientInterface
    {
        if ($this->config('token') === null) {
            throw new RuntimeException('No token provided for authorisation');
        }

        $this->setClient(new Client([
            'base_uri' => $this->config('base_uri', 'https://discord.com/api/v8/'),
            'headers'  => [
                'Authorization' => ($this->isBot() ? 'Bot ' : 'Bearer ') . $this->config('token'),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
        ]));

        return $this->getClient();
    }

    public function isBot()
    {
        return $this->config('bot', false);
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function config(string $key, mixed $default = null): mixed
    {
        if (! str_contains($key, '.')) {
            return $this->config[$key] ?? $default;
        }

        $config = $this->config;

        foreach (explode('.', $key) as $part) {
            if (isset($config[$part])) {
                $config = $config[$part];
                continue;
            }

            break;
        }

        return $config;
    }
}