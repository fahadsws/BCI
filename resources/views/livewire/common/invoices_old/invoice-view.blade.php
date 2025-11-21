<div class="container">
    <style>
    .table-container {
        width: 100%;
        overflow-x: auto; /* makes it responsive on smaller screens */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    thead {
        background-color: #f8f9fa;
    }

    th, td {
        padding: 10px 12px;
        border: 1px solid #dee2e6;
        text-align: left;
        vertical-align: top;
    }

    th {
        font-weight: 600;
        white-space: nowrap;
    }

    .no {
        width: 40px;
        text-align: center;
    }

    tfoot td {
        font-weight: bold;
        background-color: #f1f1f1;
    }

    @media (max-width: 768px) {
        table {
            font-size: 14px;
        }
        th, td {
            padding: 8px;
        }
    }
</style>
    <div class="page-content">
        <!-- Full Page Loader -->
        <div wire:loading class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Loading invoice...</p>
        </div>

        <div wire:loading.remove>
            @if ($invoice && isset($invoice['id']))


                <div class="toolbar hidden-print">
                    <div class="text-end">
                        @if (in_array($invoice?->status, [1, 0, 4]))
                            <a href="{{ route($route.'.edit-quotation', $invoice->id) }}" class="btn btn-primary"><i
                                    class="fa fa-print"></i>
                                Edit</a>
                        @endif

                        <a onclick="downloadPDF()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i>
                            Export as PDF</a>

                        <a onclick="printInvoice()" class="btn btn-primary"><i class="fa fa-print"></i>
                            Print</a>
                            @if (!in_array($invoice?->status, [2,3]))
    <a wire:click='seninvoice()' class="btn btn-primary"><i class="fa fa-print"></i>
                            send</a> @endif

                            
                       @if (!in_array($invoice?->status, [2,3]))
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" fdprocessedid="ykfs4">More</button>
                                <button type="button"
                                        class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" fdprocessedid="qtrdwa">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                    @if ($invoice?->status === 0)
                                        <a wire:click='updateinvoice(1)' class="dropdown-item" href="javascript:;">Mark as Send</a>
                                    @endif
                        
                                    @if (in_array($invoice?->status, [1]))
                                        <a wire:click='updateinvoice(2)' class="dropdown-item" href="javascript:;">Mark as Paid</a>
                                    @endif
                        
                                    @if (in_array($invoice?->status, [1, 0]))
                                        <a wire:click='updateinvoice(3)' class="dropdown-item" href="javascript:;">Mark as Discard</a>
                                    @endif
                                </div>
                            </div>
                        @endif


                    </div>
                    <hr>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div id="invoice">

                            @php
                                $status = App\Helpers\SettingHelper::getInvoiceStatus($invoice->status);
                            @endphp

                            @if ($status)
                                <div class="ribbon-wrapper">
                                    <div class="ribbon">{{ $status }}</div>
                                </div>
                            @endif


                            <div class="invoice overflow-auto">

                                <div style="min-width: 600px">
                                    <header>

                                        <div class="row">
                                            <div class="col">
                                                <a href="javascript:;">
                                                    @php
                                                        $organization = \App\Models\OrganizationSetting::first();
                                                        $logo = optional($organization->logo)->file;
                                                    @endphp
                                                    @if ($logo)
                                                        <img class="ms-5" src="{{ asset('assets/images/' . $logo) }}"
                                                            style="width: 50%;" alt="logo" />
                                                    @endif
                                                </a>
                                            </div>

                                            <div class="col company-details text-end">
                                                <h2 class="name">
                                                    {{ ucfirst($invoiceSettings->invoice_title ?? 'Quotation') }}
                                                </h2>

                                                @php
                                                    $client = $invoice['tourist'] ?? null;
                                                @endphp

                                                {{-- @if (!empty($client['address']) || !empty($client['city_suburb']) || !empty($client['state']))
                                                    <div>
                                                        {{ $client['address'] ?? '' }}
                                                        {{ !empty($client['city_suburb']) ? ', ' . $client['city_suburb'] : '' }}
                                                        {{ !empty($client['state']) ? ', ' . $client['state'] : '' }}
                                                    </div>
                                                @endif --}}

                                                @if (!empty($client['contact_phone']))
                                                    <div>{{ $client['contact_phone'] }}</div>
                                                @endif

                                                @if (!empty($client['contact_email']))
                                                    <div>
                                                        <a
                                                            href="mailto:{{ $client['contact_email'] }}">{{ $client['contact_email'] }}</a>
                                                    </div>
                                                @endif

                                                @if (!empty($client['other']['website']))
                                                    <div>{{ $client['other']['website'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </header>

                                    <main>
                                        <div class="row contacts">
                                            <div class="col invoice-to">
                                                <div class="text-gray-light">
                                                    {{ ucfirst($invoiceSettings->invoice_title ?? 'Quotation') }} TO:
                                                </div>
                                                <h2 class="to">{{ $client['primary_contact'] ?? 'Company Name' }}</h2>

                                                @php
                                                    $tour = $invoice['tour'] ?? null;
                                                @endphp

                                                @if ($tour)
                                                    <div class="address">Tour Name: {{ $tour['name'] ?? '-' }}</div>
                                                @endif
                                                <div>Tittle:  {{ ucfirst($invoice->invoice_title ?? 'Quotation') }}</div>
                                            </div>

                                            <div class="col invoice-details">
                                                <h1 class="invoice-id">{{ $invoice['invoice_no'] ?? 'N/A' }}</h1>
                                                <div class="date">
                                                    invoice Date:
                                                    {{ \Carbon\Carbon::parse($invoice['invoice_date'] ?? now())->format(App\Helpers\SettingHelper::getGenrealSettings('date_format') ?? 'd M Y') }}
                                                </div>
                                                <div class="date">
                                                    Expiry Date:
                                                    {{ \Carbon\Carbon::parse($invoice['expiry_date'] ?? now())->format(App\Helpers\SettingHelper::getGenrealSettings('date_format') ?? 'd M Y') }}
                                                </div>
                                            </div>
                                        </div>

                                     <div class="table-container">
    <table>
        <thead class="text-uppercase">
            <tr>
                <th>#</th>
                <th class="text-left">
                    {{ \App\Helpers\SettingHelper::getColoumName('items') ?? 'Item' }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoice['items'] as $index => $item)
                <tr>
                    <td class="no">{{ $index + 1 }}</td>
                    <td class="text-left">
                        @if (!empty($item['item_name']))
                            <strong>{{ $item['item_name'] }}</strong><br>
                        @endif

                        @if (!empty($item['description']))
                            {!! nl2br(e($item['description'])) !!}<br>
                        @endif

                        @if (!empty($item['is_custome']))
                            <strong>Custom:</strong> {{ $item['is_custome'] }}<br>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">No items found in this invoice.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="1"></td>
                <td class="text-right">
                    GRAND TOTAL: ₹{{ \App\Helpers\SettingHelper::formatCurrency(
                        $invoice['amount'] ?? 0,
                        \App\Helpers\SettingHelper::getGenrealSettings('number_format'),
                    ) }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>

                                        @if (!empty($invoice['notes']))
                                            <div class="mt-4">
                                                <h5>Notes</h5>
                                                <p>{!! nl2br(e($invoice['notes'])) !!}</p>
                                            </div>
                                        @endif

                                        @if (!empty($invoice['terms_and_condition']))
                                            <div class="mt-4">
                                                <h5>Terms & Conditions</h5>
                                                <p>{!! nl2br(e($invoice['terms_and_condition'])) !!}</p>
                                            </div>
                                        @endif

                                        <div class="thanks mt-5">Thank you!</div>
                                    </main>

                                    <footer>
                                        invoice was created digitally and is valid without signature.
                                    </footer>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                   <div class="container mt-5">
                    <h4>History</h4>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Date & Time</th>
                                <th scope="col">Action</th>
                                <th scope="col">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historys as $history)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($history->updated_at)->format('F d, Y h:iA') }}</td>
                                    <td>{{ $history?->msg?->message_type ?? 'NA' }}</td>
                                    <td>{{ $history?->user?->name ?? 'Admin' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No History found in this
                                        invoice.</td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
                
            @else
                <div class="alert alert-warning text-center py-5">
                    <h4>No invoice Found</h4>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        async function generatePDFBlob() {
            const paperSize = "{{ ucfirst($genrealSettings->paper_size) ?? 'a4' }}";
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById("invoice");

            const canvas = await html2canvas(element, {
                scale: 2
            });
            const imgData = canvas.toDataURL("image/png");

            const pdf = new jsPDF("p", "mm", paperSize);
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const imgWidth = pageWidth;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);

            return pdf.output("bloburl");
        }

        async function downloadPDF() {
            const paperSize = "{{ ucfirst($genrealSettings->paper_size) ?? 'a4' }}";
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById("invoice");

            const canvas = await html2canvas(element, {
                scale: 2
            });
            const imgData = canvas.toDataURL("image/png");

            const pdf = new jsPDF("p", "mm", paperSize);
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const imgWidth = pageWidth;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);

            pdf.save("invoice.pdf");
        }

        async function printInvoice() {
            const pdfUrl = await generatePDFBlob();
            const printWindow = window.open(pdfUrl);
            printWindow.addEventListener("load", () => {
                printWindow.print();
            });
        }
    </script>

</div>
