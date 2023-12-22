<?php

namespace Primitives\Models;

class Approval
{
    public function __construct(
        private User           $user,
        private ApprovalStatus $status,
        private ?int           $previousApproverId,
        private ?int           $nextApproverId,
        private ?string        $reason,
    )
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getStatus(): ApprovalStatus
    {
        return $this->status;
    }

    public function setStatus(ApprovalStatus $status): void
    {
        $this->status = $status;
    }

    public function getPreviousApproverId(): ?int
    {
        return $this->previousApproverId;
    }

    public function setPreviousApproverId(?int $previousApproverId): void
    {
        $this->previousApproverId = $previousApproverId;
    }

    public function getNextApproverId(): ?int
    {
        return $this->nextApproverId;
    }

    public function setNextApproverId(?int $nextApproverId): void
    {
        $this->nextApproverId = $nextApproverId;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
    }
}