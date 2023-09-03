<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoresectionRequest;
use App\Http\Requests\UpdatesectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'super_admin'])->only(['store', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate(['course_id' => 'required|exists:courses,id']);

        return Section::where('course_id', $request->course_id)->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresectionRequest $request)
    {
        $section = Section::create($request->validated());

        return $this->successResponse('section created successfully', ['section' => $section]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(section $section)
    {
        return $section->load(['course']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesectionRequest  $request
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesectionRequest $request, section $section)
    {
        $section->update($request->validated());

        return $this->successResponse('section updated successfully', ['section' => $section]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(section $section)
    {
        $this->deleteFile($section->icon);

        $section->delete();
        return $this->successResponse('section deleted successfully');
    }
}
