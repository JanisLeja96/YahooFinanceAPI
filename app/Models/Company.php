<?php

namespace App\Models;

use Carbon\Carbon;

class Company
{
    private string $name;
    private string $symbol;
    private float $price;
    private string $currency;
    private float $previousClose;
    private float $open;
    private string $bid;
    private string $ask;
    private string $daysRange;
    private string $yearRange;
    private int $volume;
    private int $averageVolume;
    private int $marketCap;
    private ?string $lastUpdated;

    public function __construct(
        string $name,
        string $symbol,
        float $price,
        string $currency,
        float $previousClose,
        float $open,
        string $bid,
        string $ask,
        string $daysRange,
        string $yearRange,
        int $volume,
        int $averageVolume,
        int $marketCap,
        string $lastUpdated = null
    )
    {
        $this->name = $name;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->currency = $currency;
        $this->previousClose = $previousClose;
        $this->open = $open;
        $this->bid = $bid;
        $this->ask = $ask;
        $this->daysRange = $daysRange;
        $this->yearRange = $yearRange;
        $this->volume = $volume;
        $this->averageVolume = $averageVolume;
        $this->marketCap = $marketCap;
        $this->lastUpdated = $lastUpdated;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPreviousClose(): float
    {
        return $this->previousClose;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function getBid(): string
    {
        return $this->bid;
    }

    public function getAsk(): string
    {
        return $this->ask;
    }

    public function getDaysRange(): string
    {
        return $this->daysRange;
    }

    public function getYearRange(): string
    {
        return $this->yearRange;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }

    public function getAverageVolume(): int
    {
        return $this->averageVolume;
    }

    public function getMarketCap(): int
    {
        return $this->marketCap;
    }

    public function getFormattedVolume(): string
    {
        return number_format($this->volume, '0', '.', ',');
    }

    public function getFormattedAverageVolume(): string
    {
        return number_format($this->averageVolume, '0', '.', ',');
    }

    public function getFormattedMarketCap(): string
    {
        return number_format($this->marketCap, '0', '.', ',');
    }

    public function getLastUpdated(): string
    {
        return $this->lastUpdated;
    }

}