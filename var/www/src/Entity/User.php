<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User
{
    #[ORM\Id()]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue()]
    private int $id;
    
    #[ORM\Column(type: Types::STRING, length:255)]
    private string $username;
    
    #[ORM\Column(type: Types::STRING, length:255)]
    private string $email;
    
    #[ORM\Column(type:Types::INTEGER, length:11)]
    private int $validts;
    
    #[ORM\Column(type: Types::BOOLEAN, options:['default' => false])]
    private bool $confirmed;

    #[ORM\Column(type: Types::BOOLEAN, options:['default' => false])]
    private bool $checked;
    
    #[ORM\Column(type: Types::BOOLEAN, options:['default' => false])]
    private bool $valid;
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }
    
    public function getUsername(): string
    {
        return $this->username;
    }
    
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }
    
    public function getValidts(): int
    {
        return $this->validts;
    }
    
    public function setValidts(int $validts): User
    {
        $this->validts = $validts;
        return $this;
    }
    
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }
    
    public function setConfirmed(bool $confirmed): User
    {
        $this->confirmed = $confirmed;
        return $this;
    }
    
    public function isChecked(): bool
    {
        return $this->checked;
    }
    
    public function setChecked(bool $checked): User
    {
        $this->checked = $checked;
        return $this;
    }
    
    public function isValid(): bool
    {
        return $this->valid;
    }
    
    public function setValid(bool $valid): User
    {
        $this->valid = $valid;
        return $this;
    }
}
