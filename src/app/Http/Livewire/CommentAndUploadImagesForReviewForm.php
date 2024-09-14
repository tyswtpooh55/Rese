<?php

namespace App\Http\Livewire;

use App\Models\ReviewImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CommentAndUploadImagesForReviewForm extends Component
{
    use WithFileUploads;

    public $comment;
    public $postedImgs = [];
    public $maxLength = 400;
    public $imgs = [];
    public $previewImgs = [];

    public function mount($review = null)
    {
        if ($review) {
            $this->comment = $review->comment;
            $this->postedImgs = $review->reviewImages->map(function ($image) {
                return ['id' => $image->id, 'img_url' => $image->img_url];
            })->toArray();
        }
    }

    public function removeExistingImg($imageId)
    {
        $image = ReviewImage::find($imageId);

        Storage::delete('public' . $image->img_url);

        $image->delete();

        $this->postedImgs = array_filter($this->postedImgs, function ($img) use ($imageId) {
            return $img['id'] !== $imageId;
        });
    }

    public function updatedImgs()
    {
        $this->validate([
            'imgs.*' => ['image', 'mimes:jpeg,png', 'max:2048'],
        ]);

        $this->previewImgs = [];
        foreach ($this->imgs as $img) {
            $this->previewImgs[] = $img->temporaryUrl();
        }

        foreach ($this->imgs as $img) {
            $img->store('imgs');
        }
    }

    public function render()
    {
        return view('livewire.comment-and-upload-images-for-review-form');
    }
}
