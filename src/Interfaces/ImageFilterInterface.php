<?php

namespace Ueef\ImageFilters\Interfaces {

    use Imagick;

    interface ImageFilterInterface
    {
        public function apply(Imagick &$sourceImage);
    }
}

