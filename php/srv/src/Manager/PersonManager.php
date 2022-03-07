<?php

namespace App\Manager;

use App\Entity\Person;
use App\Repository\PersonRepository;
use DateTime;

class PersonManager
{

    protected PersonRepository $repository;

    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }


    public function update(int $id, $data): array
    {
        $entity = $this->repository->findOneBy(['id' => $id]);

        try {
            $entity = $this->fromArray($data, $entity);
        } catch (\Exception $e) {
            throw new ExceptionUpdatingResource($e->getMessage());
        }

        $this->repository->add($entity);

        return $this->toArray($entity);
    }

    protected function toArray(Person $person)
    {
        return [
            'name' => $person->getName(),
            'birthday' => $person->getBirthday()->format('Y/m/d'),
        ];
    }

    protected function fromArray(array $data, Person $entity) : Person
    {

        if (isset($data['name'])) {
            $entity->setName($data['name']);
        }

        if (isset($data['birthday'])) {
            $entity->setBirthday(new DateTime($data['birthday']));
        }

        return $entity;
    }
}
