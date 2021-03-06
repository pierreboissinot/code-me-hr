<?php
declare(strict_types=1);

/*
 * This file is part of the AL labs package
 *
 * (c) Arnaud Langlade
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Al\ResourceManagement\Infrastructure\Persistence\Doctrine;

use Al\ResourceManagement\Domain\Employee;
use Al\ResourceManagement\Domain\EmployeeInterface;
use Al\ResourceManagement\Domain\EmployeeRepositoryInterface;
use Al\ResourceManagement\Domain\Exception\NotExistingEmployee;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class EmployeeRepository implements EmployeeRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function get(UuidInterface $identifier): EmployeeInterface
    {
        if (null === $employee = $this->entityManager->find(Employee::class, (string) $identifier->toString())) {
            throw new NotExistingEmployee((string) $identifier->toString());
        }

        return $employee;
    }

    /**
     * {@inheritdoc}
     */
    public function add(EmployeeInterface $employee)
    {
        $this->entityManager->persist($employee);
        $this->entityManager->flush($employee);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EmployeeInterface $employee)
    {
        $this->entityManager->remove($employee);
        $this->entityManager->flush($employee);
    }
}
