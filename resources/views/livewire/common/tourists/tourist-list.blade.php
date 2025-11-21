<div class="container mt-sm-0 mt-3">

    <div class="page-header d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
            <h6 class="breadcrumb-title pe-2 fs-24  border-0 text-black fw-600">{{ $pageTitle }} </h6>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
            </nav>
        </div>
         <a href="{{ route($route . '.tourist-create') }}" class="btn bluegradientbtn">
            <i class="bx bx-plus me-1"></i> Add New Tourist
        </a>
    </div>

    <div class="card border-0 shadow-sm radius12 overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <div class="position-relative">
                <input type="text" class="form-control ps-5" placeholder="Search Tourists..."
                    wire:model.live.debounce.300ms="search">
                <span class="position-absolute product-show translate-middle-y">
                    <i class="bx bx-search"></i>
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 tableminwidth">
                    <thead class="lightgradient">
                        <tr>
                            <th class="tableheadingcolor px-3 py-2">Name</th>
                            <th class="tableheadingcolor px-3 py-2">Contact</th>
                            <th class="tableheadingcolor px-3 py-2">Email Id</th>
                            <th class="tableheadingcolor px-3 py-2">Birthday</th>
                            <th class="tableheadingcolor px-3 py-2 width80">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $index => $item)
                            <tr class="table-bottom-border transition2" wire:key="{{ $item->id }}">
                                <td class="px-3 py-1">
                                    <span class="text-dark">{{ $item->primary_contact }}</span>
                                </td>
                                <td class="px-3 py-1">
                                    <span class="fw-500 text-dark">{{ $item->contact_phone ?? 'NA' }}</span>
                                </td>
                                <td class="px-3 py-1">
                                    {{ $item->contact_email ?? 'NA' }}
                                </td>
                                <td class="px-3 py-1">
                                    {{ $item->birthday
                                        ? \Carbon\Carbon::parse($item->birthday)->format(
                                            App\Helpers\SettingHelper::getGenrealSettings('date_format') ?? 'd M Y',
                                        )
                                        : 'NA' }}
                                </td>
                                <td class="text-center px-3 py-1">
                                    <a href="{{ route($route . '.tourist-edit', $item->id) }}" title="Edit">
                                        <i class="bx bx-edit text-dark fs-5"></i>
                                    </a>
                                    <a href="{{ route($route . '.view-tourist', $item->id) }}" title="Edit">
                                        <i class="lni lni-eye  text-dark fs-5"></i>
                                    </a>
                                    <a href="javascript:void(0)" wire:click="confirmDelete({{ $item->id }})"
                                        title="Delete">
                                        <i class="bx bx-trash text-danger fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center py-4 darkgreytext">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bx bx-data fs-1 mb-2 lightgreyicon"></i>
                                        <span>No Tourist's found. Click "Add New Tourist" to create one.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
           @if ($items->hasPages() || $items->total() > 0)
                <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center py-3 gap-2">
                    <div class="d-flex align-items-center">
                        <label class="me-2 mb-0 small text-muted">Show</label>
                        <select wire:model.live="perPage" class="form-select form-select-sm w-auto">
                            <option value="10">10</option>
                             <option value="15">15</option>
                            <option value="50">50</option>
                            <option value="50">100</option>
                            <option value="50">200</option>
                        </select>
                        <span class="ms-2 small text-muted">entries</span>
                    </div>
                    <div>
                        {{ $items->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
