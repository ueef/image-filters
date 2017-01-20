<?php

namespace Ueef\ImageFilters\Filters {

    use Imagick;
    use Ueef\Assignable\Interfaces\AssignableInterface;
    use Ueef\Assignable\Traits\AssignableTrait;
    use Ueef\ImageFilters\Interfaces\FilterInterface;

    class Loupe implements AssignableInterface, FilterInterface
    {
        use AssignableTrait;

        /**
         * @var string
         */
        private $foreground_image;


        public function apply(Imagick &$sourceImage)
        {
            $sourceImage->blurImage(3, 6);

            $sourceWidth = $sourceImage->getImageWidth();
            $sourceHeight = $sourceImage->getImageHeight();

            $curtainImage = new Imagick();
            $wapWidth = $sourceWidth;
            $wapHeight = $sourceHeight;

            $curtainImage->newImage($wapWidth, $wapHeight, '#fefefe80');
            $curtainImage->setImageFormat('png');

            $loupeImage = new Imagick($this->foreground_image);
            $loupeSize = $loupeImage->getImageWidth();

            $sourceMinSize = min($sourceWidth, $sourceHeight);
            if ($loupeSize >= ($sourceMinSize-20)) {
                $loupeSize = $sourceMinSize-20;
                $loupeImage->scaleImage($loupeSize, $loupeSize, true);
            }

            $curtainImage->compositeImage($loupeImage, Imagick::COMPOSITE_COLORBURN, floor(($sourceWidth/2) - ($loupeSize/2)), floor(($sourceHeight/2) - ($loupeSize/2)));
            $loupeImage->destroy();

            $sourceImage->compositeImage($curtainImage, Imagick::COMPOSITE_DEFAULT, 0, 0);
            $curtainImage->destroy();
        }
    }
}

