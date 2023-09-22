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
    public $techStack;
    public $otherTech;
    public $yearCreated;

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'techStack' => 'required',
        'otherTech' => 'required',
        'yearCreated' => 'required',
    ];

    protected $validationAttributes = [
        'name' => 'name',
        'description' => 'description',
        'techStack' => 'tech stack',
        'otherTech' => 'other tech',
        'yearCreated' => 'year created',
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
            'description' => $this->description,
            'tech_stack' => $this->techStack,
            'other_tech' => $this->otherTech,
            'year_created' => $this->yearCreated,
        ]);

        $project->addMedia($this->fileUpload->path())
            ->usingName($this->fileUpload->getClientOriginalName())
            ->usingFileName($this->fileUpload->getClientOriginalName())
            ->toMediaCollectionOnCloudDisk('images');

        $this->reset();

        return $this->toast('Project Uploaded', type: 'success');
    }
}
