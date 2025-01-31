<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $page = Page::all();

        return Inertia::render('PageView/Index', [
            'pages' => $page,
        ]);
    }

    public function store(Request $request)
    {
        $vallidatedData = $request->validate([
            'title' => 'required|string|max:50',
            'route' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ]);

        $page = Page::create($vallidatedData);

        return back()->with([
            'pages' => $page,
            'success' => 'Page has been added successfully'
        ]);
    }

    public function show(Page $page)
    {
        return Inertia::render('PageView/Detail', [
            'pages' => $page,
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:50',
            'route' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);
        $page->update($validateData);

        return redirect()->route('pages.index')->with([
            'pages' => $page,
            'success' => 'The data has been updated successfully!',
        ]);
    }
}
