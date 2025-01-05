<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Models\FormEntry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = FormEntry::with('file');

        // Handle search
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhereHas('file', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        // Handle per-page option
        $perPage = $request->input('per_page', 10);

        $formEntries = $query->paginate($perPage);

        return view('admin_form_entries.index', compact('formEntries'));
    }

    public function show($id)
    {
        $entry = FormEntry::with('file')->findOrFail($id);

        return view('admin_form_entries.show', compact('entry'));
    }
}
