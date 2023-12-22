<?php

namespace Primitives\Models;

use DateTime;
use Exception;

class Event
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $startsAt
     * @param DateTime $endsAt
     * @param Room $room
     * @param User $pic
     * @param Approval[] $approvers
     */
    public function __construct(
        private int      $id,
        private string   $title,
        private string   $description,
        private DateTime $startsAt,
        private DateTime $endsAt,
        private Room     $room,
        private User     $pic,
        private array    $approvers,
    )
    {
    }

    public function isApproved(): bool
    {
        foreach ($this->approvers as $approver) {
            if ($approver->getStatus()->value != ApprovalStatus::Approved) {
                return false;
            }
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public static function fromArray(array $data, array $approvers): Event
    {
        $hasApprover = array_key_exists('ApproverId', $data) && $data['ApproverId'] != null;
        return new Event(
            id: $data['Id'],
            title: $data['Title'],
            description: $data['Description'],
            startsAt: new DateTime($data['StartsAt']),
            endsAt: new DateTime($data['EndsAt']),
            room: new Room(
                id: $data['RoomId'],
                code: $data['RoomCode'],
                name: $data['RoomName'],
                floor: $data['RoomFloor'],
                capacity: $data['RoomCapacity'],
                side: $data['RoomSide'],
                image: $data['RoomImage'],
            ),
            pic: new User(
                id: $data['PicId'],
                registrationNumber: $data['PicRegistrationNumber'],
                fullname: $data['PicFullName'],
                username: $data['PicUsername'],
                password: null,
                email: $data['PicEmail'],
                phone: $data['PicPhone'],
                avatar: $data['PicAvatar'],
                role: RoleName::from($data['PicRole']),
            ),
            approvers: !$hasApprover ? [] : array_map(fn($approver) => new Approval(
                user: new User(
                    id: $approver['ApproverId'],
                    registrationNumber: $approver['ApproverRegistrationNumber'],
                    fullname: $approver['ApproverFullName'],
                    username: $approver['ApproverUsername'],
                    password: null,
                    email: $approver['ApproverEmail'],
                    phone: $approver['ApproverPhone'],
                    avatar: $approver['ApproverAvatar'],
                    role: RoleName::from($approver['ApproverRole']),
                ),
                status: ApprovalStatus::from($approver['Status']),
                previousApproverId: $approver['BeforeUserId'],
                nextApproverId: $approver['AfterUserId'],
                reason: $approver['Reason'],
            ), $approvers),
        );
    }

    public function getStatus(int $id): ApprovalStatus
    {
        foreach ($this->approvers as $approver) {
            if ($approver->getUser()->getId() == $id) {
                return $approver->getStatus();
            }
        }
        return ApprovalStatus::Unknown;
    }

    /**
     * @throws Exception
     */
    public function updateWith(array $event): void
    {
        if (isset($event['title']) && $event['title'] !== '') {
            $this->title = $event['title'];
        }

        if (isset($event['description']) && $event['description'] !== '') {
            $this->description = $event['description'];
        }

        if (isset($event['startsAt']) && $event['startsAt'] !== '') {
            $this->startsAt = new DateTime($event['startsAt']);
        }

        if (isset($event['endsAt']) && $event['endsAt'] !== '') {
            $this->endsAt = new DateTime($event['endsAt']);
        }

        if (isset($event['roomId']) && $event['roomId'] !== '') {
            $this->room->setId($event['roomId']);
        }

        if (isset($event['picId']) && $event['picId'] !== '') {
            $this->pic->setId($event['picId']);
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStartsAt(): DateTime
    {
        return $this->startsAt;
    }

    public function setStartsAt(DateTime $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getEndsAt(): DateTime
    {
        return $this->endsAt;
    }

    public function setEndsAt(DateTime $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }

    public function getPic(): User
    {
        return $this->pic;
    }

    public function setPic(User $pic): void
    {
        $this->pic = $pic;
    }

    public function getApprovers(): array
    {
        return $this->approvers;
    }

    public function setApprovers(array $approvers): void
    {
        $this->approvers = $approvers;
    }
}