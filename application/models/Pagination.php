<?php

namespace models;

/**
 * Class Pagination
 * @package models
 */
    class Pagination {
        /**
         * @var int
         */
        public $current_page;
        /**
         * @var int
         */
        public $per_page;
        /**
         * @var int
         */
        public $total_count;
        /**
         * @var
         */
        public $page;


        /**
         * @param int $page
         * @param int $per_page
         * @param int $total_count
         */
        public function __construct(int $page=1, int $per_page=20, int $total_count=0)
        {
            $this->current_page = (int) $page;
            $this->per_page = (int) $per_page;
            $this->total_count = (int) $total_count;
        }

        /**
         * @return int
         */
        public function offset(): int
        {
            return ($this->current_page - 1) * $this->per_page;
        }

        /**
         * @return integer
         */
        public function totalPages(): int
        {
            return (int) ceil ($this->total_count/$this->per_page);
        }

        /**
         * @return int
         */
        public function previousPage(): int
        {
            return $this->current_page - 1;
        }

        /**
         * @return int
         */
        public function nextPage(): int
        {
            return $this->current_page + 1;
        }

        /**
         * @return bool
         */
        public function hasPreviousPage(): bool
        {
            return $this->previousPage() >= 1 ?? true;
        }

        /**
         * @return bool
         */
        public function hasNextPage(): bool
        {
            return $this->nextPage() <= $this->totalPages() ?? true;
        }
    }
