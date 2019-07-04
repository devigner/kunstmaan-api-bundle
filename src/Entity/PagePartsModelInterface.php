<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Entity;

use Devigner\KunstmaanApiBundle\Model;

interface PagePartsModelInterface
{
    /**
     * @return Model\PagePartsEntityInterface
     */
    public function getModel(): Model\PagePartsEntityInterface;
}
