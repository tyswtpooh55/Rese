<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImage extends Component
{
    use WithFileUploads;

    public $selectedImage;
    public $uploadImage;
    public $storageImages;

    public function mount($storageImages)
    {
        $this->storageImages = $storageImages;
    }

    public function render()
    {
        return view('livewire.upload-image');
    }
}
