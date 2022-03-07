<?php

namespace App\Controller;

use App\Manager\ExceptionUpdatingResource;
use App\Manager\PersonManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/persona", name="app_person_")
 */
class PersonController extends AbstractController
{
    protected PersonManager $manager;

    public function __construct(PersonManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     */
    public function update(int $id, Request $request): Response
    {

        try {
            return $this->json(
                $this->manager->update($id, json_decode($request->getContent(), true)),
                Response::HTTP_CREATED
            );
        } catch (ExceptionUpdatingResource $exception) {
            return $this->json(
                [
                    'errors' => $exception->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
