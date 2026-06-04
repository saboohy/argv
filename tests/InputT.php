<?php declare(strict_types=1);

namespace Saboohy\Argv\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Saboohy\Argv\Input;

final class InputTest extends TestCase
{
    // #[Test]
    // #[TestDox('Hey!')]
    public function runIt(): void
    {
        $arguments = [
            "test:it",
            "with-argument",
            "--with-option=value",
            "-with-flag"
        ];

        $input = new Input($arguments);

        $input->getCommand();
        $input->getOptions();
        $input->getFlags();
        $input->getArguments();

        $this->assertTrue(true);
    }
}