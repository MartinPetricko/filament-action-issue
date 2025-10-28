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
use Livewire\Attributes\On;
use Livewire\Component;

class CommentsList extends Component
{
    public ?Model $commentable = null;

    public array $comments = [];

    public function mount(Model $commentable): void
    {
        $this->commentable = $commentable;

        $this->refreshComments();
    }

    #[On('refresh-comments')]
    public function refreshComments(): void
    {
        $this->comments = $this->commentable->comments->all();
    }

    public function render(): View
    {
        return view('livewire.comments_list');
    }
}
