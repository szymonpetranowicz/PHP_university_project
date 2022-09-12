<?php

namespace App\Tests\Entity\Enum;

use App\Entity\Enum\UserRole;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function labelForUserRole(): array
    {
        return [
            [
                'ROLE_USER',
                UserRole::ROLE_USER
            ],
            [
                'ROLE_ADMIN',
                UserRole::ROLE_ADMIN
            ]
        ];
    }

    /**
     * @dataProvider labelForUserRole
     */
    public function testLabelValidData($label, UserRole $enum)
    {
        $this->assertSame($label, $enum->value);
    }
}
