<?php

namespace Ueef\ImageFilters\Filters {

    use Imagick;
    use Ueef\Assignable\Traits\AssignableTrait;
    use Ueef\Assignable\Interfaces\AssignableInterface;
    use Ueef\ImageFilters\Interfaces\ImageFilterInterface;

    class Resize implements AssignableInterface, ImageFilterInterface
    {
        use AssignableTrait;

        /**
         * @var integer
         */
        public $width;

        /**
         * @var integer
         */
        public $height;

        /**
         * @var bool
         */
        public $best_fit;


        public function apply(Imagick &$sourceImage)
        {
            $imageSize = $sourceImage->getImageGeometry();

            if (($this->width && $imageSize['width'] > $this->width) || ($this->height && $imageSize['height'] > $this->height)) {
                $sourceImage->scaleImage($this->width, $this->height, $this->best_fit);
            }
        }
    }
}

