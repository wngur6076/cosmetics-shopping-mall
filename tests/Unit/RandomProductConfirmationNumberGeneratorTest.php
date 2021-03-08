<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\RandomConfirmationNumberGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RandomProductConfirmationNumberGeneratorTest extends TestCase
{
    /** @test */
    function must_be_24_characters_long()
    {
        $generator = new RandomConfirmationNumberGenerator;

        $confirmationNumber = $generator->generate();

        $this->assertEquals(24, strlen($confirmationNumber));
    }

    /** @test */
    function can_only_contain_uppercase_letters_and_numbers()
    {
        $generator = new RandomConfirmationNumberGenerator;

        $confirmationNumber = $generator->generate();

        $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $confirmationNumber);
    }

    /** @test */
    function cannot_contain_ambiguous_characters()
    {
        $generator = new RandomConfirmationNumberGenerator;

        $confirmationNumber = $generator->generate();

        $this->assertFalse(strpos($confirmationNumber, '1'));
        $this->assertFalse(strpos($confirmationNumber, 'I'));
        $this->assertFalse(strpos($confirmationNumber, '0'));
        $this->assertFalse(strpos($confirmationNumber, 'O'));
    }

    /** @test */
    function confirmation_numbers_must_be_unique()
    {
        $generator = new RandomConfirmationNumberGenerator;

        $confirmationNumbers = array_map(function ($i) use ($generator) {
            return $generator->generate();
        }, range(1, 100));

        $this->assertCount(100, array_unique($confirmationNumbers));
    }
}
