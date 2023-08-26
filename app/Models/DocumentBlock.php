<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentBlock extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = ['type', 'content', 'order'];

    protected $primaryKey = 'ulid';

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'ulid', 'document_id');
    }

    public function afterBlock(): HasOne
    {
        return $this->hasOne(DocumentBlock::class, 'ulid', 'after_block');
    }

    public function nextBlock(): HasOne
    {
        return $this->hasOne(DocumentBlock::class, 'after_block', 'ulid');
    }
}
