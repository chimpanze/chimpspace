<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentBlocks extends Model
{
    use HasFactory;
    use HasUlids;

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'ulid', 'document_id');
    }
}
