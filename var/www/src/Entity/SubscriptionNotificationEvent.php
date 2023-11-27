<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\Database\SubscriptionNotification\Type;
use App\Repository\SubscriptionNotificationEventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionNotificationEventRepository::class)]
#[ORM\Table(name: 'subscription_notification_event')]
#[ORM\UniqueConstraint(name: 'unique_type_per_subscription', columns: ['user_subscription_id', 'type'])]
#[ORM\Index(columns: ['triggered'], name: 'triggered_idx')]
class SubscriptionNotificationEvent
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;
    
    #[ORM\Column(type:Types::INTEGER)]
    private int $userSubscriptionId;
    
    #[ORM\ManyToOne(targetEntity: UserSubscription::class, fetch:'EAGER', inversedBy: 'subscriptionNotificationEvents')]
    #[ORM\JoinColumn(name: 'user_subscription_id', onDelete: 'CASCADE')]
    private UserSubscription $userSubscription;
    
    #[ORM\Column(type:Types::STRING, length: 1)]
    private string $type;
    
    #[ORM\Column(type: Types::BOOLEAN, options:['default' => false])]
    private bool $triggered;
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): SubscriptionNotificationEvent
    {
        $this->id = $id;
        return $this;
    }
    
    public function getUserSubscription(): UserSubscription
    {
        return $this->userSubscription;
    }
    
    public function setUserSubscription(UserSubscription $userSubscription): SubscriptionNotificationEvent
    {
        $this->userSubscription = $userSubscription;
        return $this;
    }
    
    public function getType(): ?Type
    {
        return Type::tryFrom($this->type);
    }
    
    public function setType(Type $type): SubscriptionNotificationEvent
    {
        $this->type = $type->value;
        return $this;
    }
    
    public function isTriggered(): bool
    {
        return $this->triggered;
    }
    
    public function setTriggered(bool $triggered): SubscriptionNotificationEvent
    {
        $this->triggered = $triggered;
        return $this;
    }
}
