<?php declare(strict_types=1);

namespace Saboohy\Argv;

use Saboohy\Argv\Enum\TokenEnum;
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
            TokenEnum::T_DASH->pattern(),
            TokenEnum::T_LITERAL_0->pattern(),
            TokenEnum::T_EQUAL->pattern(),
            TokenEnum::T_LITERAL_1->pattern()
        ) . "$/";

        foreach ( $this->vectors as $index => $value ) {

            $match = preg_match($pattern, $value, $matches);

            if ( !$match ) {
                throw new UnexpectedCharacterException("Unexpected character detected in vector: $value");
            };

            unset($matches[0]);
            
            $tokens = array_filter($matches, function($value, $key) {
                return !is_int($key) && $value !== "";
            }, ARRAY_FILTER_USE_BOTH);

            $this->tokens[$index] = $tokens;
        }
    }

    /**
     * Retrieves the generated tokens after lexical analysis.
     * 
     * @return array
     */
    public function tokens(): array
    {
        return $this->tokens;
    }
}