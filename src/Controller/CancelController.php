<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\ShoppingCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CancelController extends AbstractController
{
    /**
     * Annule une commande.
     *
     * @Route("/cancel", name="cancel")
     *
     * @param Security $security
     *
     * @return Response
     */
    public function cancel(Security $security): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $this->findShoppingCartNotConfirmed($customer);
        $command = $shoppingCart->getCommand();
        $this->removeObject($command);
        return $this->render('shopping_cart/shopping_cart.html.twig', array(
            'total_price' => $shoppingCart->getTotalPrice()
        ));
    }

    /**
     * Renvoie le panier non confirmé du client passé en paramètre.
     *
     * @param Customer $customer Client lié au panier.
     *
     * @return ShoppingCart|null
     */
    private function findShoppingCartNotConfirmed(Customer $customer): ?ShoppingCart
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCart::class);
        $result = $repository->findOneBy(array(
            'customer' => $customer,
            'isConfirmed' => false
        ));
        return $result;
    }

    /**
     * Supprime une entité en base de données.
     *
     * @param ? $object Objet à supprimer.
     */
    private function removeObject($object): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($object);
        $entityManager->flush();
    }
}