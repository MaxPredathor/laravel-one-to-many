<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $technologies = config('technologies.key');
        return view('admin.projects.create', compact('technologies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $formData = $request->validated();
        $slug = Str::slug($formData['title'], '-');
        $formData['slug'] = $slug;
        $userId = Auth::id();
        $formData['user_id'] = $userId;
        if ($request->hasFile('image')) {
            $path = Storage::put('uploads', $request->image);
            $formData['image'] = $path;
            // dd($path);
        }
        $formData['technologies'] = implode(',', $request->input('technologies'));
        $project = Project::create($formData);
        return redirect()->route('admin.projects.show', $project->slug);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->technologies = explode(',', $project->technologies);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $categories = Category::all();
        $technologies = config('technologies.key');
        return view('admin.projects.edit', compact('project', 'technologies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $formData = $request->validated();
        if ($project->title !== $formData['title']) {
            $slug = Project::getSlug($formData['title']);
        }else{
            $slug = $project->slug;
        }
        // $slug = Str::slug($formData['title'], '-');
        $formData['slug'] = $slug;
        $formData['user_id'] = $project->user_id;
        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::delete($project->image);
            }
            $path = Storage::put('uploads', $request->image);
            $formData['image'] = $path;
        }
        $formData['technologies'] = implode(',', $request->input('technologies'));
        $project->update($formData);
        return redirect()->route('admin.projects.show', $project->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::delete($project->image);
        }
        $project->delete();
        return to_route('admin.projects.index')->with('message', "Il Progetto '$project->title' è stato  eliminato");
    }
}
