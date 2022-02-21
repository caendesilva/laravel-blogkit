<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;

class TagManager extends Component
{
    /**
     * @var object $existingTags in the database
     */
    public object $existingTags;

    /**
     * @var array $tagsArray the array of tags we generate
     */
    public array $tagsArray = [];

    /**
     * @var string $addTag the input element containing the tag the user wants to add
     */
    public string $addTag = "";

    /**
     * @var string $tags the json we submit in the form
     */
    public string $tags;

    /**
     * The validation rules.
     * 
     * @var array $rules
     */
    protected $rules = [
        'addTag' => 'string|required',
        'tags' => 'json|nullable',
    ];

    /**
     * The validation messages.
     * 
     * @var array $messages
     */
    protected $messages = [
        'addTag.required' => '',
    ];

    /**
     * Construct the component.
     * 
     * @param array|null $currenttags if the post is being updated, pass the current tags to the constructor
     * @return void
     */
    public function mount(array $currenttags = null)
    {
        if ($currenttags) {
            $this->tagsArray = $currenttags;
            $this->tags = json_encode($this->tagsArray);
        }

        $this->existingTags = Tag::all();
    }

    public function addTag()
    {
        $this->validate();

        $this->tagsArray[] = $this->addTag; // Add the tag to the array

        $this->addTag = ""; // Clear the input

        $this->tags = json_encode($this->tagsArray);
    }

    public function render()
    {
        return view('livewire.tag-manager');
    }
}
