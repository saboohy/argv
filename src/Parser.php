<?php declare(strict_types=1);

namespace Saboohy\Argv;

use Saboohy\Argv\Exception\UnexpectedTokenException;

final class Parser
{
    /**
     * The collection of parsed elements extracted from the tokens.
     * 
     * @var array
     */
    private array $elements = [];

    /**
     * Initializes the parser with a sequence of lexed tokens.
     * 
     * @param array $tokens
     */
    public function __construct(private array $tokens = []) {}

    /**
     * Orchestrates the parsing process to build.
     * 
     * @throws UnexpectedTokenException
     * @return void
     */
    public function parse(): void
    {
        if ( empty($this->tokens) ) return;

        foreach ( $this->tokens as $listOfTokens ) {

            $countOfTokens  = count($listOfTokens);
            $position       = 0;

            while ( $position < $countOfTokens ) {

                $current = $listOfTokens[$position];

                if ( $current->getType() === "T_OPTION_KEY" ) {
                    $opt_key = $current->getValue();

                    $position++;

                    if ( !isset( $listOfTokens[$position] ) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Expected value for option: %s ", $opt_key)
                        );
                    }

                    $opt_value = $listOfTokens[$position]->getValue();

                    $position++;

                    if ( isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Unexpected token after %s", $opt_key)
                        );
                    }

                    $this->elements["options"][$opt_key] = $opt_value;
                }
                elseif ( $current->getType() === "T_FLAG_KEY" ) {
                    $flag_key = $current->getValue();

                    $position++;

                    if ( isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Unexpected token after %s", $flag_key)
                        );
                    }

                    $this->elements["flags"][$flag_key] = true;
                }
                elseif ( $current->gettype() === "T_ARGUMENT" ) {
                    $argument = $current->getValue();

                    $position++;

                    if ( isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Unexpected token after %s", $argument)
                        );
                    }

                    $this->elements["arguments"][] = $argument;
                }

                $position++;
            }
        }
    }

    /**
     * Returns the collected elements extracted during the parsing phase.
     * 
     * @return array
     */
    public function elements(): array
    {
        return $this->elements;
    }
}