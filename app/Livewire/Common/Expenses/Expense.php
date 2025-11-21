<?php

namespace App\Livewire\Common\Expenses;

use App\Models\Tourists;
use App\Models\ExpenseCategory;
use App\Models\Expenses as Model;
use App\Models\Quotations;
use App\Models\Tours;
use Livewire\Attributes\{Layout, On};
use Livewire\{Component, WithPagination};

#[Layout('components.layouts.common-app')]
class Expense extends Component
{
    use WithPagination;

    public $itemId;
    public $date, $categorys, $category_id, $vendor_name, $amount, $reference, $notes,
        $clients, $client_id, $tours, $tour_id, $search = '';

    public $isEditing = false;
    public $pageTitle = 'Expenses';

    public $model = Model::class;
    public $view = 'livewire.common.expenses.expense';


    public $quotations, $quotation_id;
    public $type;
    public $tab = 1;


    public function rules()
    {
        $rules = [
            'amount' => 'required|numeric',
            'notes' => 'required',
            'date' => 'required',
            'type' => 'required',
        ];

        if ($this->type == 1) {
            $rules = array_merge($rules, [
                'vendor_name' => 'required',
                'reference' => 'required',
                'quotation_id' => 'required',
            ]);
        }

        return $rules;
    }


    public function render()
    {
        $query = $this->model::query()
            ->where(function ($q) {
                $q->orWhereHas('client', function ($clientQuery) {
                    $clientQuery->where('name', 'like', "%{$this->search}%");
                })
                    ->orWhereHas('category', function ($categoryQuery) {
                        $categoryQuery->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('tour', function ($tourQuery) {
                        $tourQuery->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhere('vendor_name', 'like', "%{$this->search}%");
            });

        $tour = $this->model::where('type', '1')->count();
        $offive = $this->model::where('type', '2')->count();
        if ($this->tab == 1) {
            $query->where('type', '1');
        } else {
            $query->where('type', '2');
        }

        $items = $query->orderBy('updated_at', 'desc')->paginate(10);
        $this->clients = Tourists::all()->pluck('primary_contact', 'id');
        $this->categorys = ExpenseCategory::all()->pluck('name', 'id');
        $this->tours = Tours::all()->pluck('name', 'id');

        $this->quotations = Quotations::where('status',2)->pluck('quotation_no', 'quotation_id');

        return view($this->view, compact('items', 'tour', 'offive'));
    }
    public function store()
    {
        $this->validate($this->rules());

        $this->model::create([
            'date' => $this->date,
            'category_id' => $this->category_id,
            'vendor_name' => ucwords($this->vendor_name),
            'amount' => $this->amount,
            'reference' => $this->reference,
            'client_id' => $this->client_id,
            'tour_id' => $this->tour_id,
            'notes' => $this->notes,
            'quotation_id' => $this->quotation_id,
            'type' => $this->type,
        ]);
        $this->resetForm();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Added Successfully'
        ]);
    }
    public function edit($id)
    {

        $this->resetForm();
        $item = $this->model::findOrFail($id);

        $this->type = $item->type;
        if ($item->type == 1) {
            $this->client_id = $item->client_id;
            $this->category_id = $item->category_id;
            $this->vendor_name = $item->vendor_name;
            $this->reference = $item->reference;
            $this->tour_id = $item->tour_id;
            $this->quotation_id = $item->quotation_id;
            $this->updatedQuotationId($this->quotation_id);
        }

        $this->itemId = $item->id;
        $this->date = $item->date;
        $this->amount = $item->amount;
        $this->notes = $item->notes;
        $this->isEditing = true;
    }
    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'date' => $this->date,
            'category_id' => $this->category_id,
            'vendor_name' => ucwords($this->vendor_name),
            'amount' => $this->amount,
            'reference' => $this->reference,
            'client_id' => $this->client_id,
            'tour_id' => $this->tour_id,
            'notes' => $this->notes,
            'quotation_id' => $this->quotation_id,
            'type' => $this->type
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Updated Successfully'
        ]);
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
            'action' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'itemId',
            'isEditing',
            'date',
            'category_id',
            'vendor_name',
            'amount',
            'reference',
            'client_id',
            'tour_id',
            'notes',
            'quotation_id',
            'type'
        ]);
        $this->resetValidation();
    }

    public function toggleStatus($id)
    {
        $habitat = $this->model::findOrFail($id);
        $habitat->status = !$habitat->status;
        $habitat->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function updatedQuotationId($id)
    {
        $qt = Quotations::where('quotation_id', $id)->first();

        if ($qt->tourist_id) {
            $this->client_id = $qt->tourist_id;
        }
        if ($qt->tour_id) {
            $this->tour_id = $qt->tour_id;
        }
        $this->reference = $qt->quotation_no . ' | ' . $qt->quotation_title;
    }
    public function setTab($tab)
    {
        $this->tab = $tab;
    }
}
