<x-default-layout>
    @section('title')
        Détail du contact #{{ $contact->id }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.contact.show', $contact) }}
    @endsection
    <div class="container">
        <div class="row">
            <!-- Main content column - reduced width -->
            <div class="col-xl-12 col-lg-10 col-md-12">
                <div class="card mb-5">
                <!-- Add this inside the card-header section, right after the contact creation date -->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">Détails du contact</span>
                        <span class="text-gray-500 mt-1 fw-semibold fs-6">Demande reçue le {{ $contact->created_at->format('d/m/Y à H:i') }}</span>

                        <!-- Read status indicator -->
                        @if($contact->is_read)
                            <span class="badge badge-light-success mt-2">
                                <i class="ki-duotone ki-eye text-success fs-6 me-1"></i>
                                Lu le {{ $contact->read_at->format('d/m/Y à H:i') }}  par {{ $contact->readByUser->name }}

                            </span>
                        @else
                            <span class="badge badge-light-warning mt-2">
                                <i class="ki-duotone ki-eye-slash text-warning fs-6 me-1"></i>
                                Non lu
                            </span>
                        @endif
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.contact.index') }}" class="btn btn-sm btn-light">
                            <i class="ki-duotone ki-arrow-left fs-2"></i> Retour à la liste
                        </a>
                    </div>
                </div>

                    <div class="card-body pt-9 pb-0">
                        <!-- Client Information -->
                        <div class="mb-7">
                            <h4 class="fw-bold text-gray-800 mb-5">1. Information De Client</h4>

                            <div class="row mb-7">
                                <div class="col-lg-6">
                                    <div class="fw-semibold fs-6 text-gray-600">Nom et Prénom</div>
                                    <div class="fs-4 fw-bold text-gray-900">{{ $contact->first_name }} {{ $contact->last_name }}</div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="fw-semibold fs-6 text-gray-600">Email</div>
                                    <div class="fs-4 fw-bold text-gray-900">
                                        <a href="mailto:{{ $contact->email }}" class="text-gray-900 text-hover-primary">
                                            {{ $contact->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-lg-6">
                                    <div class="fw-semibold fs-6 text-gray-600">Téléphone</div>
                                    <div class="fs-4 fw-bold text-gray-900">
                                        <a href="tel:{{ $contact->phone }}" class="text-gray-900 text-hover-primary">
                                            {{ $contact->phone }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-5"></div>

                        <!-- Project Information -->
                        <div class="mb-7">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="fw-semibold fs-6 text-gray-600">Message</div>
                                    <div class="fs-6 text-gray-800 rounded bg-light p-5 mt-2">
                                        {{ $contact->message ?: 'Aucune description fournie' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Quick Actions Card -->
                <div class="card card-flush mb-5">
                    <div class="card-header">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900">Statut du contact</span>
                        </h3>
                    </div>
                    <div class="card-body pt-3">
                        <div class="d-flex flex-wrap gap-3">
                            <a href="mailto:{{ $contact->email }}" class="btn btn-light-primary btn-flex fw-bold">
                                <i class="ki-duotone ki-message-text-2 fs-4 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>Envoyer un email
                            </a>

                            <a href="tel:{{ $contact->phone }}" class="btn btn-light-success btn-flex fw-bold">
                                <i class="ki-duotone ki-phone fs-4 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>Appeler le client
                            </a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-default-layout>
