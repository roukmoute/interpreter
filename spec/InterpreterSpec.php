<?php

namespace spec\Roukmoute\Interpreter;

use Exception;
use PhpSpec\ObjectBehavior;
use Roukmoute\Interpreter\Interpreter;
use Roukmoute\Interpreter\Token;

class InterpreterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(Interpreter::class);
    }

    function it_can_read_next_token_with_integer()
    {
        $this->beConstructedWith('3+5');
        $this->getNextToken()->shouldBeLike(new Token(Token::INTEGER, '3'));
    }

    function it_can_read_next_token_with_plus()
    {
        $this->beConstructedWith('3+5');
        $this->getNextToken();
        $this->getNextToken()->shouldBeLike(new Token(Token::PLUS, '+'));
    }

    function it_can_read_next_token_with_end_of_line()
    {
        $this->beConstructedWith('3+5');
        $this->getNextToken();
        $this->getNextToken();
        $this->getNextToken();
        $this->getNextToken()->shouldBeLike(new Token(Token::EOF, null));
    }

    function it_throws_an_exception_when_input_contains_unknow_token()
    {
        $this->beConstructedWith('3 + 5');
        $this->getNextToken();
        $this->shouldThrow(new Exception('Error parsing input'))->during('getNextToken');
    }
}
