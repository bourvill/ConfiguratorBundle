<?php

namespace Dw\Bundle\ConfiguratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/hello")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->get('dw_configurator.form')->getForm($this->get('dw_configurator.config.example'));

        if ($request->isMethod('POST')) {
           $form->handleRequest($request);

            if ($form->isValid()) {
                $this->get('dw_configurator.configurator')->update($form->getData());
            }
        }

        return array('form' => $form->createView());
    }
}
