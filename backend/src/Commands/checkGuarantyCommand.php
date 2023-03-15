<?php

namespace App\Commands;

use App\Entity\Material;
use App\Entity\User;
use App\Repository\MaterialRepository;
use App\Service\Emailservice;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:check-guaranty')]

class checkGuarantyCommand extends Command
{


    public function __construct(
        private EntityManagerInterface $entityManager,
        private MaterialRepository $materialRepository,
        private Emailservice $emailservice,
    )
    {
        parent::__construct();
    }




    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $output->writeln([
            '<comment>Checking guaranty</comment>',
            '<comment>=================</comment>',
        ]);

        $date = new DateTime();
        $date->modify('+1 month');

        $materialsNeedToBeWarn = $this->materialRepository->findBy(['endOfGuarantyDate'=>$date]);
        /** @var Material $material */
        foreach ($materialsNeedToBeWarn as $material){
            $this->emailservice->sendEndOfGuarantyWarn($material);
            $output->writeln([
                '<info>Email send to '.$material->getUser()->getEmail().'</info>',
            ]);
        }
        $output->writeln([

            '<comment>=================</comment>',
            '<comment>Email send</comment>',
        ]);
        return Command::SUCCESS;
        }
    }

