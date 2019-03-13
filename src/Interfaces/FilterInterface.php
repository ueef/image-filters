<?php
declare(strict_types=1);

namespace Ueef\ImageFilters\Interfaces;

use Imagick;

interface FilterInterface
{
    public function apply(Imagick &$image);
}

