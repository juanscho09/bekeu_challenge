<?php

namespace App\Imports;

use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StateImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $states = State::where('id', $row['id'])->get();
        if( count($states) > 0 ){
            return $states->first();
        }
        return new State([
            'id' => $row['id'],
            'code' => $row['code'],
            'name' => $row['name'],
            'created_at' => $row['createdat'],
            'updated_at' => $row['updatedat']
        ]);
    }
}
