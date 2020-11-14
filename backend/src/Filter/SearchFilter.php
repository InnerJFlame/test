<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @Annotation
 */
final class SearchFilter extends AbstractContextAwareFilter
{
    /**
     * @param string                      $property
     * @param                             $value
     * @param QueryBuilder                $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string                      $resourceClass
     * @param string|null                 $operationName
     */
    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ) {
        if (!$this->isPropertyEnabled($property, $resourceClass) || !$this->isPropertyMapped($property, $resourceClass)) {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property);
        $search = [];

        foreach ($this->properties as $field => $fieldValue) {
            $search[] = "o.{$field} LIKE :{$parameterName}";
        }

        $queryBuilder->orWhere(implode(' OR ', $search));
        $queryBuilder->setParameter($parameterName, '%' . $value . '%');
    }

    /**
     * @param string $resourceClass
     *
     * @return array
     */
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description[$property] = [
                'property' => $property,
                'type'     => 'string',
                'required' => false,
                'swagger'  => [
                    'description' => 'Filter using a condition OR',
                    'name'        => 'OR Condition Filter',
                ],
            ];
        }

        return $description;
    }
}
