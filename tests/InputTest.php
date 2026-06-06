<?php declare(strict_types=1);

namespace Saboohy\Argv\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Saboohy\Argv\Input;

final class InputTest extends TestCase
{
    #[Test]
    #[TestDox('It correctly parses raw input vectors into command, options, flags, and arguments')]
    public function itCorrectlyParsesRawInputVectors(): void
    {
        $arguments = [
            "file.php",
            "test:it",
            "with-argument",
            "--with-option=value",
            "-with-flag",
            "second-argument"
        ];

        $input = new Input($arguments);

        $this->assertSame($input->getCommand(), "test:it");
        $this->assertSame($input->getOptions(), ["with-option" => "value"]);
        $this->assertSame($input->getFlags(), ["with-flag" => true]);
        $this->assertSame($input->getArguments(), ["with-argument", "second-argument"]);
    }
}