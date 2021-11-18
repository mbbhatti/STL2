<?php

namespace App\Tests\Unit\Service;

use App\Validator\TypeStringValidator;
use PHPUnit\Framework\TestCase;

class TypeStringValidatorTest extends TestCase
{
    public function testIsValid()
    {
        $typeString = new TypeStringValidator();
        $valid = $typeString->isValid('typeString', ['answer' => 'abc']);
        $this->assertTrue($valid);

        $valid = $typeString->isValid(42, ['answer' => 'abc']);
        $this->assertFalse($valid);
    }

    public function testInvalidDetails()
    {
        $typeString = new TypeStringValidator();
        $content = $typeString->getInvalidDetails();
        $this->assertSame('String', $content);
    }
}

