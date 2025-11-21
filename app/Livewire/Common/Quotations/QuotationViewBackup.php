<?php

namespace App\Livewire\Common\Quotations;

use App\Helpers\SettingHelper;
use App\Models\OrganizationSetting;
use App\Models\Quotations;
use App\Models\QuotationSettings;
use App\Models\GeneralSettings;
use App\Models\InvEstActivity;
use Livewire\Attributes\{Layout, On};
use Livewire\{Component, WithPagination};

#[Layout('components.layouts.common-app')]
class QuotationView extends Component
{
    use WithPagination;

    public $estimate;
    public $estimateSettings;
    public $genrealSettings;
    public $historys;
    public $organization_name;
    public $route;
    
    protected $listeners = ['delete' => 'handleSwalConfirm','discard' => 'handleSwalDiscard'];

    public function mount($id)
    {
        $this->route = 'common';

        $this->estimate = Quotations::where('uuid',$id) ->firstOrFail() ?? [];
        $this->estimateSettings = QuotationSettings::first();
        $this->genrealSettings = GeneralSettings::first();
        $this->organization_name = OrganizationSetting::first()->organization_name;
    }
    public function render()
    {
        $this->historys = InvEstActivity::where('quotation_id', $this->estimate->id)->orderBy('inv_est_activity_id', 'DESC')->get();

        return view('livewire.common.quotations.quotation-view');
    }

    public function updateEstimate($value)
    {
        $this->estimate->status = $value;
        $this->estimate->save();



        if ($value == 1) {
                        
                if ($this->estimate->lead_id) {
                    SettingHelper::leadActivityLog(19, $this->estimate->lead_id, null);
                }
        
            SettingHelper::InvEstActivityLog(15,  null, $this->estimate->id, null);
        } elseif ($value == 2) {
            
            if($this->estimate->revised_no){
                
                Quotations::where(function ($q) {
                        $q->where('revised_no', $this->estimate->revised_no)
                          ->orWhere('quotation_no', $this->estimate->revised_no);
                    })
                    ->where('quotation_id', '!=', $this->estimate->id)
                    ->update(['status' => 5]);

                
            }
            
            if ($this->estimate->lead_id) {
                SettingHelper::leadActivityLog(29, $this->estimate->lead_id, null);
            }
            SettingHelper::InvEstActivityLog(27,  null, $this->estimate->id, null);
        } elseif ($value == 3) {
            
                if ($this->estimate->lead_id) {
                    SettingHelper::leadActivityLog(30, $this->estimate->lead_id, null);
                }
                
            SettingHelper::InvEstActivityLog(28,  null, $this->estimate->id, null);
        }
    }

    public function senEstimate()
    {
        $encodedId = base64_encode($this->estimate->id);
        $estimatUrl = env('APP_URL') . '/estimate-portal/' . $encodedId;
        $variables = [
            '[estimate-number]'        => $this->estimate->estimate_no,
            '[organization-name]'     => $this->organization_name,
            '[client-contact-name]'   => $this->estimate->tourist->name ?? '',
            '[estimate-date]'          => $this->estimate->estimate_date,
            '[total-amount]'          => $this->estimate->amount,
            '[estimate-url]'           => $estimatUrl,
            '[po-number]'             => $this->estimate->po_number,
            '[due-date]'              => $this->estimate->expiry_date,
        ];
        SettingHelper::sendEmail(
            '2',
            $variables,
            $this->estimate->tourist->contact_email
        );
    }
    
    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, Accepted it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete'
        ]);
    }
        
    public function handleSwalConfirm()
    {
        $this->updateEstimate(2);
    }
    
        public function confirmDiscard($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, Accepted it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'discard'
        ]);
    }
    
        public function handleSwalDiscard()
    {
        $this->updateEstimate(3);
    }
                
}
