<?php

namespace App\Imports;

use App\Result;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResultImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!isset($row['id'])) {
                return null;
            }

            if (isset($row['password']) && $row['password'] != null) {
                Result::updateOrCreate([
                    'id' => $row['id'],
                ], $array = [
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['password']),
                ]);
            } else {
                Result::updateOrCreate([
                    'id' => $row['id'],
                ], $array = [
                    'user_id' => $row['user_id'],
                    'exam_id' => $row['exam_id'],
                    'semster_id' => $row['semster_id'],
                    'sup_subject_id' => $row['subject_id'],
                    'exam1' => $row['degree'],
                ]);
            }
        }
    }
}
