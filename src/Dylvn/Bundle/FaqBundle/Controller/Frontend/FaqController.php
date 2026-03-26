<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Controller\Frontend;

use Oro\Bundle\LayoutBundle\Annotation\Layout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    /**
     * @Layout
     * @Route("/", name="dylvn_faq_frontend_index")
     */
    public function indexAction(): array
    {
        return [];
    }
}
