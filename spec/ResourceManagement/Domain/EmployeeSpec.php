<?php

namespace spec\Al\ResourceManagement\Domain;

use Al\ResourceManagement\Domain\Employee;
use Al\ResourceManagement\Domain\EmployeeInterface;
use Al\ResourceManagement\Domain\Event\EmployeeFired;
use Al\ResourceManagement\Domain\Event\EmployeeHired;
use Al\ResourceManagement\Domain\Event\EmployeePromoted;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;

class EmployeeSpec extends ObjectBehavior
{
    function let(\DateTime $hiredAt)
    {
        $this->beConstructedThrough('hire', [Uuid::uuid4(), 'name', 'position', 10, $hiredAt]);

        $events = $this->recordedMessages();
        $events->shouldHaveCount(1);
        $events[0]->shouldHaveType(EmployeeHired::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Employee::class);
    }

    function it_is_an_employee()
    {
        $this->shouldImplement(EmployeeInterface::class);
    }

    function it_contains_recorded_message()
    {
        $this->shouldImplement(ContainsRecordedMessages::class);
    }

    function it_can_be_promoted()
    {
        $this->promote('position', 10)->shouldReturn(null);

        $events = $this->recordedMessages();
        $events->shouldHaveCount(2);
        $events[1]->shouldHaveType(EmployeePromoted::class);
    }

    function it_can_be_fired(\DateTime $firedAt)
    {
        $this->fire($firedAt)->shouldReturn(null);

        $events = $this->recordedMessages();
        $events->shouldHaveCount(2);
        $events[1]->shouldHaveType(EmployeeFired::class);
    }
}
