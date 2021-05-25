import {Parrot, PARROT_TYPES, ParrotFactory} from '../parrot';

describe("Parrot", function () {
    test("get speed of european parrot", function () {
        const parrot = new ParrotFactory().hatchEuropean();
        expect(parrot.getSpeed()).toBe(12);
    });

    test("get speed of african parrot with one coconut", function () {
        const parrot = new ParrotFactory().hatchAfrican(1);

        expect(parrot.getSpeed()).toBe(3);
    });

    test("get speed of african parrot with two coconuts", function () {
        const parrot = new ParrotFactory().hatchAfrican(2);

        expect(parrot.getSpeed()).toBe(0);
    });

    test("get speed of african parrot with no coconuts", function () {
        const parrot = new ParrotFactory().hatchAfrican(0);

        expect(parrot.getSpeed()).toBe(12);
    });

    test("get speed norwegian blue parrot nailed", function () {
        const parrot = new ParrotFactory().hatchNorwegianBlue(1.5, true);

        expect(parrot.getSpeed()).toBe(0);
    });

    test("get speed norwegian blue parrot not nailed", function () {
        const parrot = new ParrotFactory().hatchNorwegianBlue(1.5, false);

        expect(parrot.getSpeed()).toBe(18);
    });

    test("get speed norwegian blue parrot not nailed high voltage", function () {
        const parrot = new ParrotFactory().hatchNorwegianBlue(4, false);

        expect(parrot.getSpeed()).toBe(24);
    });
});
