<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Pet;
use App\Entity\Status;
use App\Form\PetType;

/**
 * @Route("/pet")
 */
class PetController extends AbstractController
{
    /**
     * @Route("", name="pet_listing", methods={"GET"})
     */
    public function list()
    {
        $pets = $this->getDoctrine()
            ->getRepository(Pet::class)
            ->findAll();

        return new JsonResponse($pets);
    }

    /**
     * @Route("", name="create_pet", methods={"POST"})
     */
    public function create(Request $request)
    {
        $pet = new Pet();
        $form = $this->createForm(PetType::class, $pet);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pet);
            $entityManager->flush();

            return new JsonResponse($pet);
        }

        // 405 seems like an odd response code, but it's in the swagger
        return new JsonResponse(['error' => 'Invalid input'], Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * @Route("/findByStatus", name="pets_by_status", methods={"GET"})
     */
    public function petsByStatus(Request $request)
    {
        $statusName = $request->query->get('status');
        $status = $this->getDoctrine()
            ->getRepository(Status::class)
            ->findOneBy(['name' => $statusName]);

        if (!$status) {
            return new JsonResponse(['error' => 'Invalid status value'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($status->getPets()->toArray());
    }

    /**
     * @Route("/{id}", name="pet_by_id", methods={"GET"})
     */
    public function show(Pet $pet)
    {
        return new JsonResponse($pet);
    }
}
