<?php

namespace Ueef\ImageFilters\Filters {

    use Imagick;
    use ImagickDraw;
    use Ueef\Assignable\Traits\AssignableTrait;
    use Ueef\Assignable\Interfaces\AssignableInterface;
    use Ueef\ImageFilters\Interfaces\FilterInterface;

    class Watermark implements AssignableInterface, FilterInterface
    {
        use AssignableTrait;

        /**
         * @var string
         */
        public $text;

        /**
         * @var string
         */
        public $font;

        /**
         * @var integer
         */
        public $font_size;

        /**
         * @var integer
         */
        public $min_height;

        /**
         * @var integer
         */
        public $max_height;


        public function apply(Imagick &$sourceImage)
        {
            $text = $this->text;
            $font = $this->font;
            $fontSize = $this->font_size;

            // максимальная высота блока ватермарка
            $watermarkHeight = $this->max_height;
            $watermarkWidth = $watermarkHeight;

            $imageSize = $sourceImage->getImageGeometry();
            $imageWidth = $imageSize['width'];
            $imageHeight = $imageSize['height'];

            if ($imageHeight <= ($watermarkHeight / 3)) {
                return;
            }

            // если блок атермарка выше изображения - сплющим его
            if ($watermarkHeight > $imageHeight) {
                $watermarkHeight = $imageHeight;
            }

            // Создание объекта Imagick с поддержкой прозрачности
            $watermarkImage = new Imagick();
            $watermarkImage->newImage($watermarkWidth, $watermarkHeight, 'none');

            // Новый объект ImagickDraw для отрисовки эллипса
            $draw = new ImagickDraw();

            $draw->setFont($font);
            $draw->setFontSize($fontSize / 1.2);
            $draw->setTextKerning(1);

            // обводка
            $draw->setStrokeColor('#ccc');
            $draw->setStrokeWidth(6);
            $draw->setStrokeOpacity(.4);

            // для маленьких картинок надо пересчитаь размер влезающего шрифта
            if ($watermarkHeight < $watermarkWidth) {
                $fontSize = $fontSize / 1.5;

                do {
                    $fontSize--;
                    $draw->setFontSize($fontSize);
                    $metrics = $sourceImage->queryFontMetrics($draw, $text);
                } while ($watermarkWidth < $metrics['textWidth'] || $watermarkHeight < $metrics['textHeight']);
            }

            $draw->setGravity(Imagick::GRAVITY_CENTER);

            $draw->rotate($this->getRotateAngle($watermarkHeight, $watermarkWidth));

            $draw->annotation(0, 0, $text);
            $watermarkImage->drawImage($draw);

            // черный
            $draw->setFillColor('#000');
            $draw->setFillOpacity(.1);
            $draw->annotation(0, 0, $text);
            $watermarkImage->drawImage($draw);

            $x = ($imageWidth / 2) - ($watermarkWidth / 2);

            // число блоков ватермарок (которое уместится по высоте картинки)
            $watermarkBlockCount = floor($imageHeight / $watermarkHeight) - 1;
            for ($i = 0; $i <= $watermarkBlockCount; $i++) {
                $y = $watermarkHeight * $i;
                $sourceImage->compositeImage($watermarkImage, Imagick::COMPOSITE_MULTIPLY, $x, $y);
            }

            $draw->destroy();
            $watermarkImage->destroy();
        }


        private function getRotateAngle($height, $width)
        {
            return 0 - (($height == $width ? 35 : 5) + rand(0, 10));
        }
    }
}

