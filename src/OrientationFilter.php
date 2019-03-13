<?php
declare(strict_types=1);

namespace Ueef\ImageFilters\Filters;

use Imagick;
use Ueef\ImageFilters\Interfaces\FilterInterface;

class OrientationFilter implements FilterInterface
{
    public function apply(Imagick &$image)
    {
        switch ($image->getImageProperty('exif:Orientation')) {
            case 3:
                $image->rotateImage('#000000', 180);
                $image->stripImage();
                break;

            case 6:
                $image->rotateImage('#000000', 90);
                $image->stripImage();
                break;

            case 8:
                $image->rotateImage('#000000', -90);
                $image->stripImage();
                break;
        }
    }
}

