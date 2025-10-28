<?php

namespace App\Filament\Resources\Comments\Actions;

use App\Models\Comment;
use Filament\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Tiptap\Core\Schema;

class CommentsAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'comments';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->slideOver();
        $this->modalWidth(Width::Large);

        $this->schema([
            Textarea::make('message')
                ->required(),
            SpatieMediaLibraryFileUpload::make('attachments')
                ->collection('attachments')
                ->multiple(),
        ]);

        $this->action(function (Schema $schema, Model $record, array $data) {
            $comment = Comment::make($data);

            $comment->commentable()->associate($record);
            $comment->commenter()->associate(Auth::user());

            $comment->save();

            $this->record($comment);
            $schema->model($comment)->saveRelationships();

            $this->success();
        });
    }
}
