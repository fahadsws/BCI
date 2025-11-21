<?php

namespace App\Livewire\Common\ProformaInvoice;

use App\Models\Companies;
use App\Models\ProformaInvoices;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.common-app')]
class ProformaInvoice extends Component
{
    use WithPagination;

    public $pageTitle;
    public $search = '';
    public $estimateSettings;

    public $statusFilter = null;
    public $startdate, $enddate;
    public $route;
    public $showModal = false, $leads;
    public $companies, $company_id;

    public function mount()
    {
        $this->route = 'common';
        $this->pageTitle = 'ProForma Invoice';
        $this->companies = Companies::select('company_id', 'company_name', 'company_email')
            ->get()
            ->mapWithKeys(function ($tourist) {
                return [$tourist->id => $tourist->company_name . ' - ' . $tourist->company_email];
            })
            ->toArray();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setStatusFilter($status)
    {
        $this->statusFilter = $status;
    }

    public function render()
    {
        $query = ProformaInvoices::query();

        if ($this->statusFilter !== null) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search !== '') {
            $query->where('proforma_invoice_no', 'like', "%{$this->search}%");
        }

        if ($this->company_id) {
            $query->where('company_id', $this->company_id);
        }


        if ($this->startdate && $this->enddate) {
            $query->whereBetween('proforma_invoice_date', [$this->startdate, $this->enddate]);
        } elseif ($this->startdate) {
            $query->whereDate('proforma_invoice_date', '>=', $this->startdate);
        } elseif ($this->enddate) {
            $query->whereDate('proforma_invoice_date', '<=', $this->enddate);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(10);

        $counts = [
            'draft' => ProformaInvoices::where('status', 0)->count(),
            'sent' => ProformaInvoices::where('status', 1)->count(),
            'paid' => ProformaInvoices::where('status', operator: 2)->count(),
            'all' => ProformaInvoices::count(),
        ];

        return view('livewire.common.proformainvoice.proformainvoice', compact('items', 'counts'));
    }
    
        public function markPaid($id)
    {
        ProformaInvoices::findOrFail($id)->update([
            'status' => 2
        ]);
    }
}
