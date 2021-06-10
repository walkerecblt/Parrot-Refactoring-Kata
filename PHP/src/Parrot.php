<?php

declare(strict_types=1);

namespace Parrot;

use Exception;

class Parrot
{
    /** @var int ParrotTypeEnum */
    private $type;

    /** @var int */
    private $numberOfCoconuts;

    /**
     * @var float
     */
    private $voltage;

    /**
     * @var bool
     */
    private $isNailed;

    /** @var SpeedStrategy */
    private $speedStrategy;

    public function __construct(int $type, int $numberOfCoconuts, float $voltage, bool $isNailed)
    {
        $this->type = $type;
        $this->numberOfCoconuts = $numberOfCoconuts;
        $this->voltage = $voltage;
        $this->isNailed = $isNailed;
        $this->setStrategy($type);
    }

    public function getSpeed(): float
    {
        switch ($this->type) {
            case ParrotTypeEnum::EUROPEAN:
                return $this->speedStrategy->getSpeed($this->numberOfCoconuts, $this->voltage, $this->isNailed);
            case ParrotTypeEnum::AFRICAN:
                `return max(0, $this->getBaseSpeed() - $this->getLoadFactor() * $this->numberOfCoconuts);`
            case ParrotTypeEnum::NORWEGIAN_BLUE:
                return $this->isNailed ? 0 : $this->getBaseSpeedWith($this->voltage);
        }
        throw new Exception('Should be unreachable');
    }

    private function getBaseSpeedWith(float $voltage): float
    {
        return min(24.0, $voltage * $this->getBaseSpeed());
    }

    private function getLoadFactor(): float
    {
        return 9.0;
    }

    private function getBaseSpeed(): float
    {
        return 12.0;
    }

    private function setStrategy(int $type)
    {
        switch($type) {
            case ParrotTypeEnum::EUROPEAN:
                $this->speedStrategy = new EuropeanSpeedStrategy();
                break;
            case ParrotTypeEnum::AFRICAN:
                $this->speedStrategy = new AfricanSpeedStrategy();
                break;
        }
    }
}

interface SpeedStrategy
{
    public function getSpeed(int $numberOfCoconuts, float $voltage, bool $isNailed): float;
}

class EuropeanSpeedStrategy implements SpeedStrategy
{
    public function getSpeed(int $numberOfCoconuts, float $voltage, bool $isNailed): float
    {
        return 12.0;
    }
}