<?php

namespace App\Entity;

class Match
{
    public const INFO_MESSAGE_TYPE             = 'info';
    public const DANGEROUS_MOMENT_MESSAGE_TYPE = 'dangerousMoment';
    public const GOAL_MESSAGE_TYPE             = 'goal';
    public const YELLOW_CARD_MESSAGE_TYPE      = 'yellowCard';
    public const RED_CARD_MESSAGE_TYPE         = 'redCard';
    public const REPLACE_PLAYER_MESSAGE_TYPE   = 'replacePlayer';

    public const PLAYER_TYPE_GOALKEEPER  = 'В';
    public const PLAYER_TYPE_DEFENDER  = 'З';
    public const PLAYER_TYPE_HALF_DEFENDER  = 'П';
    public const PLAYER_TYPE_ATTACK  = 'Н';

    private const MESSAGE_TYPES = [
        self::INFO_MESSAGE_TYPE,
        self::DANGEROUS_MOMENT_MESSAGE_TYPE,
        self::GOAL_MESSAGE_TYPE,
        self::YELLOW_CARD_MESSAGE_TYPE,
        self::RED_CARD_MESSAGE_TYPE,
        self::REPLACE_PLAYER_MESSAGE_TYPE,
    ];

    private $id;
    private $date;
    private $tournament;
    private $stadium;
    private $homeTeam;
    private $awayTeam;
    private $messages;

    public function __construct(string $id, \DateTime $date, string $tournament, Stadium $stadium, Team $homeTeam, Team $awayTeam)
    {
        $this->id = $id;
        $this->date = $date;
        $this->tournament = $tournament;
        $this->stadium = $stadium;
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->messages = [];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getTournament(): string
    {
        return $this->tournament;
    }

    public function getStadium(): Stadium
    {
        return $this->stadium;
    }

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function addMessage(string $minute, string $text, string $type, array $details): void
    {
        $this->assertCorrectType($type);

        $this->messages[] = [
            'minute' => $minute,
            'text'   => $text,
            'type'   => $type,
            'details' => $details
        ];
    }

    private function assertCorrectType(string $type): void
    {
        if (!in_array($type, self::MESSAGE_TYPES, true)) {
            throw new \Exception(
                sprintf(
                    'Message type "%s" not supported. Available types: "%s".',
                    $type,
                    implode('", "', self::MESSAGE_TYPES)
                )
            );
        }
    }
}