<div class="container">
    
        <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/app.css') }}?t={{ time() }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



    <style>
        .modal {
            overflow-y: auto !important;
        }

        span.select2-selection.select2-selection--single {
            height: auto;
            border-color: #ced4da !important;
        }

        span.select2-selection__rendered {
            padding: 0.275rem 1rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 0.375rem !important;
        }

        .select2-dropdown {
            z-index: 999999 !important;
        }


        .ribbon-wrapper {
            width: 150px;
            height: 150px;
            position: absolute;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 10;
        }

        .ribbon {
            position: absolute;
            display: block;
            width: 200px;
            padding: 10px 0;
            background: #f16302;
            color: white;
            text-align: center;
            font-weight: bold;
            transform: rotate(-45deg);
            top: 30px;
            left: -50px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
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
                        <a onclick="downloadPDF()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i>
                            Export as PDF</a>

                        <a onclick="printInvoice()" class="btn btn-primary"><i class="fa fa-print"></i>
                            Print</a>
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
                                                    {{ ucfirst($invoiceSettings->invoice_title ?? 'Quotation') }}s
                                                </h2>

                                                @php
                                                    $client = $invoice['client'] ?? null;
                                                @endphp

                                                @if (!empty($client['address']) || !empty($client['city_suburb']) || !empty($client['state']))
                                                    <div>
                                                        {{ $client['address'] ?? '' }}
                                                        {{ !empty($client['city_suburb']) ? ', ' . $client['city_suburb'] : '' }}
                                                        {{ !empty($client['state']) ? ', ' . $client['state'] : '' }}
                                                    </div>
                                                @endif

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
                                                <h2 class="to">{{ $client['company_name'] ?? 'Company Name' }}</h2>

                                                @php
                                                    $tour = $invoice['tour'] ?? null;
                                                @endphp

                                                @if ($tour)
                                                    <div class="address">Tour Name: {{ $tour['name'] ?? '-' }}</div>
                                                    <div class="address">Tour Start Date:
                                                        {{ \Carbon\Carbon::parse($tour['start_date'] ?? now())->format(App\Helpers\SettingHelper::getGenrealSettings('date_format') ?? 'd M Y') }}
                                                    </div>
                                                    <div class="address">Tour End Date:
                                                        {{ \Carbon\Carbon::parse($tour['end_date'] ?? now())->format(App\Helpers\SettingHelper::getGenrealSettings('date_format') ?? 'd M Y') }}
                                                    </div>
                                                @endif
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

                                        <table>
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th>#</th>
                                                    <th class="text-left">
                                                        {{ \App\Helpers\SettingHelper::getColoumName('items') ?? 'Item' }}
                                                    </th>
                                                    @if (!\App\Helpers\SettingHelper::getColoumName('hide_rate'))
                                                        <th width="15%">
                                                            {{ \App\Helpers\SettingHelper::getColoumName('units') ?? 'Rate' }}
                                                        </th>
                                                    @endif
                                                    @if (!\App\Helpers\SettingHelper::getColoumName('hide_quantity'))
                                                        <th width="15%">Qty</th>
                                                    @endif
                                                    @if (!\App\Helpers\SettingHelper::getColoumName('hide_amount'))
                                                        <th width="15%">
                                                            {{ \App\Helpers\SettingHelper::getColoumName('amount') ?? 'Amount' }}
                                                        </th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($invoice['items'] as $index => $item)
                                                    <tr>
                                                        <td class="no">{{ $index + 1 }}</td>
                                                        <td class="text-left">
                                                            @if (empty($item['is_resort']) && !empty($item['item']['name']))
                                                                <strong>{{ $item['item']['name'] }}</strong><br>
                                                            @endif

                                                            @if (!empty($item['description']))
                                                                {!! nl2br(e($item['description'])) !!}<br>
                                                            @endif

                                                            @if (!empty($item['is_date']))
                                                                <strong>Date:</strong> {{ $item['is_date'] }}<br>
                                                            @endif

                                                            @if (!empty($item['is_time']))
                                                                <strong>Time:</strong> {{ $item['is_time'] }}<br>
                                                            @endif

                                                            @if (!empty($item['is_custome']))
                                                                <strong>Custom:</strong> {{ $item['is_custome'] }}<br>
                                                            @endif
                                                        </td>

                                                        @if (!\App\Helpers\SettingHelper::getColoumName('hide_rate'))
                                                            <td class="unit">
                                                                ₹{{ \App\Helpers\SettingHelper::formatCurrency($item['rate'] ?? 0, \App\Helpers\SettingHelper::getGenrealSettings('number_format')) }}
                                                            </td>
                                                        @endif

                                                        @if (!\App\Helpers\SettingHelper::getColoumName('hide_quantity'))
                                                            <td class="qty">{{ $item['qty'] ?? 0 }}</td>
                                                        @endif

                                                        @if (!\App\Helpers\SettingHelper::getColoumName('hide_amount'))
                                                            <td class="total">
                                                                ₹{{ \App\Helpers\SettingHelper::formatCurrency($item['amount'] ?? 0, \App\Helpers\SettingHelper::getGenrealSettings('number_format')) }}
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No items found in this
                                                            invoice.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td>SUBTOTAL</td>
                                                    <td>
                                                        ₹{{ \App\Helpers\SettingHelper::formatCurrency(
                                                            $invoice['sub_total'] ?? 0,
                                                            \App\Helpers\SettingHelper::getGenrealSettings('number_format'),
                                                        ) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td>DISCOUNT</td>
                                                    <td>{{ $invoice['discount'] ?? 0 }}%</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td>GRAND TOTAL</td>
                                                    <td>
                                                        ₹{{ \App\Helpers\SettingHelper::formatCurrency(
                                                            $invoice['amount'] ?? 0,
                                                            \App\Helpers\SettingHelper::getGenrealSettings('number_format'),
                                                        ) }}
                                                    </td>
                                                </tr>
                                            </tfoot>

                                        </table>

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
            const paperSize = "{{ $genrealSettings->paper_size ?? 'a4' }}";
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
