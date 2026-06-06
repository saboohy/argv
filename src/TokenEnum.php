<?php declare(strict_types=1);

namespace Saboohy\Argv;

enum TokenEnum
{
    case T_DASH;
    case T_LITERAL_0;
    case T_EQUAL;
    case T_LITERAL_1;

    public function pattern(): string
    {
        return match($this) {
            TokenEnum::T_DASH       => "(?P<T_DASH>-{1,2})",
            TokenEnum::T_LITERAL_0  => "(?P<T_LITERAL_0>[A-Za-z]{1}[A-Za-z0-9\-_:]*)",
            TokenEnum::T_EQUAL      => "(?P<T_EQUAL>={1})",
            TokenEnum::T_LITERAL_1  => "(?P<T_LITERAL_1>[A-Za-z]{1}[A-Za-z0-9\-_:]*)"
        };
    }
}