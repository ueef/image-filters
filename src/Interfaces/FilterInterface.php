<?php

namespace Ueef\ImageFilters\Interfaces {

    use Imagick;

    interface FilterInterface
    {
        public function apply(Imagick &$sourceImage);
    }
}

