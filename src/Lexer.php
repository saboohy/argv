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
        foreach ( $this->vectors as $index => $value ) {

            if ( preg_match("/^-{1,2}([a-zA-Z\-_]+)={1}(.+)$/", $value, $option_matches) ) {
                list($opt_key, $opt_val) = array_slice($option_matches, 1);
                
                $this->tokens[$index][] = new Token(type: "T_OPTION_KEY", value: $opt_key);
                $this->tokens[$index][] = new Token(type: "T_OPTION_VAL", value: $opt_val);
            }
            elseif ( preg_match("/^-{1,2}([a-zA-Z\-_]+)$/", $value, $flag_matches) ) {
                $flag_key = $flag_matches[1];

                $this->tokens[$index][] = new Token(type: "T_FLAG_KEY", value: $flag_key);
            }
            elseif ( preg_match("/^([a-zA-Z][a-zA-Z0-9\-_\.\:\/\\\\]+)$/", $value, $command_matches) ) {
                $cmd_key = $command_matches[1];

                $this->tokens[$index][] = new Token(type: "T_ARGUMENT", value: $cmd_key);
            }
            else {
                throw new UnexpectedCharacterException(
                    sprintf("Unexpeted character at %s", $value)
                );
            }
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