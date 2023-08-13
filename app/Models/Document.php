<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    use HasFactory;
    use HasUlids;

    public function parentDocument(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'ulid', 'parent_document');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'parent_document', 'ulid');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(DocumentPermissions::class, 'document_id', 'ulid');
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(DocumentBlocks::class, 'document_id', 'ulid');
    }
}
