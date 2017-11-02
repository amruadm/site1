<?php

namespace AppBundle\Service\Minecraft;

use MinecraftServerStatus\MinecraftServerStatus;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Validator\Constraints\DateTime;


class ServersManager
{
    private $lastRequest;
    private $servers;

    /**
     * @var int interval in minutes
     */
    private $update_interval;

    private $cache;

    public function __construct(FilesystemCache $cache)
    {
        $this->update_interval = 2;
        $this->cache = $cache;

        if($this->cache->has('servers.manager.lastRequest'))
            $this->lastRequest = $this->cache->get("servers.manager.lastRequest");
        else
            $this->lastRequest = null;

        //setting up defaults
        $this->servers = [
            'Classic' => [
                'Players' => 0,
                'MaxPlayers' => 0,
                'IP' => '127.0.0.1',
                'Port' => 25577,
                'Online' => false,
                'Info' => 'server-classic'
            ],
            'Mini-Games' => [
                'Players' => 0,
                'MaxPlayers' => 0,
                'Online' => false,
                'Info' => 'server-mini-games',
                'servers' => [
                    'HUB' => [
                        'Players' => 0,
                        'MaxPlayers' => 0,
                        'IP' => '127.0.0.1',
                        'Port' => 25560
                    ],
                    'HideNSeek' => [
                        'Players' => 0,
                        'MaxPlayers' => 0,
                        'IP' => '127.0.0.1',
                        'Port' => 25559
                    ],
                    'Survival' => [
                        'Players' => 0,
                        'MaxPlayers' => 0,
                        'IP' => '127.0.0.1',
                        'Port' => 25558
                    ]
                ]
            ]
        ];
        if(empty($this->lastRequest))
            $this->update();
    }

    private function update()
    {
        $this->lastRequest = new \DateTime();
        $this->cache->set('servers.manager.lastRequest', $this->lastRequest);

        foreach($this->servers as &$server)
        {
            $server['Players'] = 0;
            $server['MaxPlayers'] = 0;
            $server['Online'] = false;
            if(isset($server['servers']))
            {
                foreach($server['servers'] as $subserver)
                {
                    $result = MinecraftServerStatus::query($subserver['IP'], $subserver['Port']);
                    if($result !== FALSE){
                        $server['Online'] = true;
                        $server['Players'] += $result['players'];
                        $server['MaxPlayers'] += $result['max_players'];
                    }
                }
            }
            else
            {
                $result = MinecraftServerStatus::query($server['IP'], $server['Port']);
                if($result !== FALSE){
                    $server['Online'] = true;
                    $server['Players'] = $result['players'];
                    $server['MaxPlayers'] = $result['max_players'];
                }
            }
            $this->cache->set('servers.manager.servers', $this->servers);
        }

    }

    /**
     * @return array
     */
    public function getServers()
    {
        $now = new \DateTime();

        if($now->diff($this->lastRequest)->i >= $this->update_interval)
        {
            $this->update();
        }
        $this->servers = $this->cache->get('servers.manager.servers');

        $result = [];

        foreach($this->servers as $server_name => $server)
        {
            $result[] = [
                'name' => $server_name,
                'players' => $server['Players'],
                'max_players' => $server['MaxPlayers'],
                'online' => $server['Online'],
                'info' => $server['Info']
            ];
        }

        return $result;
    }

}