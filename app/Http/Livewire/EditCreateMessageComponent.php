<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditCreateMessageComponent extends Component
{
    public $message;

    public function mount($message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.edit-create-message-component',[
            'message' => $this->message
        ]);
    }
}
