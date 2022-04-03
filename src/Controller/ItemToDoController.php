<?php

namespace App\Controller;

use App\Entity\ItemToDo;
use App\Form\ItemToDoType;
use App\Repository\ItemToDoRepository;
use App\Repository\ToDoListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/item/to/do')]
class ItemToDoController extends AbstractController
{
    #[Route('/', name: 'item_to_do_index', methods: ['GET'])]
    public function index(ItemToDoRepository $itemToDoRepository): Response
    {
        return $this->render('item_to_do/index.html.twig', [
            'item_to_dos' => $itemToDoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'item_to_do_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemToDo = new ItemToDo();

        $form = $this->createForm(ItemToDoType::class, $itemToDo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemToDo);
            $entityManager->flush();

            return $this->redirectToRoute('item_to_do_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item_to_do/new.html.twig', [
            'item_to_do' => $itemToDo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'item_to_do_show', methods: ['GET'])]
    public function show(ItemToDo $itemToDo): Response
    {
        return $this->render('item_to_do/show.html.twig', [
            'item_to_do' => $itemToDo,
        ]);
    }

    #[Route('/{id}/edit', name: 'item_to_do_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemToDo $itemToDo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemToDoType::class, $itemToDo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('item_to_do_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item_to_do/edit.html.twig', [
            'item_to_do' => $itemToDo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'item_to_do_delete', methods: ['POST'])]
    public function delete(Request $request, ItemToDo $itemToDo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemToDo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($itemToDo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_to_do_index', [], Response::HTTP_SEE_OTHER);
    }

    public function validateNameUniqueInToDoList (ToDoListRepository $toDoListRepository, ItemToDo $item) {
        $items = $toDoListRepository->findBy("name == $item->name");
        if (count($items) > 0) {
            return false;
        }
        else {
            return true;
        }
    }


}
