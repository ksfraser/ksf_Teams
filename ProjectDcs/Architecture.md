# Architecture - ksf_Teams

## Document Information
- **Module**: ksf_Teams
- **Version**: 1.0.0
- **Date**: 2026-05-24
- **Status**: Draft
- **Author**: KSFII Development Team

---

## 1. Module Overview

ksf_Teams manages team composition and membership. Teams in this module correspond directly to RBAC teams, serving as the business-logic layer for team-based access control.

### 1.1 Namespace
```php
Ksfraser\Teams\
```

### 1.2 Layer Pattern
```
ksf_Teams/                   → Business Logic
    ├── Entity/              → Domain entities
    ├── Service/             → Business services
    ├── Repository/          → Data access interfaces
    └── Exception/           → Domain exceptions
```

---

## 2. Core Entities

### 2.1 Team
```php
class Team {
    private string $id;
    private string $name;
    private ?string $description;
    private TeamType $type;            // static, dynamic
    private string $ownerId;
    private bool $requiresApproval;
    private bool $autoManaged;
    private \DateTime $createdAt;
    private ?\DateTime $updatedAt;
}
```

### 2.2 TeamMember
```php
class TeamMember {
    private string $id;
    private string $teamId;
    private string $userId;
    private string $role;               // owner, manager, member
    private \DateTime $addedAt;
    private ?\DateTime $approvedAt;
    private bool $active;
}
```

---

## 3. RBAC Integration (ksfraser/rbac)

### 3.1 RBAC Team Seeding

ksf_Teams is the AUTHORITATIVE source for RBAC teams. Every Team in ksf_Teams creates/updates a corresponding record in:
- `0_rbac_teams` — RBAC team definition (team_id, name, team_type, module)
- `0_rbac_team_members` — Membership (team_id, user_id, role, inactive)

On Team creation → INSERT into 0_rbac_teams
On TeamMember add → INSERT into 0_rbac_team_members
On TeamMember remove → Set inactive=1 on 0_rbac_team_members
On Team soft-delete → Set inactive=1 on 0_rbac_teams

### 3.2 Module Registration

ksf_Teams registers with ksfraser/rbac:
- record_types: 'team', 'team_member'
- projections: 'public' (name, description, type, member_count), 'full' (all fields including owner_id, approval_settings, auto_managed)
- allow_invite: true (team owner can invite members)

### 3.3 Access Model

- **Team Owner**: Full control (edit team, manage members, set roles) — PROJECTION_FULL
- **Team Member**: View team details, see member roster — PROJECTION_PUBLIC
- **Non-member**: No visibility (team does not appear in queries)
- **Super Admin**: Can view/modify any team

### 3.4 SQL Enforcement

```sql
JOIN 0_rbac_record_access ra
  ON ra.record_id    = t.id
 AND ra.record_type  = 'team'
 AND ra.module       = 'teams'
 AND ra.inactive     = 0
 AND ra.can_view     = 1
JOIN 0_rbac_team_members tm
  ON tm.team_id  = ra.team_id
 AND tm.user_id  = :currentUserId
 AND tm.inactive = 0
```

### 3.5 Soft Delete

- Teams use soft delete (inactive=1, deleted_by, deleted_at)
- Team membership is inactivated (inactive=1) when a member is removed
- Hard delete is super-admin only, cascades to remove RBAC records

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*
