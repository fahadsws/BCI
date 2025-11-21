<div class="container">
    <style>
        .excel-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
            table-layout: fixed;
        }

        .overflow-x-auto {
            overflow-x: auto
        }

        .excel-table th {
            background: #f1f5f9;
            text-align: left;
            padding: 6px 10px;
            border: 1px solid #ddd;
            white-space: normal;
            /* Allows line breaks */
            word-break: break-word;
            /* Break long words */
            font-size: 12px
        }

        .short-input {
            text-align: right;
            font-size: 12px;
            padding: 3px;
            margin-top: 10px
        }

        .short-input-2 {
            text-align: right;
            font-size: 12px;
            padding: 3px;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background: #ead1dc
        }

        .excel-table textarea {
            font-size: 12px
        }

        .excel-table td {
            border: 1px solid #ddd;
            padding: 0;
            text-align: center;
        }

        .excel-table tr:nth-child(even) {
            background: rgba(0, 0, 0, 0.075);
        }

        .excel-table tr.bg-total {
            background: #bbf7d0;
            font-weight: bold;
        }

        .excel-table tr.bg-total-gst {
            background: #86efac;
            font-weight: bold;
        }

        .excel-table tr.bg-markup {
            background: #dbeafe;
            font-weight: bold;
        }

        /* Markup */
        .excel-table tr.bg-usd {
            background: #e9d5ff;
            font-weight: bold;
        }

        /* USD */
        .excel-table tr.bg-perperson {
            background: #fde68a;
            font-weight: bold;
        }

        .excel-table th:nth-child(1) {
            width: 250px;
        }

        .excel-table th:nth-child(2) {
            width: 100px;
        }

        .excel-table th:nth-child(4) {
            width: 60px;
        }

        .excel-table th:nth-child(7) {
            width: 60px;
        }

        .excel-table th:nth-child(9) {
            width: 60px;
        }



        .excel-table th {
            width: 80px;
        }
    </style>

    <h1>{{ $pageTitle }}</h1>


    @if (!$showModal)
        <form wire:submit.prevent="{{ 'addInvoice' }}">

            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class=" col-6">

                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="title" class="form-label">Tourist Name <span
                                            class="text-danger">*</span></label>
                                    <select id="client_id" class="form-select select2" wire:model="client_id"
                                        placeholder="Client Name" data-show-add="+ New Client"
                                        data-add-callback="ClientAdd" disabled>
                                        <option value=""></option>
                                        @foreach ($clients as $id => $company_name)
                                            <option value="{{ $id }}"
                                                @if ($client_id == $id) selected @endif>
                                                {{ $company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="Invoice Title"
                                    class="form-control text-capitalize @error('estimate_title') is-invalid @enderror"
                                    wire:model="estimate_title">
                                @error('estimate_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Date <span
                                                class="text-danger">*</span></label>
                                        <input disabled id="estimate_date" type="text" placeholder="Invoice Date"
                                            class="form-control datepicker @error('estimate_date') is-invalid @enderror"
                                            wire:model="estimate_date" data-no-min-max="true">
                                        @error('estimate_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Expiry Date <span
                                                class="text-danger">*</span></label>
                                        <input disabled id="expiry_date" type="text" placeholder="Expiry Date"
                                            class="form-control datepicker @error('expiry_date') is-invalid @enderror"
                                            wire:model="expiry_date">
                                        @error('expiry_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Start Date <span
                                                class="text-danger">*</span></label>
                                        <input disabled id="start_date" type="text" placeholder="Start Date"
                                            class="form-control datepicker @error('start_date') is-invalid @enderror"
                                            wire:model="start_date" data-role="start" data-group="booking1">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">End Date <span
                                                class="text-danger">*</span></label>
                                        <input disabled id="end_date" type="text" placeholder="End Date"
                                            class="form-control datepicker @error('end_date') is-invalid @enderror"
                                            wire:model="end_date">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                        </div>


                        <div class="col-6">


                            <div class="mb-3">
                                <label for="title" class="form-label">Quotation # <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="Quotation No"
                                    class="form-control text-capitalize @error('estimate_no') is-invalid @enderror"
                                    wire:model="estimate_no">
                                @error('estimate_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">P.O. Number </label>
                                <input type="text" placeholder="P.O. Number"
                                    class="form-control @error('po_number') is-invalid @enderror"
                                    wire:model="po_number">
                                @error('po_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="title" class="form-label d-flex justify-content-between">Tour Name
                                        @if ($tour_id)
                                            <span wire:click="edit" style="cursor: pointer;color: #E41F07;"><i
                                                    class="lni lni-pencil me-2"></i>View <span wire:loading
                                                    wire:target="edit">
                                                    <span class="spinner-border spinner-border-sm me-1" role="status"
                                                        aria-hidden="true"></span>
                                                </span></span>
                                        @endif
                                    </label>
                                    <select disabled id="tour_id" class="form-select select2" wire:model="tour_id"
                                        placeholder="Tour  Name">
                                        <option value=""></option>
                                        @foreach ($tours as $id => $company_name)
                                            <option value="{{ $id }}"
                                                @if ($tour_id == $id) selected @endif>
                                                {{ $company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if (!$estimateId)
                                <div class="row">

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="title" class="form-label">Base Currency</label>
                                                <select id="currency" class="form-select select2"
                                                    wire:model="currency" placeholder="Select Base Currency">
                                                    <option value=""></option>
                                                    @foreach ($currencys as $code => $currencyName)
                                                        <option value="{{ $code }}"
                                                            @if ($currency == $code) selected @endif>
                                                            {{ $currencyName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($currency == '$')
                                        <div class="col-6">
                                            <label for="title" class="form-label">Currency Rate</label>
                                            <input type="number" class="form-control" wire:model.defer="usdammount"
                                                wire:blur="handleUsdBlur" />
                                        </div>
                                    @endif

                                </div>
                            @endif


                        </div>


                    </div>

                    <hr>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4>Items</h4>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead style="text-transform: uppercase">
                                    <tr>
                                        <th width="40%">
                                            {{ App\Helpers\SettingHelper::getColoumName('items') ?? 'Item' }}</th>

                                        @if (!App\Helpers\SettingHelper::getColoumName('hide_amount'))
                                            <th width="15%" class="text-end">
                                                {{ App\Helpers\SettingHelper::getColoumName('amount') ?? 'Amount' }}
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($selectedItems as $index => $item)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control"
                                                    wire:model="selectedItems.{{ $index }}.name">

                                                <textarea wire:model="selectedItems.{{ $index }}.description" class="form-control mt-2" rows="3"></textarea>
                                                @if (App\Helpers\SettingHelper::getColoumName('custome'))
                                                    <label for="">Custom</label>
                                                    <input type="text" class="form-control"
                                                        wire:model="selectedItems.{{ $index }}.is_custome">
                                                @endif
                                            </td>

                                            @if (!App\Helpers\SettingHelper::getColoumName('hide_amount'))
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">{{ $currency }}</span>
                                                        <input type="text" class="form-control text-end"
                                                            @if ($item['is_tour']) value="{{ \App\Helpers\SettingHelper::formatCurrency($withmarkup_total ?? 0, \App\Helpers\SettingHelper::getGenrealSettings('number_format')) }}"
                                                            @else
                                                            wire:model="selectedItems.{{ $index }}.amount"
                                                            wire:change="handleItemAmount({{ $index }})" @endif
                                                            readonly>

                                                        @error("selectedItems.$index.amount")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Totals Section -->
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Total Amount</th>

                                    <td class="text-end">
                                        {{ $currency }}
                                        {{ \App\Helpers\SettingHelper::formatCurrency($totalAmount ?? 0, \App\Helpers\SettingHelper::getGenrealSettings('number_format')) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-1">
                <label class="form-label">Terms & Conditions <span class="text-danger">*</span></label>
                <textarea class="form-control @error('terms_and_condition') is-invalid @enderror" wire:model="terms_and_condition"
                    rows="8"></textarea>
                @error('terms_and_condition')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-1">
                <label class="form-label">Customer Notes <span class="text-danger">*</span></label>
                <textarea class="form-control @error('notes') is-invalid @enderror" wire:model="notes" rows="8"></textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn bluegradientbtn my-3">
                {{ 'Save Invoice' }}
                <span style="cursor: pointer" wire:loading wire:target="addInvoice">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                </span>
            </button>
        </form>
    @else
        @if (!empty($tableDataJson))
            @php
                $tourPackage = $tableDataJson['tourPackage'];
                $days = $tourPackage['days'] ?? [];
                $summary = $tourPackage['summary'] ?? [];
                $headers = $tableDataJson['headers'] ?? [];
                // dd($summary)
            @endphp
            <div class="table-responsive">
                <table class="excel-table table table-bordered table-hover bg-white">
                    <thead class="thead-light">
                        <tr>
                            @foreach ($headers as $header)
                                <th>{{ $header ?? 'NA' }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $index => $day)
                            <tr class="bg-day">
                                @foreach ($day as $key => $value)
                                    <td>
                                        @if (in_array($key, ['particular', 'activitiesCovered']))
                                            <textarea class="form-control textarea-cell"
                                                wire:model="tableDataJson.tourPackage.days.{{ $index }}.{{ $key }}" disabled></textarea>
                                        @elseif (in_array($key, ['totalForTheDay', 'hotelTotal', 'hotelBalance']))
                                            <input type="text" class="form-control short-input"
                                                wire:model="tableDataJson.tourPackage.days.{{ $index }}.{{ $key }}"
                                                disabled />
                                        @else
                                            <input type="text" class="form-control short-input"
                                                wire:model="tableDataJson.tourPackage.days.{{ $index }}.{{ $key }}"
                                                wire:change="recalculateDay({{ $index }})" disabled />
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        @foreach ($summary as $summaryKey => $summaryRow)
                            @php
                                $rowClass = match ($summaryKey) {
                                    'Total' => 'bg-total',
                                    'Total + GST' => 'bg-total-gst',
                                    'With Markup %' => 'bg-markup',
                                    'USD' => 'bg-usd',
                                    'Per Person for 2 Pax' => 'd-none',
                                    default => '',
                                };
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td class="font-weight-bold">{{ $summaryKey }}</td>
                                @foreach ($summaryRow as $key => $value)
                                    <td>
                                        @if (in_array($key, ['Total for the Day', 'Hotel Total', 'Hotel Balance']))
                                            <input type="text" class="form-control short-input-2"
                                                wire:model="tableDataJson.tourPackage.summary.{{ $summaryKey }}.{{ $key }}"
                                                disabled />
                                        @else
                                            <input type="text" class="form-control short-input-2"
                                                @if ($summaryKey === 'With Markup %' && $key == 'Entry Numbers') wire:model.live="markupammount"
                                                @elseif($summaryKey === 'USD' && $key == 'Entry Numbers')
                                                    wire:model.live="usdammount"
                                                @else
                                                    wire:model="tableDataJson.tourPackage.summary.{{ $summaryKey }}.{{ $key }}" @endif
                                                disabled />
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach

                        <div class="d-flex justify-content-between">
                            <a class="btn btn-dark my-3" wire:click='edit'>Back</a>
                            <a class="btn bluegradientbtn my-3 " wire:click='edit'>Save <span wire:loading
                                    wire:target="edit">
                                    <span class="spinner-border spinner-border-sm me-1" role="status"
                                        aria-hidden="true"></span>
                                </span></a>
                        </div>
                    </tbody>
                </table>
                <div class="text-end">
                    <a class="btn bluegradientbtn my-3 " wire:click='edit'>Save <span wire:loading
                            wire:target="edit">
                            <span class="spinner-border spinner-border-sm me-1" role="status"
                                aria-hidden="true"></span>
                        </span></a>
                </div>
            </div>
        @endif

    @endif


    <div class="modal @if ($showItemModal) show @endif" tabindex="-1"
        style="opacity:1; background-color:#0606068c; display:@if ($showItemModal) block @endif">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-4">
                <form wire:submit.prevent="itemStore">
                    <div class="mb-3 row">

                        <div class="col-6 mb-3 ">
                            <div class="form-group">
                                <label for="title" class="form-label">Items</label>
                                @if ($saveItem)
                                    <input type="text" class="form-control" wire:model="item_name">
                                    @error('item_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                @else
                                    <select id="item_id" class="form-select select2" wire:model="item_id"
                                        data-show-add="+ New Item" data-add-callback="ItemAdd" placeholder="Items">
                                        <option value=""></option>
                                        @foreach ($items as $id => $full_name)
                                            <option value="{{ $id }}"
                                                @if ($item_id === $id) selected @endif>
                                                {{ $full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('item_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                @endif

                            </div>
                        </div>

                        <div class="col-6 mt-2">
                            <label for="">Amount</label>
                            <input type="number" class="form-control" wire:model="item_amount">
                            @error('item_amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary px-5" wire:loading.attr="disabled">
                            <span>Save changes</span>
                            <span wire:loading wire:target="itemStore">
                                <span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span>
                            </span>
                        </button>
                        <button type="button" wire:click="addItem" class="btn btn-sm btn-secondary">
                            <span>Close</span>
                            <span wire:loading wire:target="addItem">
                                <span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
