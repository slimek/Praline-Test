<?php
namespace Models;

use Praline\Session\SessionDataInterface;

class UserInfo implements SessionDataInterface
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getUniqueKey(): string
    {
        return strval($this->id);
    }

    public function getDescription(): string
    {
        return 'userId(' . strval($this->id) . ')';
    }
}
