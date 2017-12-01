<?php

namespace AppBundle\Controller;

use AppBundle\Services\StripeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/charge", name="charge_simple")
     * @Method({"POST"})
     */
    public function chargeAction(Request $request)
    {
        $params = $request->request->all();
        if (!isset($params['stripeToken'])) {
            return new BadRequestHttpException('No stripe token to create charge');
        }

        $charge = $this->container->get(StripeService::class)->charge($params['stripeToken']);

        $amount = $charge->amount / 100; // Amount is in cents

        $this->addFlash(
            'notice',
            "Charge of $amount € successful !"
        );

        return $this->redirectToRoute('homepage');
    }
}
