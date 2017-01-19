<?php

namespace Ueef\ImageFilters\Filters\Text {

    use Imagick;
    use ImagickDraw;
    use Ueef\Assignable\Traits\AssignableTrait;
    use Ueef\Assignable\Interfaces\AssignableInterface;
    use Ueef\ImageFilters\Interfaces\ImageFilterInterface;

    class Top implements AssignableInterface, ImageFilterInterface
    {
        use AssignableTrait;

        /**
         * @var string
         */
        public $font;

        /**
         * @var integer
         */
        public $font_size;

        /**
         * @var string
         */
        public $text;

        /**
         * @var string
         */
        public $text_color;

        /**
         * @var string
         */
        public $background_color;


        public function apply(Imagick &$sourceImage)
        {
            $font = $this->font;
            $fontSize = $this->font_size;

            $text = $this->text;
            $textColor = $this->text_color;
            $backgroundColor = $this->background_color;

            $height = $fontSize + 2;

            $imageSize = $sourceImage->getImageGeometry();
            $imageWidth = $imageSize['width'];
            $imageHeight = $imageSize['height'];

            // большая подложка
            $textImage = new Imagick();
            $textImage->newImage($imageWidth, ($imageHeight + $height), $backgroundColor);

            $draw = new ImagickDraw();

            $draw->setFont($font);
            $draw->setFontSize($fontSize);
            $draw->setFillColor($textColor);
            $draw->setTextKerning(1);
            $draw->setGravity(Imagick::GRAVITY_NORTH);

            // верхний текст
            $draw->annotation(0, 0, $text);
            $textImage->drawImage($draw);
            $draw->destroy();

            // на подложку с текстами сверху-снизу накладываем оригинальную картинку
            $textImage->compositeImage($sourceImage, Imagick::COMPOSITE_MULTIPLY, 0, $height);
            $textImage->setImageFormat($sourceImage->getImageFormat());

            $sourceImage->destroy();
            $sourceImage = $textImage;
        }
    }
}

