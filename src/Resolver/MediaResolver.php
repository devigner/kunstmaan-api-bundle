<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Resolver;

use Kunstmaan\MediaBundle\Entity\Media as KumaMedia;

class MediaResolver
{
    /**
     * @param KumaMedia|null $media
     * @return string|null
     */
    public static function createPublicUrl(?KumaMedia $media): ?string
    {
        if (null === $media) {
            return null;
        }

        return sprintf('%s%s', $_ENV['BACKEND_HOST'], $media->getUrl());
    }
}
