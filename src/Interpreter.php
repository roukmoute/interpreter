<?php

declare(strict_types=1);

namespace Roukmoute\Interpreter;

use Exception;
use Webmozart\Assert\Assert;

class Interpreter
{
    /** @var string */
    private $text;

    /** @var int */
    private $position;

    /** @var Token */
    private $currentToken;

    /** @var string|null */
    private $currentChar;

    public function __construct(string $text)
    {
        $this->text = $text;
        $this->position = 0;
        if (isset($this->text[0])) {
            $this->currentChar = $this->text[0];
        }
        $this->currentToken = $this->getNextToken();
    }

    /**
     * @throws Exception
     */
    public function getNextToken(): Token
    {
        while ($this->currentChar) {
            $this->skipWhitespace();

            if (ctype_digit($this->currentChar)) {
                $currentChar = $this->currentChar;
                $this->advance();

                return new Token(Token::INTEGER, $currentChar);
            }

            if ($this->currentChar === '+') {
                $this->advance();

                return new Token(Token::PLUS, '+');
            }

            throw new Exception('Error parsing input');
        }

        return new Token(Token::EOF, null);
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

    private function advance(): void
    {
        $this->currentChar = null;

        if (isset($this->text[++$this->position])) {
            $this->currentChar = $this->text[$this->position];
        }
    }

    private function skipWhitespace(): void
    {
        while (ctype_space((string) $this->currentChar)) {
            $this->advance();
        }
    }
}
