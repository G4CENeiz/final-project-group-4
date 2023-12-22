<?php

namespace Primitives\Models;

class Room
{
    public function __construct(
        private ?int   $id,
        private string $code,
        private string $name,
        private int    $floor,
        private int    $capacity,
        private string $side,
        private string $image,
    )
    {
    }

    public static function fromArray(array $room): Room
    {
        return new Room(
            id: $room['Id'],
            code: $room['Code'],
            name: $room['Name'],
            floor: $room['Floor'],
            capacity: $room['Capacity'],
            side: $room['Side'],
            image: $room['Image'],
        );
    }

    public function updateWith(array $room): Room
    {
        if (isset($room['code']) && $room['code'] !== '') {
            $this->code = $room['code'];
        }

        if (isset($room['name']) && $room['name'] !== '') {
            $this->name = $room['name'];
        }

        if (isset($room['floor'])) {
            $this->floor = $room['floor'];
        }

        if (isset($room['capacity'])) {
            $this->capacity = $room['capacity'];
        }

        if (isset($room['side']) && $room['side'] !== '') {
            $this->side = $room['side'];
        }

        if (isset($room['image']) && $room['image'] !== '') {
            $this->image = $room['image'];
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFloor(): int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): void
    {
        $this->floor = $floor;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function setSide(string $side): void
    {
        $this->side = $side;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
}