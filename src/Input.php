<?php declare(strict_types=1);

namespace Saboohy\Argv;

use Saboohy\Argv\Lexer;
use Saboohy\Argv\Parser;

class Input
{
    /**
     * The extracted command name, if present.
     * 
     * @var ?string
     */
    private ?string $command = null;

    /**
     * The associative array of parsed options.
     * 
     * @var array
     */
    private array $options = [];

    /**
     * The associative array of parsed flags.
     * 
     * @var array
     */
    private array $flags = [];

    /**
     * The list of standalone arguments, excluding the main command.
     * 
     * @var array
     */
    private array $arguments = [];

    /**
     * Initializes the input instance with raw vectors.
     * 
     * @param array $vectors
     * 
     * @return void
     */
    public function __construct(private array $vectors)
    {
        $this->init();
    }

    /**
     * Executes the internal lexical analysis and parsing to populate input data.
     * 
     * @return void
     */
    private function init(): void
    {
        if ( isset($this->vectors[0]) ) {
            unset($this->vectors[0]);
        }

        if ( empty($this->vectors) ) return;

        $lexer = new Lexer($this->vectors);
        $lexer->tokenize();

        $parser = new Parser($lexer->tokens());
        $parser->parse();

        $elements = $parser->elements();
        $arguments = $elements["arguments"];

        $this->options = $elements["options"] ?? null;
        $this->flags = $elements["flags"] ?? null;
        $this->command = $arguments[0] ?? null;

        if ( count($arguments) > 1 ) {
            $this->arguments = array_slice($arguments, 1);
        }
    }

    /**
     * Returns the parsed command name.
     * 
     * @return ?string
     */
    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * Returns the collection of parsed options.
     * 
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Retrieves the collection of parsed flags.
     * 
     * @return array
     */
    public function getFlags(): array
    {
        return $this->flags;
    }

    /**
     * Retrieves the list of parsed standalone arguments.
     * 
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}