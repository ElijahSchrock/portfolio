<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class AdminDashboard extends Component
{
    use WithFileUploads;
    use CanToast;

    public $name;
    public $description;
    public $fileUpload;

    protected $rules = [
        'name' => 'required',
        'description' => 'required'
    ];

    protected $validationAttributes = [
        'name' => 'name',
        'description' => 'description'
    ];

    public function render()
    {
        return view('livewire.admin-dashboard');
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

        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $project->addMedia($this->fileUpload->path())
            ->usingName($this->fileUpload->getClientOriginalName())
            ->usingFileName($this->fileUpload->getClientOriginalName())
            ->toMediaCollectionOnCloudDisk('images');

        $this->reset(['name', 'description', 'fileUpload']);

        return $this->toast('Project Uploaded', type: 'success');
    }
}
