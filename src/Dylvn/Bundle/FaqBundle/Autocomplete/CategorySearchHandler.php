<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Autocomplete;

use Oro\Bundle\EntityBundle\Provider\EntityNameResolver;
use Oro\Bundle\FormBundle\Autocomplete\SearchHandler;

class CategorySearchHandler extends SearchHandler
{
    private EntityNameResolver $entityNameResolver;

    public function __construct($entityName, array $properties, EntityNameResolver $entityNameResolver)
    {
        parent::__construct($entityName, $properties);
        $this->entityNameResolver = $entityNameResolver;
    }

    public function convertItem($item): array
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
