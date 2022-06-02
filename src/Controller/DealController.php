<?php
// src/Controller/DealController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Deal;
use App\Form\DealType;
use App\Service\RandomSlogan;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DealController extends AbstractController
{
    /**
     * @Route("/deal/slogan", name="deal_slogan", methods={"GET"})
     */
    public function sloganAction(RandomSlogan $slogan)
    {
        $slogan = $slogan->getSlogan();
        return $this->render(
            'deal/slogan.html.twig',
            array('slogan' => $slogan)
        );
    }

    /**
     * @Route("/deal/show/{index}", name="deal_show", methods={"GET"}, requirements={"index": "\d+" })
     */
    public function showAction($index)
    {
        return new Response('<html><body>' . $index . '</body></html>');
    }


    /**
     * @Route("/deal/toggle/{id}", name="deal_toggle", methods={"GET"})
     */
    public function toggleEnableAction(ManagerRegistry $doctrine, int $id): Response
    {
        $deal = $doctrine->getRepository(Deal::class)->find($id);

        if (!$deal) {
            throw $this->createNotFoundException('The deal does not exist');
        }

        $deal->setEnable(!$deal->isEnable());
        $doctrine->getManager()->flush();

        return new Response('The ' . $deal->getName() . ' is : ' . (int)$deal->isEnable());
    }

    /**
     * @Route("/dealenable/list", name="dealenable_list", methods={"GET"})
     */
    public function displayListDealEnable(ManagerRegistry $doctrine)
    {
        $deals = $doctrine->getRepository(Deal::class)->findAllDealByEnable();
        $categories = $doctrine->getRepository(Category::class)->findAll();

        return $this->render(
            'deal/index.html.twig',
            array(
                'deals' => $deals,
                'categories' => $categories
            ));
    }

    /**
     * @Route("/deal/form", name="deal_form", methods={"GET","POST"})
     */

    public function dealForm(ManagerRegistry $doctrine, Request $request, LoggerInterface $logger)
    {
        $deal = new Deal();
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Deal $deal */
            $deal = $form->getData();
            $deal->setEnable(1);
            $em = $doctrine->getManager();
            $em->persist($deal);
            $em->flush();
            $logger->info('I love Marie Dubourg');
            $this->addFlash('success', 'Your form was saved!');
            return $this->redirectToRoute('deal_form');
        }

        return $this->render(
            'deal/form.html.twig',
            array('form' => $form->createView())
        );
    }
}