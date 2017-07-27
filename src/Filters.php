<?php

namespace Ueef\ImageFilters {

    use Imagick;
    use Iterator;
    use Ueef\Assignable\Traits\AssignableTrait;
    use Ueef\Assignable\Interfaces\AssignableInterface;
    use Ueef\ImageFilters\Interfaces\FilterInterface;

    class Filters implements Iterator, AssignableInterface
    {
        use AssignableTrait;

        const INCT = 1;
        const DIFF = 2;

        /**
         * @var FilterInterface[]
         */
        private $filters = [];


        public function __construct(array $filters, array $parameters = [])
        {
            $this->filters = $filters;
            $this->assign($parameters);
        }

        public function has(string $key): bool
        {
            return key_exists($key, $this->filters);
        }

        public function get(string $key): FilterInterface
        {
            return $this->filters[$key];
        }

        public function slice(?array $keys = null, $type = self::DIFF)
        {
            $filters = $this->filters;
            if (null !== $keys) {
                $keys = array_fill_keys($keys, null);

                switch ($type) {
                    case self::INCT:
                        $filters = array_intersect_key($filters, $keys);
                        break;

                    case self::DIFF:
                        $filters = array_diff_key($filters, $keys);
                        break;
                }
            }

            return new static($filters);
        }

        public function apply(Imagick &$image)
        {
            foreach ($this->filters as $filterName => $filter) {
                $filter->apply($image);
            }
        }

        public function current()
        {
            return current($this->filters);
        }

        public function key()
        {
            return key($this->filters);
        }

        public function next()
        {
            next($this->filters);
        }

        public function rewind()
        {
            reset($this->filters);
        }

        public function valid()
        {
            return null !== $this->key();
        }
    }
}