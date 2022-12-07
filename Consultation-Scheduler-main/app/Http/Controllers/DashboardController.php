<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ User, Appointment, Course };
use App\Traits\ChartData;
use App\Services\TwilioSms;

class DashboardController extends Controller
{
    use ChartData;

    public function index(Request $request)
    {
        if (!auth()->check()) {
          return redirect()->route('login');
        }

        if (auth()->user()->role->slug === 'admin') {
          return view('dashboard.index', [
          ]);
        }

        if (auth()->user()->role->slug === 'teacher') {
          return view('dashboard.index', [
              'requests' => Appointment::where(['status' => 'Pending', 'teacher_id' => auth()->user()->id])->count(),
              'approved' => Appointment::where(['status' => 'Approved', 'teacher_id' => auth()->user()->id])->count(),
              'completed' => Appointment::where(['status' => 'Completed', 'teacher_id' => auth()->user()->id])->count(),
              'cancelled' => Appointment::where(['teacher_id' => auth()->user()->id])->whereIn('status', ['Cancelled', 'Declined'])->count(),
          ]);
        }

        return view('dashboard.index', [
          'top_professors' => User::teachers()->take(3)->get()
        ]);
    }

    public function search(Request $request)
    {
        $searchValues = preg_split('/\s+/', $request->search ?? '', -1, PREG_SPLIT_NO_EMPTY);

        $data = User::teachers()->where(function ($query) use ($searchValues) {
            foreach ($searchValues as $value) {
                $query->orWhere('first_name', 'like', "%{$value}%");
                $query->orWhere('last_name', 'like', "%{$value}%");
                $query->orWhere('middle_name', 'like', "%{$value}%");
            }
        });

        return view('search.index', [
            'search' => $request->search ?? '',
            'list' => $data->paginate(10),
        ]);
    }

    public function department($id)
    {
        $data = Course::find($id);
        $teachers = User::teachers();

        


        return view('search.department', [
            'data' => $data,
            'search' => $request->search ?? '',
            'list' => $teachers->paginate(10),
        ]);
    }
}