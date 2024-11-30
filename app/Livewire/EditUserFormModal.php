<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditUserFormModal extends Component
{
    use AuthorizesRequests;
    
    /**
     * @var bool $show the modal?
     */
    public bool $show = false;

    /**
     * The user instance.
     * 
     * @var \App\Models\User
     */
    public User $user;

    /**
     * The validation rules.
     * 
     * @var array $rules
     */
    protected $rules = [
        'user.is_admin' => 'nullable|boolean',
        'user.is_author' => 'nullable|boolean',
    ];

    /**
     * Listen to calls to trigger the modal opening and close.
     * 
     * @var array $listeners
     */
    protected $listeners = [
        'openEditUserModal',
        'closeModals' => 'closeModal',
    ];

    /**
     * Set the user we are editing and open the modal.
     * Livewire automatically returns a 404 not found error if the user does not exist.
     * 
     * @param User $user
     * @return void
     */
    public function openEditUserModal(User $user)
    {
        // Abort if the user is not an admin.
        abort_unless(Auth::user()->is_admin, 403);

        // Set the user model
        $this->user = $user;

        // Set the show attribute to true, which makes the modal visible in the frontend.
        $this->show = true;
    }

    /**
     * Set the show attribute to false, removes the modal from the frontend.
     * 
     * @return void
     */
    public function closeModal()
    {
        // Unset the user
        unset($this->user);

        // Hide the modal
        $this->show = false;

        // Tell the event listener in the component that the modal was closed, so we can unlock the body.
        $this->emit('modalClosed');
    }

    /**
     * Save the user.
     * 
     * @return void
     */
    public function save()
    {
        abort_if(config('blog.demoMode'), 403, 'Cannot do this action in demo mode.');

        // Authorize the request
        $this->authorize('update', $this->user);

        // Save the user model.
        $this->user->save();

        // Redirect back to dashboard with a message to the frontend that the user was saved.
        return redirect()->to('/dashboard')->with('success', 'Successfully Updated User!');
    }

    /**
     * Delete the user.
     * 
     * @return void
     */
    public function deleteUser()
    {
        abort_if(config('blog.demoMode'), 403, 'Cannot do this action in demo mode.');

        // Authorize the request
        $this->authorize('delete', $this->user);

        // Delete the user model.
        $this->user->delete();

        // Redirect back to dashboard with a message to the frontend that the user was saved.
        return redirect()->to('/dashboard')->with('success', 'Successfully Deleted User!');
    }

    /**
     * Ban the user.
     * 
     * @return void
     */
    public function banUser()
    {
        abort_unless(config('blog.bans'), 403, 'Banning users is not enabled.');

        abort_if(config('blog.demoMode'), 403, 'Cannot do this action in demo mode.');

        // Authorize the request
        $this->authorize('ban', $this->user);

        // Ban the user.
        $this->user->is_banned = true;
        $this->user->save();
        
        // Redirect back to dashboard with a message to the frontend that the user was banned.
        return redirect()->to('/dashboard')->with('success', 'Successfully Banned User!');
    }

    
    /**
     * Unban the user.
     * 
     * @return void
     */
    public function unbanUser()
    {
        // Authorize the request
        $this->authorize('ban', $this->user);

        // Unban the user.
        $this->user->is_banned = false;
        $this->user->save();

        // Redirect back to dashboard with a message to the frontend that the user was banned.
        return redirect()->to('/dashboard')->with('success', 'Successfully unbanned User!');
    }

    public function render()
    {
        return view('livewire.edit-user-form-modal');
    }
}
