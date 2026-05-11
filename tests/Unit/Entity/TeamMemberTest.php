<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\Teams\Entity;

use Ksfraser\Teams\Entity\TeamMember;
use PHPUnit\Framework\TestCase;

class TeamMemberTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $member = new TeamMember();

        $this->assertNull($member->getId());
        $this->assertSame(0, $member->getTeamId());
        $this->assertSame(0, $member->getUserId());
        $this->assertSame(TeamMember::ROLE_MEMBER, $member->getRole());
        $this->assertTrue($member->canRead());
        $this->assertFalse($member->canWrite());
        $this->assertFalse($member->canDelete());
    }

    /**
     * @covers Ksfraser\Teams\Entity\TeamMember::setTeamId
     * @covers Ksfraser\Teams\Entity\TeamMember::getTeamId
     */
    public function testSetTeamId(): void
    {
        $member = new TeamMember();
        $result = $member->setTeamId(5);

        $this->assertInstanceOf(TeamMember::class, $result);
        $this->assertSame(5, $member->getTeamId());
    }

    /**
     * @covers Ksfraser\Teams\Entity\TeamMember::setUserId
     * @covers Ksfraser\Teams\Entity\TeamMember::getUserId
     */
    public function testSetUserId(): void
    {
        $member = new TeamMember();
        $result = $member->setUserId(100);

        $this->assertInstanceOf(TeamMember::class, $result);
        $this->assertSame(100, $member->getUserId());
    }

    /**
     * @covers Ksfraser\Teams\Entity\TeamMember::setRole
     * @covers Ksfraser\Teams\Entity\TeamMember::getRole
     */
    public function testSetRole(): void
    {
        $member = new TeamMember();
        $result = $member->setRole(TeamMember::ROLE_MANAGER);

        $this->assertInstanceOf(TeamMember::class, $result);
        $this->assertSame(TeamMember::ROLE_MANAGER, $member->getRole());
    }

    /**
     * @covers Ksfraser\Teams\Entity\TeamMember::setCanRead
     * @covers Ksfraser\Teams\Entity\TeamMember::canRead
     */
    public function testSetCanRead(): void
    {
        $member = new TeamMember();
        $result = $member->setCanRead(false);

        $this->assertInstanceOf(TeamMember::class, $result);
        $this->assertFalse($member->canRead());
    }

    /**
     * @covers Ksfraser\Teams\Entity\TeamMember::setCanWrite
     * @covers Ksfraser\Teams\Entity\TeamMember::canWrite
     */
    public function testSetCanWrite(): void
    {
        $member = new TeamMember();
        $result = $member->setCanWrite(true);

        $this->assertInstanceOf(TeamMember::class, $result);
        $this->assertTrue($member->canWrite());
    }

    /**
     * @covers Ksfraser\Teams\Entity\TeamMember::setCanDelete
     * @covers Ksfraser\Teams\Entity\TeamMember::canDelete
     */
    public function testSetCanDelete(): void
    {
        $member = new TeamMember();
        $result = $member->setCanDelete(true);

        $this->assertInstanceOf(TeamMember::class, $result);
        $this->assertTrue($member->canDelete());
    }

    /**
     * @covers Ksfraser\Teams\Entity\TeamMember::ROLE_OWNER
     * @covers Ksfraser\Teams\Entity\TeamMember::ROLE_MANAGER
     */
    public function testRoleConstants(): void
    {
        $this->assertSame('Owner', TeamMember::ROLE_OWNER);
        $this->assertSame('Manager', TeamMember::ROLE_MANAGER);
        $this->assertSame('Member', TeamMember::ROLE_MEMBER);
    }
}