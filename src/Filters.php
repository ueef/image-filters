<?php

namespace Ueef\ImageFilters {

    use Imagick;
    use Ueef\Assignable\Traits\AssignableTrait;
    use Ueef\Assignable\Interfaces\AssignableInterface;
    use Ueef\ImageFilters\Exceptions\Exception;
    use Ueef\ImageFilters\Interfaces\ImageFilterInterface;

    class Filters implements AssignableInterface
    {
        use AssignableTrait;

        /**
         * @var ImageFilterInterface[]
         */
        private $filters = [];

        public function apply(Imagick &$image, array $filters)
        {
            foreach ($filters as &$filter) {
                if (!array_key_exists($filter, $this->filters)) {
                    throw new Exception('Undefined filter: ' . $filter);
                }

                $filter = $this->filters[$filter];
            }

            foreach ($filters as &$filter) {
                $filter->apply($image);
            }
        }
    }
}