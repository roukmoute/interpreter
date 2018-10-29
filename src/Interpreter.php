<?php

declare(strict_types=1);

namespace Roukmoute\Interpreter;

use Exception;
use function mb_strlen;

class Interpreter
{
    /** @var string */
    private $text;

    /** @var int */
    private $position;

    public function __construct(string $text)
    {
        $this->text = $text;
        $this->position = 0;
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
}
