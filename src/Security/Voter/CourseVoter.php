<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Security\Role;
use App\Entity\Course;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;

final class CourseVoter extends Voter
{
    public const string EDIT = 'COURSE_EDIT';
    public const string VIEW = 'COURSE_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW]) && $subject instanceof Course;
    }

    protected function voteOnAttribute(
        string $attribute,
        mixed $subject,
        TokenInterface $token,
        ?Vote $vote = null,
    ): bool {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($user, $subject),
            self::VIEW => $this->canView($user, $subject),
            default => false,
        };
    }

    private function canEdit(User $user, Course $course): bool
    {
        if (!$this->canView($user, $course)) {
            return false;
        }

        return $user->hasRole(Role::ADMIN) || $user->hasRole(Role::CONTENT_MANAGER);
    }

    private function canView(User $user, Course $course): bool
    {
        $userOrganizationID = $user->getOrganization()?->getId();
        $hasSameOrganization = $course->getOrganization()->getId() === $userOrganizationID;

        if ($user->hasRole(Role::ADMIN) && ($hasSameOrganization || is_null($userOrganizationID))) {
            return true;
        }

        if (!$hasSameOrganization) {
            return false;
        }

        if ($user->hasRole(Role::CONTENT_MANAGER)) {
            return true;
        }

        $sameCourse = $user->getCourses()->exists(function (int $key, $userCourse) use ($course): bool {
            return $course->getId() === $userCourse->getCourse()->getId();
        });

        return $user->hasRole(Role::USER) && $sameCourse;
    }
}
