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

    function it_reads_plus_token()
    {
        $this->beConstructedWith('3+5');

        $this->getNextToken()->shouldBeLike(new Token(Token::PLUS, '+'));
    }

    function it_reads_end_of_line_token()
    {
        $this->beConstructedWith('3+5');
        $this->getNextToken();
        $this->getNextToken();
        $this->getNextToken()->shouldBeLike(new Token(Token::EOF, null));
    }

    function it_reads_integer_token()
    {
        $this->beConstructedWith('3+5');

        $this->currentToken()->shouldBeLike(new Token(Token::INTEGER, '3'));
    }

    function it_throws_an_exception_when_input_contains_unknow_token()
    {
        $this->beConstructedWith('3e5');

        $this->shouldThrow(new Exception('Error parsing input'))->during('getNextToken');
    }

    function it_consumes_current_token()
    {
        $this->beConstructedWith('3+5');
        $this->consume(Token::INTEGER);

        $this->currentToken()->shouldBeLike(new Token(Token::PLUS, '+'));
    }

    function it_throws_when_consume_cannot_have_correct_token()
    {
        $this->beConstructedWith('3+5');

        $this->shouldThrow(new Exception('Error parsing input'))->during('consume', [Token::PLUS]);
    }

    function it_computes_an_addition_with_one_digits()
    {
        $this->beConstructedWith('3+5');

        $this->expr()->shouldReturn('8');
    }

    function it_computes_an_addition_with_whitespace_characters()
    {
        $this->beConstructedWith('  3  +  5');

        $this->expr()->shouldReturn('8');
    }

    function it_computes_an_addition_with_multi_digit_integers()
    {
        $this->beConstructedWith('13 + 29');

        $this->expr()->shouldReturn('42');
    }

    function it_computes_a_soustraction_with_multi_digit_integers()
    {
        $this->beConstructedWith('42 - 29');

        $this->expr()->shouldReturn('13');
    }

    function it_computes_arithmetic_expressions_that_have_any_number()
    {
        $this->beConstructedWith('7 - 3 + 2 - 1');

        $this->expr()->shouldReturn('5');
    }
}
