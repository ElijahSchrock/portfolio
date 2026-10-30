<?php

namespace App\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminDashboard extends Component
{
    use CanToast;
    use RequiresOwner;
    use WithFileUploads;

    public $name;

    public ?string $site = null;

    public ?string $repositoryUrl = null;

    public $description;

    public $fileUpload;

    public $techStack;

    public $otherTech;

    public $yearCreated;

    protected $rules = [
        'name' => 'required',
        'site' => 'nullable|url:http,https|max:2048',
        'repositoryUrl' => 'nullable|url:http,https|max:2048',
        'description' => 'required',
        'techStack' => 'required',
        'otherTech' => 'nullable|string|max:255',
        'yearCreated' => 'nullable|string|max:255',
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
            'site' => filled($this->site) ? $this->site : null,
            'repository_url' => filled($this->repositoryUrl) ? $this->repositoryUrl : null,
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
