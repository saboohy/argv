<?php declare(strict_types=1);

namespace Saboohy\Argv\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Saboohy\Argv\Parser;
use Saboohy\Argv\Lexer;
use Saboohy\Argv\Token;
use Saboohy\Argv\Exception\UnexpectedTokenException;

final class ParserTest extends TestCase
{
    #[Test]
    #[TestDox('Throws an exception when an unexpected token is entered')]
    public function throwsAnExceptionWhenAnUnexpectedTokenIsEntered(): void
    {
        $failTokens = [
            0 => [
                new Token(type: "T_OPTION_KEY", value: "option"),
                new Token(type: "T_OPTION_VAL", value: "value"),
                new Token(type: "T_ARGUMENT", value: "test_arg")
            ]
        ];

        $parser = new Parser($failTokens);
        
        $this->expectException(UnexpectedTokenException::class);

        $parser->parse();
    }

    #[Test]
    #[TestDox('It parses valid tokens successfully')]
    public function parsesValidTokensSuccessfully(): void
    {
        $lexer = new Lexer(["make:it", "file_name", "--option=value", "-flag", "--opt=val"]);
        $lexer->tokenize();

        $parser = new Parser($lexer->tokens());
        $parser->parse();

        $expected = [
            "arguments" => [
                "make:it",
                "file_name"
            ],
            "options" => [
                "option" => "value",
                "opt" => "val"
            ],
            "flags" => [
                "flag" => true
            ]
        ];

        $this->assertSame($parser->elements(), $expected);
    }
}