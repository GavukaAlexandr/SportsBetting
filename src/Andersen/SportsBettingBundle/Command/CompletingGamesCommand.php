<?php

namespace Andersen\SportsBettingBundle\Command;

use Andersen\SportsBettingBundle\Entity\Game;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class CompletingGamesCommand extends Command
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct();
        $this->em = $entityManager;
    }

    protected function configure()
    {
        // try to avoid work here (e.g. database query)
        // this method is *always* called - see warning below

        $this
            // the name of the command (the part after "bin/console")
            ->setName('Sport:Completing-Games')
            // the short description shown while running "php bin/console list"
            ->setDescription('the completion of the games given the time of the games.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows completion of the games given the time of the games")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
