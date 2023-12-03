<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{

    public function index()
    {
        $pages = Page::with(['pages', 'page_name', 'permissions'])->latest()->get();
        return response()->json([
            'pages' => $pages,
            'message' => 'Pages get success'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:pages',
        ]);

        Page::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'path' => $request->path,
            'order' => $request->order,
            'page_id' => $request->page_id
        ]);

        return response()->json([
            'message' => 'Page create successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('pages')->ignore($request->id, 'id')
            ]
        ]);

        $page = Page::find($id);

        $page->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'path' => $request->path,
            'order' => $request->order,
            'page_id' => $request->page_id
        ]);

        return response()->json([
            'message' => 'Page update successfully'
        ]);
    }
}
