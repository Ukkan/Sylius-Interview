<?php
namespace App\Controller\Admin;

use App\Entity\OrderNote;
use App\Form\Type\OrderNoteType;
use App\Repository\OrderNoteRepository;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderNoteController extends AbstractController
{
    #[Route('/admin/orders/{id}/note', name: 'admin_order_note_edit', methods: ['GET','POST'])]
    public function edit(
        int $id,
        Request $request,
        OrderRepositoryInterface $orderRepository,
        OrderNoteRepository $orderNoteRepository,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // lub ROLE_SYLIUS_ADMIN

        $order = $orderRepository->find($id);
        if (!$order) {
            throw $this->createNotFoundException();
        }

        $orderNote = $orderNoteRepository->findOneBy(['order' => $order]) ?? new OrderNote();
        $orderNote->setOrder($order);

        $form = $this->createForm(OrderNoteType::class, ['note' => $orderNote->getNote()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $noteText = $data['note'] ?? null;

            if (empty($noteText) && $orderNote->getId()) {
                $em->remove($orderNote); // usuwamy notatkę gdy pole puste
            } elseif (!empty($noteText)) {
                $orderNote->setNote($noteText);
                $em->persist($orderNote);
            }
            $em->flush();

            $this->addFlash('success', 'Notatka została zapisana.');
            return $this->redirectToRoute('sylius_admin_order_show', ['id' => $id]);
        }

        return $this->render('admin/order/note_form.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
            'orderNote' => $orderNote->getId() ? $orderNote : null,
        ]);
    }
}
