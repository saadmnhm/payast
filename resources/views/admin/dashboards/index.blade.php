<x-default-layout>

    @section('title')
        Tableau de bord
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 ">
            <!--begin::Card widget 20-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end  mb-5" style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Amount-->
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalContacts }}</span>
                        <!--end::Amount-->
                        <!--begin::Subtitle-->
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Contacts</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    <!--begin::Progress-->
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                        </div>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end::Card body-->
            </div>

            <div class="card card-flush  mb-5 ">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Amount-->
                        <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $totalArticles }}</span>
                        <!--end::Amount-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-500 pt-1 fw-semibold fs-6">Total articles</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <div class="card-body d-flex align-items-end pt-0">
                    <!--begin::Progress-->
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                        </div>
                    </div>
                    <!--end::Progress-->
                </div>
            </div>
        </div>

        <div class="col-xl-9">
            <!--begin::Card-->
            <div class="card card-flush h-xl-100">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Demandes récentes</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Les 7 dernières demandes de contact</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.contact.index') }}" class="btn btn-sm btn-light-primary">
                            <i class="ki-duotone ki-eye fs-2"></i>Voir tous les contacts
                        </a>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle gs-0 gy-4">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bold text-muted bg-light">
                                    <th class="ps-4 min-w-125px rounded-start">Client</th>
                                    <th class="min-w-125px">Contact</th>
                                    <th class="min-w-100px">lu</th>
                                    <th class="min-w-100px">Date</th>
                                    <th class="min-w-100px text-end rounded-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody>
                                @forelse($recentContacts as $contact)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="{{ route('apps.contact.show', $contact) }}" class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                                    {{ $contact->first_name }} {{ $contact->last_name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <a href="mailto:{{ $contact->email }}" class="text-dark fw-semibold text-hover-primary d-block fs-7">
                                                {{ $contact->email }}
                                            </a>
                                            <span class="text-muted fw-semibold text-muted d-block fs-7">
                                                {{ $contact->phone }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        @if($contact->is_read)
                                            <span class="badge badge-light-success fs-7 fw-bold">Lu</span>
                                        @else
                                            <span class="badge badge-light-warning fs-7 fw-bold">En attente</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $contact->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('apps.contact.show', $contact) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <i class="ki-duotone ki-eye fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Aucune demande de contact récente</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Card footer-->
                <div class="card-footer border-top p-3">
                    <a href="{{ route('apps.contact.index') }}" class="btn btn-sm btn-light-primary w-100">
                        Voir tous les contacts
                    </a>
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Row-->



</x-default-layout>
