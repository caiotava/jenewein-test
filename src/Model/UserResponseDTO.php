<?php

namespace App\Model;

use App\Entity\User;

readonly class UserResponseDTO
{
    public int $id;
    public string $name;
    public string $email;
    public array $roles;
    public ?int $organizationID;
    public ?string $token;

    public function __construct(User $user, ?string $token)
    {
        $this->id = $user->getId();
        $this->name = $user->getName();
        $this->email = $user->getEmail();
        $this->roles = $user->getRoles();
        $this->token = $token;

        if (!is_null($user->getOrganization())) {
            $this->organizationID = $user->getOrganization()->getId();
        }
    }
}
