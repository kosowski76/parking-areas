<?php
namespace App\Domain\Entity;

use Symfony\Component\Uid\Uuid;

abstract class Entity
{
    public Uuid $id;

    protected function __construct()
    {
        $this->id = Uuid::v7();
    }
}
