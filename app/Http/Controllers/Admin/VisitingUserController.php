<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitingUser;
use Illuminate\View\View;

class VisitingUserController extends Controller
{
    /**
     * Display all visiting-user requests.
     */
    public function index(): View
    {
        $visitors = VisitingUser::latest()->paginate(10);

        return view('admin.visiting-users.index', compact('visitors'));
    }
}
