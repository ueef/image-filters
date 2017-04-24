<?php

namespace Ueef\ImageFilters\Filters {

    use Imagick;
    use Ueef\Assignable\Traits\AssignableTrait;
    use Ueef\Assignable\Interfaces\AssignableInterface;
    use Ueef\ImageFilters\Interfaces\FilterInterface;

    class Quality implements AssignableInterface, FilterInterface
    {
        use AssignableTrait;

        /**
         * @var integer
         */
        public $quality;

        public function apply(Imagick &$sourceImage)
        {
            $imageCompressionQuality = $sourceImage->getImageCompressionQuality();

            if ($this->quality && $imageCompressionQuality > $this->quality) {
                $sourceImage->setImageCompressionQuality($this->quality);
            }
        }
    }
}

