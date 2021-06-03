export const PARROT_TYPES = {
    EUROPEAN:       'EUROPEAN',
    AFRICAN:        'AFRICAN',
    NORWEGIAN_BLUE: 'NORWEGIAN_BLUE',
};

export class Parrot {
    constructor(type, numberOfCoconuts, voltage, isNailed) {
        this.speedStrategy = undefined;
        if(type === PARROT_TYPES.EUROPEAN) {
            this.speedStrategy = function() {
                return this.getBaseSpeed();
            };
        }
        if(type === PARROT_TYPES.AFRICAN) {
            this.speedStrategy = function() {
                return Math.max(0, this.getBaseSpeed() - this.getLoadFactor() * this.numberOfCoconuts);
            };
        }
        if(type === PARROT_TYPES.NORWEGIAN_BLUE) {
            this.speedStrategy = function () {
                return (this.isNailed) ? 0 : this.getBaseSpeedWithVoltage(this.voltage);
            };
        }
        this.type = type;
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
