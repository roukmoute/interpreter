<?php

declare(strict_types=1);

namespace Roukmoute\Interpreter\Command;

use InvalidArgumentException;
use Roukmoute\Interpreter\Interpreter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use const PHP_EOL;
use function is_a;

final class CalculatorCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('app:calculator');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = $this->getQuestionHelper();
        while (null !== $text = $io->ask($input, $output, new Question('calc> '))) {
            echo (new Interpreter($text))->expr() . PHP_EOL;
        }
    }

    /**
     * @throws InvalidArgumentException if the "question" helper is not defined
     */
    private function getQuestionHelper(): QuestionHelper
    {
        $question = $this->getHelperSet()->get('question');

        if (!is_a($question, QuestionHelper::class, true)) {
            $this->getHelperSet()->set($question = new QuestionHelper());
        }

        return $question;
    }
}
