# Functional Requirements - ksf_Teams

## Document Information
- **Module**: ksf_Teams
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Implemented
- **Author**: KSFII Development Team

---

## 1. Overview

### 1.1 Purpose
ksf_Teams provides team management including team creation, member assignment, and team-based workflows.

### 1.2 Scope
- Team CRUD operations
- Member management
- Team types (static/dynamic)
- Skill matching

---

## 2. Core Entities

### 2.1 Team

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| name | string | Yes | Team name |
| description | string | No | Description |
| team_type | enum | Yes | static/dynamic |
| manager_id | string | Yes | Team manager |
| department_id | string | No | Department |
| is_active | bool | Yes | Active status |
| created_at | DateTime | Yes | Auto |
| updated_at | DateTime | Yes | Auto |

### 2.2 TeamMember

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| team_id | string | Yes | FK to Team |
| employee_id | string | Yes | FK to Employee |
| role | string | No | Role in team |
| allocation_percent | int | Yes | 0-100 |
| start_date | Date | No | Start date |
| end_date | Date | No | End date |
| is_active | bool | Yes | Active status |

---

## 3. Functional Requirements

### FR-TEAM-001: Team Management
**Requirement**: System shall create and manage teams.

**Features**:
- Create/edit/delete teams
- Assign team manager
- Set team type (static/dynamic)
- Activate/deactivate teams

### FR-TEAM-002: Member Management
**Requirement**: System shall manage team members.

**Features**:
- Add/remove members
- Set allocation percentage
- Set start/end dates
- Member roles

### FR-TEAM-003: Dynamic Teams
**Requirement**: System shall support dynamic team membership.

**Features**:
- Define membership criteria
- Auto-populate based on skills
- Auto-update on criteria change

### FR-TEAM-004: Team Operations
**Requirement**: System shall perform team operations.

**Features**:
- Get team members
- Get team workload
- Get team skills
- Team capacity planning

### FR-TEAM-005: Team Hierarchy
**Requirement**: System shall support team hierarchies.

**Features**:
- Team of teams
- Manager chain
- Reporting structure

---

## 4. Events

| Event | Trigger |
|-------|---------|
| team.created | New team |
| team.member_added | Member added |
| team.member_removed | Member removed |
| team.updated | Team updated |

---

## 5. RBAC Integration

### FR-TEAM-006: RBAC Integration
**Requirement**: System shall enforce RBAC on team data via ksfraser/rbac.

**Features**:
- Register record types 'team', 'team_member' with RBAC
- Seed 0_rbac_teams and 0_rbac_team_members from Team entities
- Apply RBAC JOIN on all team queries
- Non-members have zero visibility to teams

### FR-TEAM-007: Entity Projections
**Requirement**: System shall use RBAC-aware projections for team data.

**Features**:
- PUBLIC projection: name, description, type, member_count
- FULL projection: owner_id, approval_settings, auto_managed, member_roles
- Team owner sees FULL; members see PUBLIC; non-members see nothing

### FR-TEAM-008: Soft Delete
**Requirement**: System shall soft-delete teams via RBAC inactive flag.

**Features**:
- Team soft-delete sets inactive=1 on 0_rbac_teams
- Team membership inactivated on member removal
- Hard delete cascades to RBAC team records
- Restore operation re-activates RBAC records

### FR-TEAM-009: Audit Trail
**Requirement**: System shall log all RBAC-sensitive team operations.

**Features**:
- Log team creation and membership changes
- Log projection downgrade attempts
- Log soft delete and restore
- Audit trail viewable by super-admin

---

*Document Version: 1.1.0*
*Last Updated: 2026-05-24*