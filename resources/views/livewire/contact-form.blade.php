<div>
    @if($submitted)
        <div class="border-l-4 border-turquoise bg-turquoise-tint p-6" role="status">
            <h3 class="font-display text-lg font-semibold text-navy">Merci, votre demande a bien été envoyée</h3>
            <p class="mt-2 text-[15px] text-navy/80">
                Nous revenons vers vous sous 48h ouvrées avec un premier retour sur votre projet.
            </p>
        </div>
    @else
        <form wire:submit="submit" novalidate>
            <div class="mb-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-1.5 block text-sm font-bold text-navy">Nom &amp; Prénom <span class="text-red-600">*</span></label>
                    <input type="text" id="name" wire:model="name" required autocomplete="name" placeholder="Ex. Jean Dupont"
                           class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 transition-colors focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"
                           style="min-height:44px">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-bold text-navy">Numéro de téléphone <span class="text-red-600">*</span></label>
                    <input type="tel" id="phone" wire:model="phone" required autocomplete="tel" placeholder="Ex. 06 12 34 56 78"
                           class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 transition-colors focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"
                           style="min-height:44px">
                    <p class="mt-1.5 text-xs text-navy/60">Utilisé exclusivement pour convenir d'un rendez-vous technique.</p>
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-bold text-navy">Adresse email</label>
                    <input type="email" id="email" wire:model="email" autocomplete="email" placeholder="Ex. jean.dupont@email.fr"
                           class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 transition-colors focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"
                           style="min-height:44px">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="city" class="mb-1.5 block text-sm font-bold text-navy">Ville du projet</label>
                    <input type="text" id="city" wire:model="city" autocomplete="address-level2" placeholder="Ex. Argenteuil"
                           class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 transition-colors focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"
                           style="min-height:44px">
                </div>
            </div>

            <div class="mb-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="propertyType" class="mb-1.5 block text-sm font-bold text-navy">Type de bien</label>
                    <select id="propertyType" wire:model="propertyType"
                            class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy transition-colors focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"
                            style="min-height:44px">
                        <option value="">Sélectionnez une option</option>
                        @foreach(\App\Models\ContactRequest::PROPERTY_TYPES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('propertyType') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="surface" class="mb-1.5 block text-sm font-bold text-navy">Surface approximative (m²)</label>
                    <input type="text" inputmode="numeric" id="surface" wire:model="surface" placeholder="Ex. 85"
                           class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 transition-colors focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"
                           style="min-height:44px">
                    @error('surface') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="message" class="mb-1.5 block text-sm font-bold text-navy">Description du projet ou contraintes particulières</label>
                <textarea id="message" wire:model="message" rows="4" placeholder="Précisez votre adresse, dimensions approximatives, présence d'une baignoire existante à déposer, besoins de barres d'appui…"
                          class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 transition-colors focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"></textarea>
            </div>

            <label for="consent" class="mb-4 flex cursor-pointer items-start gap-3 border-l-4 border-stone/30 pl-4 has-[:checked]:border-turquoise">
                <input type="checkbox" id="consent" wire:model="consent"
                       class="mt-0.5 h-5 w-5 shrink-0 rounded-sm border-2 border-stone/50 accent-turquoise-dark focus:ring-turquoise-dark focus:ring-offset-0">
                <span class="text-[14px] leading-relaxed text-navy/80">
                    J'accepte d'être recontacté(e) par CONFOR'INO au sujet de ma demande.
                </span>
            </label>
            @error('consent') <p class="-mt-3 mb-4 text-sm text-red-600">{{ $message }}</p> @enderror

            <div class="mb-6 space-y-2 text-xs leading-relaxed text-navy/60">
                <p>Pour une demande d’adaptation du logement au vieillissement ou au handicap, le rappel intervient dans les cinq jours ouvrables et reste limité aux prestations demandées. Tout autre démarchage téléphonique suppose votre consentement préalable, sauf dans le cadre d’un contrat en cours.</p>
                <p>Ce formulaire ne vaut pas consentement à recevoir d’autres appels commerciaux.</p>
                <p>CONFOR’INO utilise vos données pour traiter votre demande, vous rappeler et préparer, le cas échéant, un devis. Les champs marqués d’un astérisque sont obligatoires. Consultez notre <a href="{{ route('page.show', 'politique-de-confidentialite') }}" class="underline hover:text-turquoise-dark">politique de confidentialité</a> pour connaître les destinataires, les durées de conservation et vos droits.</p>
                <p>Merci de ne transmettre aucune information médicale détaillée.</p>
            </div>

            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove>Envoyer ma demande</span>
                <span wire:loading>Envoi en cours…</span>
            </button>
        </form>
    @endif
</div>
