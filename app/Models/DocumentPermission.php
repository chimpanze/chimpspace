<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentPermission extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'ulid', 'document_id');
    }
}
