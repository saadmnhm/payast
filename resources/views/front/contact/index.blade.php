@extends('front.layout')

@section('title_front', 'Contactez nous sur pyassat')


@section('content')

<div class="contact-page">

    <section class="contact-header py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-dark mb-3">Contactez-nous</h1>
                    <p class="lead text-muted">
                        Notre équipe est à votre disposition pour répondre à toutes vos questions concernant nos pièces automobiles.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('assets/site/image/contact-illustration.png') }}" 
                         alt="Contact" 
                         class="img-fluid"
                         onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </section>

    <section class="contact-info py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-info-card text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-phone fa-3x text-primary"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Téléphone</h3>
                        <p class="text-muted mb-2">Du lundi au samedi</p>
                        <p class="text-muted mb-2">9h00 - 18h00</p>
                        <a href="tel:+2125XXXXXXXX" class="text-dark fw-bold">+212 5XX-XXXXXX</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-info-card text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-envelope fa-3x text-primary"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Email</h3>
                        <p class="text-muted mb-2">Réponse sous 24h</p>
                        <p class="text-muted mb-2">7j/7</p>
                        <a href="mailto:contact@piassat.ma" class="text-dark fw-bold">contact@piassat.ma</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-info-card text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-map-marker-alt fa-3x text-primary"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Adresse</h3>
                        <p class="text-muted mb-2">Visitez notre magasin</p>
                        <p class="text-muted mb-2">Casablanca, Maroc</p>
                        <a href="#map" class="text-dark fw-bold">Voir sur la carte</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-form-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <h2 class="h3 fw-bold mb-4 text-center">Envoyez-nous un message</h2>
                            <p class="text-muted text-center mb-5">
                                Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais
                            </p>

                            <form id="contactForm" method="POST" action="">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label fw-semibold">
                                            Prénom <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control " 
                                               id="first_name" 
                                               name="first_name" 
                                               placeholder="Votre prénom"
                                               required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label fw-semibold">
                                            Nom <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control " 
                                               id="last_name" 
                                               name="last_name" 
                                               placeholder="Votre nom"
                                               required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" 
                                               class="form-control " 
                                               id="email" 
                                               name="email" 
                                               placeholder="votre@email.com"
                                               required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold">
                                            Téléphone <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" 
                                               class="form-control " 
                                               id="phone" 
                                               name="phone" 
                                               placeholder="+212 6XX-XXXXXX"
                                               required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12">
                                        <label for="message" class="form-label fw-semibold">
                                            Message <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control " 
                                                  id="message" 
                                                  name="message" 
                                                  rows="5" 
                                                  placeholder="Décrivez votre demande..."
                                                  required></textarea>
                                        <div class="invalid-feedback"></div>
                                        <div class="form-text">Minimum 10 caractères</div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            <span class="btn-text">Envoyer le message</span>
                                            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="map-section py-5" id="map">
        <div class="container">
            <h2 class="h3 fw-bold text-center mb-5">Nous trouver</h2>
            <div class="map-wrapper rounded overflow-hidden shadow">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d106492.07643396744!2d-7.6814852!3d33.5731104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda7cd4778aa113b%3A0xb06c1d84f310fd3!2sCasablanca!5e0!3m2!1sfr!2sma!4v1234567890"
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.spinner-border');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        submitBtn.disabled = true;
        btnText.textContent = 'Envoi en cours...';
        spinner.classList.remove('d-none');

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Message envoyé !',
                    text: data.message,
                    confirmButtonText: 'D\'accord',
                    confirmButtonColor: '#e31e24'
                });

                form.reset();
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const input = form.querySelector(`[name="${key}"]`);
                        const feedback = input.nextElementSibling;
                        
                        input.classList.add('is-invalid');
                        if (feedback && feedback.classList.contains('invalid-feedback')) {
                            feedback.textContent = data.errors[key][0];
                        }
                    });
                }
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Une erreur est survenue. Veuillez réessayer.',
                confirmButtonText: 'D\'accord',
                confirmButtonColor: '#e31e24'
            });
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Envoyer le message';
            spinner.classList.add('d-none');
        }
    });

    const inputs = form.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const feedback = this.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                }
            }
        });
    });
});
</script>



@endsection