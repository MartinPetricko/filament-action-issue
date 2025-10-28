<?php

namespace App\Livewire;

use App\Models\Comment;
use Filament\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Comments extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?Model $commentable = null;

    public array $data = [];

    public function mount(Model $commentable): void
    {
        $this->commentable = $commentable;

        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->model(Comment::class)
            ->components([
                Textarea::make('message')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('attachments')
                    ->collection('attachments')
                    ->multiple(),
            ]);
    }

    public function create(): void
    {
        $comment = Comment::make($this->form->getState());

        $comment->commentable()->associate($this->commentable);
        $comment->commenter()->associate(Auth::user());

        $comment->save();

        $this->form->model($comment)->saveRelationships();

        $this->form->fill();

        $this->dispatch('refresh-comments');

        Notification::make()
            ->title('jej')
            ->send();
    }

    public function render(): View
    {
        return view('livewire.comments');
    }
}
