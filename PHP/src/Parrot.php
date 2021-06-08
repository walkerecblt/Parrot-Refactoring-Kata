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

    /** @var float */
    private $voltage;

    /** @var bool */
    private $isNailed;

    private $strategy;

    private function setGetSpeedStrategy(int $type)
    {
        switch ($this->type) {
            case ParrotTypeEnum::EUROPEAN:
                $this->strategy = function () {
                    return $this->getBaseSpeed();
                };
                break;
            case ParrotTypeEnum::AFRICAN:
                $this->strategy = function () {
                    return max(0, $this->getBaseSpeed() - $this->getLoadFactor() * $this->numberOfCoconuts);
                };
                break;
            case ParrotTypeEnum::NORWEGIAN_BLUE:
                $this->strategy = function () {
                    return $this->isNailed ? 0 : $this->getBaseSpeedWith($this->voltage);
                };
                break;
            default:
                $this->strategy = function() {
                    throw new Exception('Should be unreachable');
                };
        }
    }

    public function __construct(int $type, int $numberOfCoconuts, float $voltage, bool $isNailed)
    {
        $this->type = $type;
        $this->numberOfCoconuts = $numberOfCoconuts;
        $this->voltage = $voltage;
        $this->isNailed = $isNailed;
        $this->setGetSpeedStrategy($type);
    }

    public function getSpeed(): float
    {
        return call_user_func($this->strategy);
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
}

interface SpeedStrategy {
    function getSpeed(): float;
}

class EuropeanSpeedStrategy implements SpeedStrategy {
    $parrot;
    public function __construct($parrot) {
        $this->parrot = $parrot;
    }
    public function getSpeed(): float
    {

    }
}