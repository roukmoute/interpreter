<?php

declare(strict_types=1);

namespace Roukmoute\Interpreter;

use Exception;
use Webmozart\Assert\Assert;
use function mb_strlen;

class Interpreter
{
    /** @var string */
    private $text;

    /** @var int */
    private $position;

    /** @var Token */
    private $currentToken;

    public function __construct(string $text)
    {
        $this->text = $text;
        $this->position = 0;
        $this->currentToken = $this->getNextToken();
    }

    /**
     * @throws Exception
     */
    public function getNextToken(): Token
    {
        $text = $this->text;

        if ($this->position > mb_strlen($text) - 1) {
            return new Token(Token::EOF, null);
        }

        $currentChar = $text[$this->position];

        if (ctype_digit($currentChar)) {
            ++$this->position;

            return new Token(Token::INTEGER, $currentChar);
        }

        if ($currentChar === '+') {
            ++$this->position;

            return new Token(Token::PLUS, $currentChar);
        }

        throw new Exception('Error parsing input');
    }

    /**
     * @throws Exception
     */
    public function consume(string $type): void
    {
        Assert::oneOf($type, Token::getConstants());

        if ($this->currentToken->type() !== $type) {
            throw new Exception('Error parsing input');
        }

        $this->currentToken = $this->getNextToken();
    }

    public function currentToken(): Token
    {
        return $this->currentToken;
    }

    public function expr(): string
    {
        $left = $this->currentToken;
        $this->consume(Token::INTEGER);

        $this->consume(Token::PLUS);

        $right = $this->currentToken;
        $this->consume(Token::INTEGER);

        $result = (int) $left->value() + (int) $right->value();

        return (string) $result;
    }
}
