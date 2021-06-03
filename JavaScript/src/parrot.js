export const PARROT_TYPES = {
    EUROPEAN:       'EUROPEAN',
    AFRICAN:        'AFRICAN',
    NORWEGIAN_BLUE: 'NORWEGIAN_BLUE',
};

class SpeedStrategyFactory {
    static getStrategy(type) {
        switch(type) {
            case PARROT_TYPES.AFRICAN:
                return function() {
                    return Math.max(0, this.getBaseSpeed() - this.getLoadFactor() * this.numberOfCoconuts);
                };
            case PARROT_TYPES.EUROPEAN:
                return function() {
                    return this.getBaseSpeed();
                };
            case PARROT_TYPES.NORWEGIAN_BLUE:
                return function(){
                    return (this.isNailed) ? 0 : this.getBaseSpeedWithVoltage(this.voltage);
                };
            default:
                throw new Error("you've done goofed");
        }
    } 
}
export class Parrot {
    constructor(type, numberOfCoconuts, voltage, isNailed) {
        this.speedStrategy = SpeedStrategyFactory.getStrategy(type);
        this.numberOfCoconuts = numberOfCoconuts;
        this.voltage = voltage;
        this.isNailed = isNailed;
    }

    getSpeed() {
        return this.speedStrategy();
    }

    getBaseSpeedWithVoltage(voltage) {
        return Math.min(24, voltage * this.getBaseSpeed());
    }

    getLoadFactor() {
        return 9;
    }

    getBaseSpeed() {
        return 12;
    }
}
