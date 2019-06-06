<?php

namespace App\Exports;

use App\Visit;
use App\Link;
use Maatwebsite\Excel\Concerns\FromCollection;

class VisitsExport implements FromCollection
{
    var $link;
    public function __construct(Link $link)
    {
        $this->link = $link;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Visit::ofLink($this->link->id)->get();
    }
}
