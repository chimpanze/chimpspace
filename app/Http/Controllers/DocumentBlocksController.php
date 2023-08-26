<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentBlockRequest;
use App\Http\Requests\UpdateDocumentBlockRequest;
use App\Models\Document;
use App\Models\DocumentBlock;
use Illuminate\Http\Request;

class DocumentBlocksController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentBlockRequest $request)
    {
        $values = $request->validated();

        $documentBlock = new DocumentBlock();
        $documentBlock->type = $values['type'];
        $documentBlock->content = $values['content'];
        $documentBlock->user_id = auth()->id();
        $documentBlock->document_id = $values['document_id'];
        $documentBlock->after_block = $values['after_block'] ?? null;
        $documentBlock->save();

        return response()->json($documentBlock);
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentBlock $documentBlock)
    {
        return response()->json($documentBlock);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentBlockRequest $request, DocumentBlock $documentBlock)
    {
        $values = $request->validated();

        if (!empty($values['content'])) {
            $documentBlock->content = $values['content'];
        }

        if (!empty($values['type'])) {
            $documentBlock->type = $values['type'];
        }

        if (!empty($values['after_block'])) {
            $nextBlock = $documentBlock->nextBlock;
            if ($nextBlock) {
                $nextBlock->after_block = $documentBlock->after_block;
                $nextBlock->save();
            }
            $afterBlock = DocumentBlock::find($values['after_block']);
            if ($afterBlock) {
                if ($afterBlock->nextBlock) {
                    $afterBlock->nextBlock->after_block = $documentBlock->ulid;
                    $afterBlock->nextBlock->save();
                }
            }
            $documentBlock->after_block = $values['after_block'];
        }

        $documentBlock->save();

        return response()->json($documentBlock);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentBlock $documentBlock)
    {
        if (!empty($documentBlock->afterBlock)) {
            $afterBlockUlid = $documentBlock->afterBlock->ulid;
            if (!empty($afterBlockUlid) && $documentBlock->nextBlock()->count()) {
                        $nextBlock = $documentBlock->nextBlock()->first();
                        $nextBlock->after_block = $afterBlockUlid;
                        $nextBlock->save();
            }
        }
        $documentBlock->delete();

        return response()->noContent();
    }
}
