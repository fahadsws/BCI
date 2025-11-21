<?php

namespace App\Livewire\Common\Tourists;

use App\Helpers\SettingHelper;
use App\Models\Tourists as Model;
use Livewire\Attributes\{Layout, On};
use Livewire\{Component, WithPagination};

#[Layout('components.layouts.common-app')]
class TouristList extends Component
{
    use WithPagination;

    public $pageTitle = 'Tourists';
    public $search = '';
    public $route;
    public $itemId;

    // 👇 Add this
    public $perPage = 15;

    protected $paginationTheme = 'bootstrap';

    public function mount($id = null)
    {
        $this->route = 'common';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $items = Model::where(function ($query) {
                $query->where('primary_contact', 'like', "%{$this->search}%")
                      ->orWhereNull('primary_contact');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.common.tourists.tourist-list', compact('items'));
    }

    public function confirmDelete($id)
    {
        $this->itemId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete',
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        Model::destroy($this->itemId);
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }
}
