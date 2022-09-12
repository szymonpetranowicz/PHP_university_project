<?php

namespace App\Tests\Security\Voter;

use App\Entity\Bug;
use App\Entity\User;
use App\Security\Voter\BugVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BugVoterTest extends TestCase
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const CORRECT_USER_ID_1 = 1;
    const INCORRECT_USER_ID_2 = 2;

    private BugVoter $class;

    public function setUp(): void
    {
        $this->class = new BugVoter();
    }

    private function createBug(User $user, bool $status) : Bug
    {
        $bug = new Bug();
        $bug->setAuthor($user);
        $bug->setTitle('title');
        $bug->setDescription('description');
        $bug->setStatus($status);

        return $bug;
    }

    private function createTokenForUser(User $user) : TokenInterface
    {
        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user);

        return $token;
    }

    private function createUser(int $userId, string $role) : User
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn($userId);
        $user->method('getRoles')->willReturn([$role]);

        return $user;
    }

    public function testAccessDenyBugForUser(): void
    {
        $token = $this->createMock(TokenInterface::class);
        $this->assertSame(Voter::ACCESS_ABSTAIN, $this->class->vote($token,  new Bug(), []));
    }
    /**
     * @dataProvider combinationsToTest
     */
    public function testAccessBugForUser(User $user, string $attribute, int $expect): void
    {
        $correctUser = $this->createUser(self::CORRECT_USER_ID_1, self::ROLE_USER);
        $bug = $this->createBug($correctUser, true);
        $token = $this->createTokenForUser($user);
        $this->assertSame($expect, $this->class->vote($token,  $bug, [$attribute]));
    }

    /**
     * @return array
     */
    public function combinationsToTest()
    {
        $correctUser = $this->createUser(self::CORRECT_USER_ID_1, self::ROLE_USER);
        $incorrectUser = $this->createUser(self::INCORRECT_USER_ID_2, self::ROLE_USER);
        $adminUser = $this->createUser(self::INCORRECT_USER_ID_2, self::ROLE_ADMIN);
        return [
            [
                $incorrectUser,
                BugVoter::EDIT,
                Voter::ACCESS_DENIED
            ],
            [
                $incorrectUser,
                BugVoter::DELETE,
                Voter::ACCESS_DENIED
            ],
            [
                $incorrectUser,
                BugVoter::VIEW,
                Voter::ACCESS_DENIED
            ],
            [
                $adminUser,
                BugVoter::EDIT,
                Voter::ACCESS_GRANTED
            ],
            [
                $adminUser,
                BugVoter::DELETE,
                Voter::ACCESS_GRANTED
            ],
            [
                $adminUser,
                BugVoter::VIEW,
                Voter::ACCESS_GRANTED
            ],
            [
                $correctUser,
                BugVoter::EDIT,
                Voter::ACCESS_DENIED
            ],
            [
                $correctUser,
                BugVoter::DELETE,
                Voter::ACCESS_DENIED
            ],
            [
                $correctUser,
                BugVoter::VIEW,
                Voter::ACCESS_GRANTED
            ],
        ];
    }
}
