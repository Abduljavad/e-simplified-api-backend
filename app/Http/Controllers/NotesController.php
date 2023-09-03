<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotesRequest;
use App\Http\Requests\UpdateNotesRequest;
use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
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
        $request->validate(['chapter_id' => 'required|exists:chapters,id']);

        return Note::where('chapter_id', $request->chapter_id)->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotesRequest $request)
    {
        $note = Note::create($request->validated());

        return $this->successResponse('note created successfully', ['note' => $note]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return $note->load(['chapter']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotesRequest  $request
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotesRequest $request, Note $note)
    {
        $note->update($request->validated());

        return $this->successResponse('note updated successfully', ['note' => $note]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $notes)
    {
        $this->deleteFile($notes->url);

        $notes->delete();
        return $this->successResponse('note deleted successfully');
    }
}
