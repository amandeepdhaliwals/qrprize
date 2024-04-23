<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    public $searchTerm;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $rolesId = [1, 2];
        $searchTerm = '%'.$this->searchTerm.'%';
        // $users = User::where('name', 'like', $searchTerm)->orWhere('email', 'like', $searchTerm)->orderBy('id', 'desc')->with(['permissions', 'roles', 'providers'])->paginate();
        $users = User::where(function ($query) use ($searchTerm) {
            $query->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm);
        })
        ->whereHas('roles', function ($query) use ($rolesId) {
            $query->whereIn('id', $rolesId);
        })
        ->with(['permissions', 'roles', 'providers'])
        ->orderBy('id', 'desc')
        ->paginate();

        return view('livewire.users-index', compact('users'));
    }
}
