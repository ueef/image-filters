<?php
declare(strict_types=1);

namespace Ueef\ImageFilters;

use Imagick;
use Ueef\ImageFilters\Interfaces\FilterInterface;

class ScaleFilter implements FilterInterface
{
    /** @var integer */
    public $width;

    /** @var integer */
    public $height;

    /** @var bool */
    public $best_fit;


    public function __construct(int $width, int $height, bool $bestFit)
    {
        $this->width = $width;
        $this->height = $height;
        $this->best_fit = $bestFit;
    }

    public function apply(Imagick &$image)
    {
        $size = $image->getImageGeometry();

        if (($this->width && $size['width'] > $this->width) || ($this->height && $size['height'] > $this->height)) {
            $image->scaleImage($this->width, $this->height, $this->best_fit);
        }
    }
}

