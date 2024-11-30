<?php

namespace App\Livewire;

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
     * @var string $tagInput the input element containing the tag the user wants to add
     */
    public string $tagInput = "";

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
        'tagInput' => 'string|required',
        'tags' => 'json|nullable',
    ];

    /**
     * The validation messages.
     * 
     * @var array $messages
     */
    protected $messages = [
        'tagInput.required' => '',
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

    /**
     * Add the tag in the input field to the array.
     * 
     * @return void
     */
    public function addTag()
    {
        $this->validate();

        $this->tagsArray[] = $this->tagInput; // Add the tag to the array

        $this->tagInput = ""; // Clear the input

        $this->tags = json_encode($this->tagsArray);
    }

    /**
     * Remove the clicked tag from the array.
     * 
     * @see https://www.php.net/manual/en/function.array-splice.php
     * 
     * @param string $tag to remove
     * @return void
     */
    public function removeTag(string $tag)
    {
        array_splice($this->tagsArray, array_search($tag, $this->tagsArray ), 1);
        $this->tags = json_encode($this->tagsArray);
    }

    public function render()
    {
        return view('livewire.tag-manager');
    }
}
