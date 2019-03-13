<?php
declare(strict_types=1);

namespace Ueef\ImageFilters\Filters;

use Imagick;
use Ueef\ImageFilters\Interfaces\FilterInterface;

class QualityFilter implements FilterInterface
{
    /** @var integer */
    public $quality;


    public function __construct(int $quality)
    {
        $this->quality = $quality;
    }

    public function apply(Imagick &$image)
    {
        $image->setImageCompressionQuality($this->quality);
    }
}

