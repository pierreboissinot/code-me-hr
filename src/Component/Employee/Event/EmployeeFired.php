<?php

namespace Al\Component\Employee\Event;

use SimpleBus\Message\Name\NamedMessage;

final class EmployeeFired implements NamedMessage
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $position;

    public function __construct(string $id, string $name, string $position)
    {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getEmployeeId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmployeeName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmployeePosition(): string
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public static function messageName()
    {
        return 'employee_fired';
    }
}