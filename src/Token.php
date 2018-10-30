<?php

declare(strict_types=1);

namespace Roukmoute\Interpreter;

use Greg0ire\Enum\AbstractEnum;
use Webmozart\Assert\Assert;
use function sprintf;

class Token extends AbstractEnum
{
    public const EOF = 'EOF';
    public const INTEGER = 'INTEGER';
    public const PLUS = 'PLUS';
    public const MINUS = 'MINUS';

    /** @var string */
    private $type;

    /** @var string|null */
    private $value;

    /** @param string|null $value */
    public function __construct(string $type, $value = null)
    {
        Assert::oneOf($type, self::getConstants());
        Assert::nullOrString($value);

        $this->type = $type;
        $this->value = $value;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return sprintf('Token(%s, %s)', $this->type, $this->value ?? 'null');
    }
}
