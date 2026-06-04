<?php declare(strict_types=1);

namespace Saboohy\Argv;

final class Token
{
    /**
     * @param string $type
     * @param string $value
     * 
     * @return void
     */
    public function __construct(
        private readonly string $type,
        private readonly string $value
    ) {}

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}