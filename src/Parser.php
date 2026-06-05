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

                if ( $current->getType() === "T_DASH" && $current->getValue() === "--" ) {
                    $position++;

                    if ( !isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException("Expected option key after '--'");
                    }

                    $optionKey = $listOfTokens[$position];

                    $position++;

                    if ( !isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Expected equal after '%s'", $listOfTokens[$position - 1]->getValue())
                        );
                    }

                    $optionEqual = $listOfTokens[$position];

                    if ( $optionEqual->getType() !== "T_EQUAL" ) {
                        throw new UnexpectedTokenException(
                            sprintf("Unexpected token '%s'", $optionEqual->getValue())
                        );
                    }

                    $position++;

                    if ( !isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Expected expression after '%s'", $listOfTokens[$position - 1]->getValue())
                        );
                    }

                    $optionValue = $listOfTokens[$position];

                    if ( $optionValue->getType() !== "T_LITERAL_1" ) {
                        throw new UnexpectedTokenException("Unexpected token after '='");
                    }

                    $this->elements["options"][$optionKey->getValue()] = $optionValue->getValue();
                }
                else if ( $current->getType() === "T_DASH" && in_array($current->getValue(), ["-", "--"]) ) {
                    $position++;

                    if ( !isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Expected flag key after '%s'", $listOfTokens[$position - 1]->getValue())
                        );
                    }

                    $flagKey = $listOfTokens[$position];

                    if ( $flagKey->getType() !== "T_LITERAL_0" ) {
                        throw new UnexpectedTokenException(
                            sprintf("Unexpected token after '%s'", $listOfTokens[$position - 1]->getValue())
                        );
                    }

                    $position++;

                    if ( isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Unexpected token after '%s'", $listOfTokens[$position - 1]->getValue())
                        );
                    }

                    $this->elements["flags"][$flagKey->getValue()] = true;
                }
                else if ( $current->getType() === "T_LITERAL_0" ) {
                    $argumentKey = $listOfTokens[$position];
                    $position++;

                    if ( isset($listOfTokens[$position]) ) {
                        throw new UnexpectedTokenException(
                            sprintf("Unexpected token after '%s'", $listOfTokens[$position - 1]->getValue())
                        );
                    }

                    $this->elements["arguments"][] = $argumentKey->getValue();
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