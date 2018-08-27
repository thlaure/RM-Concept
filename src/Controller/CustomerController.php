<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\Customer;
use App\Entity\ShoppingCartProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CustomerController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class CustomerController extends AbstractController
{
    /**
     * Affiche la page des clients.
     *
     * @Route("/admin/customer", name="admin_customer")
     *
     * @return Response
     */
    public function customer(): ?Response
    {
        $customers = $this->findAllCustomers();
        return $this->render('customer/customer.html.twig', array(
            'customers' => $customers
        ));
    }

    /**
     * Affiche les commands du client dont la référence est passée dans l'URL.
     *
     * @Route("/admin/customer/{reference}/commands", name="customer_commands")
     *
     * @param string $reference
     *
     * @return Response
     */
    public function customerCommands(string $reference): ?Response
    {
        $customer = $this->findOneCustomerByReference($reference);
        $commands = $this->findCommandsByCustomer($customer);
        return $this->render('customer/customer_commands.html.twig', array(
            'commands' => $commands
        ));
    }

    /**
     * Affiche la liste des produits contenus dans le panier de la commande dont la référence est dans l'URL.
     *
     * @Route("/admin/customer/command/{reference}", name="command_products")
     *
     * @param string $reference Référence de la commande.
     *
     * @return null|Response
     */
    public function commandProducts(string $reference): ?Response
    {
        $command = $this->findOneCommandByReference($reference);
        $shoppingCartProducts = $this->findShoppingCartProductsByCommand($command);
        return $this->render('customer/customer_command_products.html.twig', array(
            'shopping_cart_products' => $shoppingCartProducts,
            'command' => $command
        ));
    }

    /**
     * Renvoie un tableau de données contenant tous les clients en base de données.
     *
     * @return array
     */
    private function findAllCustomers(): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Customer::class);
        $result = $repository->findAll();
        return $result;
    }

    /**
     * Renvoie un tableau de données contenant toutes les commandes payées du client passé en paramètre.
     *
     * @param Customer $customer Client à qui appartiennent les commandes.
     *
     * @return array
     */
    private function findCommandsByCustomer(Customer $customer): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Command::class);
        $result = $repository->findBy(array(
            'customer' => $customer,
            'isPaid' => true
        ));
        return $result;
    }

    /**
     * Renvoie le client dont la référence est passée en paramètre.
     *
     * @param string $reference Référence du client à récupérer dans la base de données.
     *
     * @return Customer|null
     */
    private function findOneCustomerByReference(string $reference): ?Customer
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Customer::class);
        $result = $repository->findOneBy(array(
            'reference' => $reference
        ));
        return $result;
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

    /**
     * Renvoie la commande dont la référence est passée en paramètre.
     *
     * @param string $reference Référence de la commande à extraire.
     *
     * @return Command|null
     */
    private function findOneCommandByReference(string $reference): ?Command
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Command::class);
        $result = $repository->findOneBy(array(
            'reference' => $reference
        ));
        return $result;
    }
}