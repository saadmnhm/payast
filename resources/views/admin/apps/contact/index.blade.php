<x-default-layout>
    @section('title')
        Demandes de contact
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.contact.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" id="kt_table_devis_search" class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher un devis">
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-devis-table-toolbar="base">


                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>Filtrer
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Options de filtrage</div>
                        </div>
                        <div class="separator border-gray-200"></div>

                        <!-- Filter form that submits to the server -->
                        <form action="{{ route('apps.contact.index') }}" method="GET">
                            <div class="px-7 py-5">
                                <div class="mb-10">
                                    <label class="form-label fw-semibold">Statut de lecture:</label>
                                    <div>
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-5">
                                            <input class="form-check-input" type="checkbox" name="filters[read_status][]" value="read"
                                                {{ in_array('read', $filters['read_status'] ?? ['read', 'unread']) ? 'checked' : '' }}/>
                                            <span class="form-check-label">Lu</span>
                                        </label>
                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="filters[read_status][]" value="unread"
                                                {{ in_array('unread', $filters['read_status'] ?? ['read', 'unread']) ? 'checked' : '' }}/>
                                            <span class="form-check-label">Non Lu</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('apps.contact.index') }}" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6">Réinitialiser</a>
                                    <button type="submit" class="btn btn-primary fw-semibold px-6">Appliquer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_devis">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th class="min-w-125px">Nom</th>
                            <th class="min-w-125px">Prénom</th>
                            <th class="min-w-125px">Email</th>
                            <th class="min-w-125px">Date</th>
                            <th class="min-w-125px">Lu</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @foreach($contact as $item)
                        <tr>

                            <td>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('apps.contact.show', $item) }}" class="text-gray-800 text-hover-primary mb-1">{{ $item->first_name }}</a>
                                </div>
                            </td>
                            <th>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('apps.contact.show', $item) }}" class="text-gray-800 text-hover-primary mb-1">{{ $item->last_name }}</a>
                                </div>
                            </th>
                            <td>
                                <div class="d-flex flex-column">
                                    <span>{{ $item->email }}</span>
                                </div>
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($item->is_read)
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-light-success me-2"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            title="Lu le {{ $item->read_at->format('d/m/Y à H:i') }}
                                            @if($item->readByUser) par {{ $item->readByUser->name }}@endif">
                                            Lu
                                        </span>
                                    </div>
                                @else
                                    <span class="badge badge-light-warning">Non lu</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('apps.contact.show', $item) }}" class="btn btn-light btn-active-light-primary btn-sm" >
                                    Consulter
                                </a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#kt_table_devis').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',                },
                responsive: true,
                order: [[5, 'desc']]
            });

            // Search functionality
            $('#kt_table_devis_search').on('keyup', function() {
                table.search($(this).val()).draw();
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>


    @endpush
</x-default-layout>
