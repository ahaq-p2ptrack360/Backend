<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\BuImport;
use App\Imports\TicketsImport;
use App\Imports\UserImport;
use App\Imports\group_designation;

class AllImport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {

        return [
            'bu' => new BuImport(),
            'users' => new UserImport(),
            'group_designation'=> new group_designation(),
            'tickets' => new TicketsImport(),


            // Add more sheets as needed
        ];
    }
}
