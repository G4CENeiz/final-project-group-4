<?php

namespace Repository;

use Primitives\Models\Room;
use RepositoryInterfaces\IRoomRepository;

class RoomRepository implements IRoomRepository
{
    public function __construct(private readonly MssqlClient $mssqlClient)
    {
    }

    public function getAll(): array
    {
        $rooms = $this->mssqlClient->executeQuery("
            SELECT
                Id,
                Code,
                Name,
                Floor,
                Capacity,
                Side,
                Image
            FROM
                dbo.Room
        ");

        return array_map(fn($room) => Room::fromArray($room), $rooms);
    }

    public function getById(int $id): Room
    {
        $row = $this->mssqlClient->executeQuery("
            SELECT
                Id,
                Code,
                Name,
                Floor,
                Capacity,
                Side,
                Image
            FROM
                dbo.Room
            WHERE
                ID = $id
        ")[0];

        return Room::fromArray($row);
    }

    public function search(string $query): array
    {
        $rooms = $this->mssqlClient->executeQuery("
            SELECT
                Id,
                Code,
                Name,
                Floor,
                Capacity,
                Side,
                Image
            FROM
                dbo.Room
            WHERE
                Name LIKE CONCAT('%', :name, '%') OR
                Code LIKE CONCAT('%', :code, '%') OR
                Side = :side
        ", [
            'name' => $query,
            'code' => $query,
            'side' => $query
        ]);

        return array_map(fn($room) => Room::fromArray($room), $rooms);
    }

    public function create(Room $room): Room
    {
        $this->mssqlClient->executeNonQuery("
            INSERT INTO dbo.Room (Code, Name, Floor, Capacity, Side, Image)
            VALUES (:code, :name, :floor, :capacity, :side, :image)
        ", [
            'code' => $room->getCode(),
            'name' => $room->getName(),
            'floor' => $room->getFloor(),
            'capacity' => $room->getCapacity(),
            'side' => $room->getSide(),
            'image' => $room->getImage()
        ]);
        return $this->getById($this->mssqlClient->getLastInsertedId());
    }

    public function update(Room $room): Room
    {
        $this->mssqlClient->executeNonQuery("
            UPDATE dbo.Room
            SET 
                Code = :code, 
                Name = :name, 
                Floor = :floor,
                Capacity = :capacity,
                Side = :side,
                Image = :image
            WHERE Id = :id
        ", [
            'id' => $room->getId(),
            'code' => $room->getCode(),
            'name' => $room->getName(),
            'floor' => $room->getFloor(),
            'capacity' => $room->getCapacity(),
            'side' => $room->getSide(),
            'image' => $room->getImage()
        ]);

        return $room;
    }

    public function delete(int $id): void
    {
        $this->mssqlClient->executeNonQuery("
            DELETE FROM dbo.Room
            WHERE ID = :id
        ", [
            'id' => $id
        ]);
    }

    public function getCount(): int
    {
        return $this->mssqlClient->executeQuery("
            SELECT COUNT(*) AS Count
            FROM dbo.Room
        ")[0]['Count'];
    }
}