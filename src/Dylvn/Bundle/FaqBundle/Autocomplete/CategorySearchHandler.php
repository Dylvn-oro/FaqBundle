<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Autocomplete;

use Oro\Bundle\FormBundle\Autocomplete\SearchHandler;

class CategorySearchHandler extends SearchHandler
{
    public function convertItem($item)
    {
        $result = [];

        if ($this->idFieldName) {
            $result[$this->idFieldName] = $this->getPropertyValue($this->idFieldName, $item);
        }

        foreach ($this->getProperties() as $property) {
            if ($property === 'name') {
                $result[$property] = $this->entityNameResolver->getName($item);
            } else {
                $result[$property] = (string)$this->getPropertyValue($property, $item);
            }
        }

        return $result;
    }
}
