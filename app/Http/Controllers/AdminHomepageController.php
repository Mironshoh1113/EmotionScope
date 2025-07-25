<?php

namespace App\Http\Controllers;

use App\Models\HomepageContent;
use Illuminate\Http\Request;

class AdminHomepageController extends Controller
{
    public function index()
    {
        $contents = HomepageContent::all();
        return view('admin.homepage.index', compact('contents'));
    }

    public function edit($id)
    {
        $content = HomepageContent::findOrFail($id);
        return view('admin.homepage.edit', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $content = HomepageContent::findOrFail($id);
        $data = $request->validate([
            'uz' => 'required',
            'ru' => 'required',
            'en' => 'required',
        ]);
        $content->update($data);
        return redirect()->route('admin.homepage.index')->with('success', 'Matn yangilandi!');
    }
} 