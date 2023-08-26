<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $documents = Document::paginate();
        return response()->json($documents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request): JsonResponse
    {
        $values = $request->validated();
        $document = new Document;
        $document->title = $values['title'];
        $document->parent_document = $values['parent_document'] ?? null;
        $document->user_id = auth()->id();
        $document->save();

        return response()->json($document);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Document $document)
    {
        if ($request->user()->can('view', $document)) {
            return new DocumentResource($document);
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        if ($request->user()->can('update', $document)) {
            $values = $request->validated();

            if ($values['title']) {
                $document->title = $values['title'];
            }
            if ($values['parent_document'] !== '') {
                $document->parent_document = $values['parent_document'];
            }

            $document->save();

            return response()->json($document);
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Document $document)
    {
        if ($request->user()->can('delete', $document)) {
            $document->delete();

            return response()->noContent();
        } else {
            abort(403);
        }
    }
}
