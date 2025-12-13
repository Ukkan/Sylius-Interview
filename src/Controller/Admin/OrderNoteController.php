<?php
namespace App\Controller\Admin;

use App\Form\OrderNoteType;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderNoteController extends AbstractController
{
    #[Route(
        path: '/admin/orders/{id}/note',
        name: 'app_admin_order_note_update',
        methods: ['POST']
    )]
    public function update(
        Request $request,
        OrderRepositoryInterface $orderRepository
    ): Response {

        $order = $orderRepository->find($request->attributes->get('id'));

        if (!$order) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(OrderNoteType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->add($order);

            $this->addFlash('success', 'Order note updated.');
        }

        return $this->redirectToRoute('sylius_admin_order_show', [
            'id' => $order->getId(),
        ]);
    }
}
