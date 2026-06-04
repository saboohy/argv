<?php declare(strict_types=1);

namespace Saboohy\Argv\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Saboohy\Argv\Lexer;
use Saboohy\Argv\Exception\UnexpectedCharacterException;
use Saboohy\Argv\Token;

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
                new Token(type: "T_LITERAL_0", value: "test:it")
            ],
            1 => [
                new Token(type: "T_LITERAL_0", value: "with_argument")
            ],
            2 => [
                new Token(type: "T_DASH", value: "--"),
                new Token(type: "T_LITERAL_0", value: "with-opt"),
                new Token(type: "T_EQUAL", value: "="),
                new Token(type: "T_LITERAL_1", value: "value"),
            ],
            3 => [
                new Token(type: "T_DASH", value: "-"),
                new Token(type: "T_LITERAL_0", value: "with-flag")
            ]
        ];

        $this->assertEquals($lexer->tokens(), $expectedResult);
    }
}