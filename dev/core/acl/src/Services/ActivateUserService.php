<?php

namespace Dev\ACL\Services;

use Dev\ACL\Models\User;
use Dev\ACL\Repositories\Interfaces\ActivationInterface;

class ActivateUserService
{
    public function __construct(protected ActivationInterface $activationRepository)
    {
    }

    public function activate(User $user): bool
    {
        if ($user->activated) {
            return false;
        }

        event('acl.activating', $user);

        $activation = $this->activationRepository->createUser($user);

        event('acl.activated', [$user, $activation]);

        return $this->activationRepository->complete($user, $activation->code);
    }

    public function remove(User $user): ?bool
    {
        if (! $user->activated) {
            return false;
        }

        event('acl.deactivating', $user);

        $removed = $this->activationRepository->remove($user);

        event('acl.deactivated', $user);

        return $removed;
    }
}
