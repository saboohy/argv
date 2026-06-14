<?php declare(strict_types=1);

namespace Saboohy\Argv;

use Saboohy\Argv\Token;
use Saboohy\Argv\Exception\UnexpectedCharacterException;

class Lexer
{
    /**
     * The list of lexed syntax tokens.
     * 
     * @var array
     */
    private array $tokens = [];

    /**
     * Initializes the lexer with raw input vectors.
     * 
     * @param array $vectors
     */
    public function __construct(private array $vectors) {}

    /**
     * Executes the lexical analysis to convert input vectors into tokens.
     * 
     * @throws UnexpectedCharacterException
     * @return void
     */
    public function tokenize(): void
    {
        $pattern = "/^" . sprintf(
            "%s?%s%s?%s?",
            "(?P<T_DASH>-{1,2})",
            "(?P<T_LITERAL_0>[a-zA-Z0-9\-_:\.\/\\\\]*)",
            "(?P<T_EQUAL>={1})",
            "(?P<T_LITERAL_1>[a-zA-Z0-9\-_:\.\/\\\\]*)"
        ) . "$/";

        foreach ( $this->vectors as $index => $value ) {

            $match = preg_match($pattern, $value, $matches);

            if ( !$match ) {
                throw new UnexpectedCharacterException("Unexpected character detected in vector: $value");
            };

            unset($matches[0]);
            
            $filtered = array_filter($matches, function($value, $key) {
                return !is_int($key) && $value !== "";
            }, ARRAY_FILTER_USE_BOTH);

            $this->tokens[$index] = array_map(
                fn($key, $val) => new Token(type: $key, value: $val),
                array_keys($filtered),
                $filtered
            );;
        }
    }

    /**
     * Returns the generated tokens after lexical analysis.
     * 
     * @return array
     */
    public function tokens(): array
    {
        return $this->tokens;
    }
}