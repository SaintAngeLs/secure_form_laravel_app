<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Models\FormEntry;
use App\Infrastructure\Persistence\Models\File;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $formEntries = FormEntry::with('file')->get();
        return view('admin_form_entries.index', compact('formEntries'));
    }

    public function show($id)
    {
        $entry = FormEntry::with('file')->findOrFail($id);

        return view('admin_form_entries.show', compact('entry'));
    }

}
