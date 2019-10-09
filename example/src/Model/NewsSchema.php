<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Model;

use App\Entity;
use Devigner\KunstmaanApiBundle\Model\AbstractJsonApi;
use Devigner\KunstmaanApiBundle\Model\ModelSchemaInterface;
use JMS\Serializer\Annotation as JMS;
use Kunstmaan\NodeBundle\Entity\Node;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class NewsSchema extends AbstractJsonApi implements ModelSchemaInterface
{
    /**
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("App\Model\Pages\NewsPage")
     * @OA\Property(ref="#/components/schemas/NewsPage")
     */
    protected $data;

    /**
     * @param Entity\Pages\NewsPage $entity
     * @param Node $node
     * @param string $locale
     */
    public function __construct(Entity\Pages\NewsPage $entity, Node $node, string $locale)
    {
        $model = $entity->getModel();
        $model->addNode($node, $locale);
        $this->addData($model);

        parent::__construct();
    }
}
