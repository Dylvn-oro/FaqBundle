<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Controller\Frontend;

use Oro\Bundle\LayoutBundle\Attribute\Layout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class FaqController extends AbstractController
{
    #[Layout]
    #[Route(path: '/', name: 'dylvn_faq_frontend_index')]
    public function indexAction(): array
    {
        return [];
    }
}
