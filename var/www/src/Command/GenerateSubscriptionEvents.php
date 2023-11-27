<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\SubscriptionNotificationEvent;
use App\Enum\Database\SubscriptionNotification\Type;
use App\Service\UserSubscriptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSubscriptionEvents extends Command
{
    public function __construct(
        private UserSubscriptionService $userSubscriptionService,
        private EntityManagerInterface $em,
        string $name = null,
    )
    {
        parent::__construct($name);
    }
    
    protected function configure(): void
    {
        $this
            ->setName('karma8:subscription:generate-events')
            ->setDescription('This command generates notification events for user subscriptions');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTimeImmutable();
        $oneDayCount = 0;
        $threeDaysCount = 0;
        
        try {
            $subscriptionsToProcess = $this->userSubscriptionService->getAllForNotification();
            
            if ($subscriptionsToProcess->count() <= 0) {
                $output->writeln('<comment>Nothing to do. All events have been generated</comment>');
                
                return Command::SUCCESS;
            }
            
            foreach ($subscriptionsToProcess as $subscription) {
                $secsBeforeExpiration = $subscription->getValidTs() - $now->getTimestamp();
        
                $event = (new SubscriptionNotificationEvent())
                    ->setUserSubscription($subscription)
                    ->setTriggered(false);
        
                if ($secsBeforeExpiration <= UserSubscriptionService::EPOCH_ONE_DAY) {
                    $event->setType(Type::OneDayLeft);
                    $oneDayCount++;
                } else {
                    $event->setType(Type::ThreeDaysLeft);
                    $threeDaysCount++;
                }
                
                $this->em->persist($event);
            }
    
            $this->em->flush();
            $output->writeln(sprintf(
                '<info>Operation completed! %u events created. %u for one-day notification and %u for three-days</info>',
                $oneDayCount + $threeDaysCount,
                $oneDayCount, $threeDaysCount
            ));
    
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            
            return Command::FAILURE;
        }
    }
}
