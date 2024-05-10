<?php

namespace App\Traits;

trait Excludable {
    /**
     * Get the array of columns
     * @return mixed
     */
    private function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
