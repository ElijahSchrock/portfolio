<?php

namespace App\Livewire;

use App\Models\Resume;
use Livewire\Component;
use App\Livewire\CanToast;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Validator;

class ResumeUpload extends Component
{
    use WithFileUploads;
    use CanToast;

    public $fileUpload;

    public $name;

    protected $rules = [
        'name' => 'required'
    ];

    protected $validationAttributes = [
        'name' => 'name'
    ];

    #[Computed]
    public function currentResume()
    {
        return Resume::where('is_active', true)->first();
    }

    public function removeFile()
    {
        $this->fileUpload = null;
    }

    public function updatingFileUpload($value)
    {
        Validator::make(
            ['upload' => $value],
            ['upload' => 'required'],
        )->validate();
    }

    public function save()
    {
        $this->validate();

        $resume = Resume::create([
            'name' => $this->name,
            'is_active' => true,
        ]);

        $resume->addMedia($this->fileUpload->path())
            ->usingName($this->fileUpload->getClientOriginalName())
            ->usingFileName($this->fileUpload->getClientOriginalName())
            ->toMediaCollectionOnCloudDisk('file');

        $this->reset();

        Resume::where('id', '!=', $resume->id)->update(['is_active' => false]);

        return $this->toast('Resume Uploaded', type: 'success');
    }

    public function render()
    {
        return view('livewire.resume-upload');
    }

    public function deleteResume($id)
    {
        $resume = Resume::find($id);

        $resume->update([
            'is_active' => false
        ]);

        return $this->toast('Resume Deactivated', type: 'success');
    }
}
