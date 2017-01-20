<?php

namespace Ueef\ImageFilters {

    use Imagick;
    use Ueef\Assignable\Traits\AssignableTrait;
    use Ueef\Assignable\Interfaces\AssignableInterface;
    use Ueef\ImageFilters\Exceptions\Exception;
    use Ueef\ImageFilters\Interfaces\FilterInterface;

    class Filters implements AssignableInterface
    {
        use AssignableTrait;

        /**
         * @var FilterInterface[]
         */
        private $filters = [];

        public function apply(Imagick &$image, array $filters)
        {
            foreach ($filters as $filter) {
                if (!array_key_exists($filter, $this->filters)) {
                    continue;
                }

                $this->filters[$filter]->apply($image);
            }
        }
    }
}