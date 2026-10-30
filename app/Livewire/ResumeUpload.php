<?php

namespace App\Livewire;

use App\Models\Resume;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResumeUpload extends Component
{
    use CanToast;
    use RequiresOwner;
    use WithFileUploads;

    public $fileUpload;

    public $name;

    protected $rules = [
        'name' => 'required',
    ];

    protected $validationAttributes = [
        'name' => 'name',
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
            'is_active' => false,
        ]);

        return $this->toast('Resume Deactivated', type: 'success');
    }
}
