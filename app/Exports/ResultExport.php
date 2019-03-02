<?php

namespace App\Exports;

use App\Result;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct($classEdu, $subject, $exam)
    {
        $this->classEdu = $classEdu;
        $this->subject = $subject;
        $this->exam = $exam;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Result::where('sup_subject_id', $this->subject)->where('exam_id', $this->exam)->whereHas('user', function ($query) {
            $query->where('class_id', $this->classEdu);
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'user_id',
            'name',
            'exam_id',
            'exam',
            'semster_id',
            'semster',
            'subject_id',
            'subject',
            'degree',
        ];
    }

    /**
    * @var Result $invoice
    */
    public function map($result): array
    {
        return [
            $result->id,
            $result->user_id,
            $result->user->getFullName(),
            $result->exam_id,
            $result->exam->name,
            $result->semster_id,
            $result->semster->name,
            $result->sup_subject_id,
            $result->supSubject->subjects->name,
            $result->exam1,
        ];
    }
}
