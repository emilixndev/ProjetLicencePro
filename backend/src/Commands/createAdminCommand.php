<?php

namespace App\Commands;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:create-admin')]

class createAdminCommand extends Command
{


    public function __construct( private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Please add the email of the user')
            ->addArgument('pass', InputArgument::REQUIRED, 'Please add the pass of the user')

        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $pass = $input->getArgument('pass');

        $output->writeln([
            '<comment>Creating a Admin</comment>',
            '<comment>=================</comment>',
        ]);

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $newUser = new User();
            $newUser->setRoles(['ROLE_ADMIN'])
                ->setEmail($email)
                ->setFirstName("")
                ->setLastName("")
                ->setTel("")
                ->setPassword(password_hash($pass,PASSWORD_DEFAULT));
            $this->entityManager->persist($newUser);
            $this->entityManager->flush();
            $output->writeln([
                '<info>The user has been created</info>',
            ]);
            return Command::SUCCESS;
        }else{
            $output->writeln([
                '<error>The email is incorrect</error>',
            ]);
            return Command::FAILURE;
        }
    }

}