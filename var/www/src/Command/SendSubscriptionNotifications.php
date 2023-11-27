<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\SubscriptionNotificationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendSubscriptionNotifications extends Command
{
    public function __construct(
        private SubscriptionNotificationService $subscriptionNotificationService,
        string $name = null,
    )
    {
        parent::__construct($name);
    }
    
    protected function configure(): void
    {
        $this
            ->setName('karma8:subscription:send-notifications')
            ->setDescription('This command sends notifications to users');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $eventsToSendEmail = $this->subscriptionNotificationService->getUnprocessed();
            $totalCount = count($eventsToSendEmail);
            
            if ($totalCount <= 0) {
                $output->writeln('<comment>Nothing to send. List of the unprocessed events is empty</comment>');
                
                return Command::SUCCESS;
            }
            
            $output->writeln(sprintf('<comment>%u events to send Email prepared. Sending...</comment>', $totalCount));
    
            $countOfSuccessful = $this->subscriptionNotificationService->sendAllEmails($eventsToSendEmail);
    
            if ($countOfSuccessful <= 0) {
                $output->writeln('<error>Nothing was sent</error>');
        
                return Command::FAILURE;
            }
            
            $output->writeln(sprintf(
                '<info>%u from %u emails have been sent</info>',
                $countOfSuccessful, $totalCount
            ));
    
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            
            return Command::FAILURE;
        }
    }
}
