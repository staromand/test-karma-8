<?php

namespace App\Service;

use App\Entity\SubscriptionNotificationEvent;
use App\Entity\UserSubscription;
use App\Enum\Database\SubscriptionNotification\Type;
use App\Repository\UserSubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Join;

class UserSubscriptionService
{
    public const EPOCH_ONE_DAY = 86400;
    public const EPOCH_THREE_DAYS = 259200;
    
    public function __construct(
        private UserSubscriptionRepository $userSubscriptionRepository,
    )
    {
    }
    
    /**
     * @return ArrayCollection|iterable<UserSubscription>
     */
    public function getAllForNotification(): ArrayCollection
    {
        $qb = $this->userSubscriptionRepository->createQueryBuilder('s');
        
        $query = $qb
            ->leftJoin('s.user', 'u')
            ->leftJoin(
                SubscriptionNotificationEvent::class,
                'e1d', Join::WITH, 's.id = e1d.userSubscriptionId AND e1d.type = :one_day_event_type'
            )
            ->leftJoin(
                SubscriptionNotificationEvent::class,
                'e3d', Join::WITH, 's.id = e3d.userSubscriptionId AND e3d.type = :three_days_event_type'
            )
            ->andWhere('s.validTs > UNIX_TIMESTAMP()')
            ->andWhere('u.validEmail = true')
            ->andWhere($qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->gte('s.validTs', 'UNIX_TIMESTAMP() + :epoch_one_day'),
                    $qb->expr()->lte('s.validTs', 'UNIX_TIMESTAMP() + :epoch_three_days'),
                    $qb->expr()->isNull('e1d.type'),
                    $qb->expr()->isNull('e3d.type'),
                ),
                $qb->expr()->andX(
                    $qb->expr()->lte('s.validTs', 'UNIX_TIMESTAMP() + :epoch_one_day'),
                    $qb->expr()->isNull('e1d.type'),
                )
            ))
            ->setParameters([
                'epoch_one_day' => static::EPOCH_ONE_DAY,
                'epoch_three_days' => static::EPOCH_THREE_DAYS,
                'one_day_event_type' => Type::OneDayLeft,
                'three_days_event_type' => Type::ThreeDaysLeft,
            ]);
        
        return new ArrayCollection($query->getQuery()->getResult());
    }
}
