<?php

namespace spec\Roukmoute\Interpreter;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Roukmoute\Interpreter\Token;
use function implode;
use function sprintf;

class TokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Token::INTEGER, '0');

        $this->shouldHaveType(Token::class);
    }

    function it_is_an_integer_with_the_value_0_token()
    {
        $this->beConstructedWith(Token::INTEGER, '0');

        $this->__toString()->shouldBe('Token(INTEGER, 0)');
    }

    function it_is_an_integer_with_the_value_9_token()
    {
        $this->beConstructedWith(Token::INTEGER, '9');

        $this->__toString()->shouldBe('Token(INTEGER, 9)');
    }

    function it_is_a_char_plus_token()
    {
        $this->beConstructedWith(Token::PLUS, '+');

        $this->__toString()->shouldBe('Token(PLUS, +)');
    }

    function it_is_a_end_of_file_token()
    {
        $this->beConstructedWith(Token::EOF, null);

        $this->__toString()->shouldBe('Token(EOF, null)');
    }

    function it_throws_an_exception_when_type_does_not_exist()
    {
        $this->beConstructedWith('BOOL', '9');

        $this
            ->shouldThrow(
                new InvalidArgumentException(
                    sprintf('Expected one of: "%s". Got: "BOOL"', trim(implode('", "', Token::getConstants())))
                )
            )
            ->duringInstantiation()
        ;
    }

    function it_returns_the_type()
    {
        $this->beConstructedWith(Token::INTEGER, '9');

        $this->type()->shouldReturn('INTEGER');
    }

    function it_returns_the_value()
    {
        $this->beConstructedWith(Token::INTEGER, '9');

        $this->value()->shouldReturn('9');
    }
}
