<?php

namespace Geekco\CmsBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Geekco\CmsBundle\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateAdminCommand extends Command
{

    private $em;

    private $passwordEncoder;

    private $validator;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, ValidatorInterface $validator)
    {

        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;

        parent::__construct();

    }

    protected function configure()
    {
        $this
            ->setName('geekco_cms:create-admin')
            ->setDescription('Create an admin.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('is_super_admin', InputArgument::REQUIRED, 'Is super admin'),
            ))
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $user = new User();

        $username = $input->getArgument('username');

        $email = $input->getArgument('email');

        $password = $input->getArgument('password');
        $password = $this->passwordEncoder->encodePassword($user, $password);

        $is_super_admin = $input->getArgument('is_super_admin');

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        if ($is_super_admin) {
            $user->setRoles(array('ROLE_USER', 'ROLE_SUPER_ADMIN'));
        }
        else
        { 
            $user->setRoles(array('ROLE_USER', 'ROLE_ADMIN'));
        }

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new \Exception($errorsString);
        }


        $this->em->persist($user);
        $this->em->flush();

        $output->writeln(sprintf('Created admin <comment>%s</comment>', $username));
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();

        if (!$input->getArgument('username')) {
            $question = new Question('Please choose a username:');
            $questions['username'] = $question;
        }

        if (!$input->getArgument('email')) {
            $question = new Question('Please choose an email:');
            $questions['email'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password:');
            $question->setHidden(true);
            $question->setHiddenFallback(false);
            $questions['password'] = $question;
        }

        if (!$input->getArgument('is_super_admin') === true) {
            $question = new ConfirmationQuestion('is super admin (y|n)?', false);
            $questions['is_super_admin'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}

