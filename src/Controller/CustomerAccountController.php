<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\ShoppingCartProduct;
use App\Service\EntityManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class CustomerAccountController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class CustomerAccountController extends AbstractController
{
    /**
     * Affiche la page du compte client.
     *
     * @Route("/customer/account", name="customer_account")
     *
     * @param Security $security
     * @param EntityManipulation $entityManipulation
     *
     * @return Response
     */
    public function account(Security $security, EntityManipulation $entityManipulation): ?Response
    {
        $customer = $security->getUser();
        $commands = $entityManipulation->findCommandsByCustomer($customer);
        return $this->render('customer_account/customer_account.html.twig', array(
            'customer' => $customer,
            'commands' => $commands
        ));
    }

    /**
     * Affiche le détail de la commande choisie.
     *
     * @Route("/customer/account/command/{reference}", name="customer_account_command")
     *
     * @param string $reference Référence de la commande dont on veut afficher le détail.
     * @param EntityManipulation $entityManipulation
     *
     * @return Response
     */
    public function customerCommand(string $reference, EntityManipulation $entityManipulation): ?Response
    {
        $command = $entityManipulation->findOneCommandByReference($reference);
        $shoppingCartProducts = $this->findShoppingCartProductsByCommand($command);
        return $this->render('customer_account/customer_command_products.html.twig', array(
            'shopping_cart_products' => $shoppingCartProducts,
            'command' => $command
        ));
    }

    /**
     * Renvoie un tableau de données contenant les produits contenus dans le panier lié à la commande passée en paramètre.
     *
     * @param Command $command Commande pour laquelle il faut récupérer tous les produits.
     *
     * @return array
     */
    private function findShoppingCartProductsByCommand(Command $command): array
    {
        $shoppingCart = $command->getShoppingCart();
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findBy(array(
            'shoppingCart' => $shoppingCart
        ));
        return $result;
    }
}