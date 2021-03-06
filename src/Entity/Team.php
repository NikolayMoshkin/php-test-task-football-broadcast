<?php

namespace App\Entity;

use Core\Main;

class Team
{
    private $name;
    private $country;
    private $logo;
    /**
     * @var Player[]
     */
    private $players;
    private $coach;
    private $goals;

    public function __construct(string $name, string $country, string $logo, array $players, string $coach)
    {
        $this->assertCorrectPlayers($players);

        $this->name = $name;
        $this->country = $country;
        $this->logo = $logo;
        $this->players = $players;
        $this->coach = $coach;
        $this->goals = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return Player[]
     */
    public function getPlayersOnField(): array
    {
        return array_filter($this->players, function (Player $player) {
            return $player->isPlay();
        });
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayer(int $number): Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception(
            sprintf(
                'Player with number "%d" not play in team "%s".',
                $number,
                $this->name
            )
        );
    }

    public function getCoach(): string
    {
        return $this->coach;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }


    private function assertCorrectPlayers(array $players)
    {
        foreach ($players as $player) {
            if (!($player instanceof Player)) {
                throw new \Exception(
                    sprintf(
                        'Player should be instance of "%s". "%s" given.',
                        Player::class,
                        get_class($player)
                    )
                );
            }
        }
    }

    public function getStat()
    {
        $stat = [];
        foreach ($this->players as $player) {
            if (Match::PLAYER_TYPE_GOALKEEPER === $player->getPosition())
                $stat['goalkeeper'] += $player->getPlayTime();
            if (Match::PLAYER_TYPE_DEFENDER === $player->getPosition())
                $stat['defender'] += $player->getPlayTime();
            if (Match::PLAYER_TYPE_HALF_DEFENDER === $player->getPosition())
                $stat['halfDefender'] += $player->getPlayTime();
            if (Match::PLAYER_TYPE_ATTACK === $player->getPosition())
                $stat['attack'] += $player->getPlayTime();
        }
        return $stat;
    }
}