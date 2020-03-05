<?php
namespace App\Entity;

class Stadium
{
    private $country;
    private $city;
    private $name;

    public function __construct(string $country, string $city, string $name)
    {
        $this->country = $country;
        $this->city = $city;
        $this->name = $name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getName(): string
    {
        return $this->name;
    }
}