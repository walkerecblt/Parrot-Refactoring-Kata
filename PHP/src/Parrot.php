<?php

declare(strict_types=1);

namespace Parrot;

use Exception;

class Parrot
{
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
        $this->numberOfCoconuts = $numberOfCoconuts;
        $this->voltage = $voltage;
        $this->isNailed = $isNailed;
        $this->setStrategy($type);
    }

    public function getSpeed(): float
    {
        return $this->speedStrategy->getSpeed($this->numberOfCoconuts, $this->voltage, $this->isNailed);
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
            case ParrotTypeEnum::NORWEGIAN_BLUE:
                $this->speedStrategy = new NorwegianBlueSpeedStrategy();
                break;
            default:
                $this->speedStrategy = new UnknownSpeedStrategy();
                break;
        }
    }
}

interface SpeedStrategy
{
    public function getSpeed(int $numberOfCoconuts, float $voltage, bool $isNailed): float;
}

abstract class BaseSpeedStrategy
{
    protected function getBaseSpeed(): float
    {
        return 12.0;
    }
}

class AfricanSpeedStrategy extends BaseSpeedStrategy implements SpeedStrategy
{
    public function getSpeed(int $numberOfCoconuts, float $voltage, bool $isNailed): float
    {
        return max(0, $this->getBaseSpeed() - $this->getLoadFactor() * $numberOfCoconuts);
    }

    private function getLoadFactor(): float
    {
        return 9.0;
    }
}

class NorwegianBlueSpeedStrategy extends BaseSpeedStrategy implements SpeedStrategy
{
    public function getSpeed(int $numberOfCoconuts, float $voltage, bool $isNailed): float
    {
        return $isNailed ? 0 : $this->getBaseSpeedWith($voltage);
    }

    private function getBaseSpeedWith(float $voltage): float
    {
        return min(24.0, $voltage * $this->getBaseSpeed());
    }
}

class EuropeanSpeedStrategy extends BaseSpeedStrategy implements SpeedStrategy
{
    public function getSpeed(int $numberOfCoconuts, float $voltage, bool $isNailed): float
    {
        return $this->getBaseSpeed();
    }
}

class UnknownSpeedStrategy implements  SpeedStrategy
{
    public function getSpeed(int $numberOfCoconuts, float $voltage, bool $isNailed): float
    {
        throw new Exception('Should be unreachable');
    }
}