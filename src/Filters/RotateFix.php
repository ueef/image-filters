<?php

namespace Ueef\ImageFilters\Filters {

    use Imagick;
    use Ueef\ImageFilters\Interfaces\FilterInterface;

    class RotateFix implements FilterInterface
    {
        public function apply(Imagick &$sourceImage)
        {
            $orientation = $sourceImage->getImageProperty('exif:Orientation');

            if (!empty($orientation)) {
                switch ($orientation) {
                    case 3:
                        $sourceImage->rotateImage('#000000', 180);
                        $sourceImage->stripImage();
                        break;

                    case 6:
                        $sourceImage->rotateImage('#000000', 90);
                        $sourceImage->stripImage();
                        break;

                    case 8:
                        $sourceImage->rotateImage('#000000', -90);
                        $sourceImage->stripImage();
                        break;
                }
            }
        }
    }
}

