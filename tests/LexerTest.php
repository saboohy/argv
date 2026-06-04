<?php declare(strict_types=1);

namespace Saboohy\Argv\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Saboohy\Argv\Lexer;
use Saboohy\Argv\Exception\UnexpectedCharacterException;

final class LexerTest extends TestCase
{
    #[Test]
    #[TestDox('Throws an exception when an unexpected character is entered')]
    public function throwsAnExceptionWhenAnUnexpectedCharacterIsEntered(): void
    {
        $lexer = new Lexer(["--flag*"]);

        $this->expectException(UnexpectedCharacterException::class);

        $lexer->tokenize();
    }

    #[Test]
    #[TestDox('It tokenizes command line arguments correctly')]
    public function itTokenizesCommandLineArgumentsCorrectly(): void
    {
        $vectors = [
            "test:it",
            "with_argument",
            "--with-opt=value",
            "-with-flag"
        ];

        $lexer = new Lexer($vectors);
        $lexer->tokenize();

        $expectedResult = [
            0 => [
                "T_LITERAL_0" => "test:it"
            ],
            1 => [
                "T_LITERAL_0" => "with_argument"
            ],
            2 => [
                "T_DASH" => "--",
                "T_LITERAL_0" => "with-opt",
                "T_EQUAL" => "=",
                "T_LITERAL_1" => "value"
            ],
            [
                "T_DASH" => "-",
                "T_LITERAL_0" => "with-flag"
            ]
        ];

        $this->assertSame($lexer->tokens(), $expectedResult);
    }
}