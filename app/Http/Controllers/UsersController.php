<?php

namespace App\Http\Controllers;

use App\User;
use App\Specialty;
use App\StatusStudent;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\DataTables\UsersDataTable;
use App\DataTables\UsersDataTablesEditor;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('vendor.voyager.users.index');
    }

    public function store(UsersDataTablesEditor $editor)
    {
        return $editor->process(request());
    }

    public function get(Request $request)
    {
      
        $users = User::with('statusStudents', 'specialy', 'stageEdu', 'classEdu', 'classRoom');

        if ($request->job != '') {
            $users->where('job', $request->job);
        }
        if ($request->gender != '') {
            $users->where('gender', $request->gender);
        }
        if ($request->specialty != '') {
            $users->where('specialty_id', $request->specialty);
        }
        
        if ($request->status_id != '') {
            $users->where('status_id', $request->status_id);
        }

        if ($request->value != '') {
            $users->search($request->value);
        }
        $results = $users->paginate(25);

        $specialties = Specialty::all();
        $statusStudents = StatusStudent::all();
        return response()->json([
            'users' => $results,
            'statusStudents' => $statusStudents,
            'specialties' => $specialties
        ]);
    }
}
