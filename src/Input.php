<?php declare(strict_types=1);

namespace Saboohy\Argv;

use Saboohy\Argv\Lexer;
use Saboohy\Argv\Parser;

class Input
{
    /**
     * @var ?string
     */
    private ?string $command = null;

    /**
     * @var array
     */
    private array $options = [];

    /**
     * @var array
     */
    private array $flags = [];

    /**
     * @var array
     */
    private array $arguments = [];

    /**
     * @param array $vectors
     * 
     * @return void
     */
    public function __construct(private array $vectors)
    {
        $this->init();
    }

    /**
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
    }

    /**
     * @return ?string
     */
    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function getFlags(): array
    {
        return $this->flags;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }
}