<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\Database\SubscriptionNotification\Type;
use App\Repository\SubscriptionNotificationRepository;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionNotificationRepository::class)]
#[ORM\Table(name: 'subscription_notification')]
class SubscriptionNotification
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;
    
    #[ORM\ManyToOne(targetEntity: UserSubscription::class, fetch:'EAGER')]
    #[ORM\JoinColumn(name:'user_subscription_id', onDelete: 'CASCADE')]
    private UserSubscription $userSubscription;
    
    #[ORM\Column(type:Types::TEXT, length: AbstractMySQLPlatform::LENGTH_LIMIT_TEXT)]
    private string $body;
    
    #[ORM\Column(type:Types::STRING, length: 1, enumType: Type::class)]
    private string $type;
    
    #[ORM\Column(type: Types::BOOLEAN, options:['default' => false])]
    private bool $triggered;
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): SubscriptionNotification
    {
        $this->id = $id;
        return $this;
    }
    
    public function getUserSubscription(): UserSubscription
    {
        return $this->userSubscription;
    }
    
    public function setUserSubscription(UserSubscription $userSubscription): SubscriptionNotification
    {
        $this->userSubscription = $userSubscription;
        return $this;
    }
    
    public function getBody(): string
    {
        return $this->body;
    }
    
    public function setBody(string $body): SubscriptionNotification
    {
        $this->body = $body;
        return $this;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function setType(string $type): SubscriptionNotification
    {
        $this->type = $type;
        return $this;
    }
    
    public function isTriggered(): bool
    {
        return $this->triggered;
    }
    
    public function setTriggered(bool $triggered): SubscriptionNotification
    {
        $this->triggered = $triggered;
        return $this;
    }
}
