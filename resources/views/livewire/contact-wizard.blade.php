@php
    $stepLabels = ['Votre projet', 'Vos coordonnées', 'Créneau souhaité', 'Détails & photos'];
@endphp

<div>
    @if($submitted)
        <div class="border-l-4 border-turquoise bg-turquoise-tint p-6" role="status">
            <h3 class="font-display text-lg font-semibold text-navy">Merci, votre demande de visite technique a bien été envoyée</h3>
            <p class="mt-2 text-[15px] text-navy/80">
                Un technicien CONFOR'INO valide votre créneau par téléphone avant toute venue. Réponse sous 48h ouvrées.
            </p>
        </div>
    @else
        <div class="mb-8 flex items-center justify-between gap-2">
            @foreach($stepLabels as $index => $label)
                @php $n = $index + 1; @endphp
                <div class="flex flex-1 flex-col items-center gap-2 text-center">
                    <button
                        type="button"
                        wire:click="goToStep({{ $n }})"
                        @class([
                            'flex h-9 w-9 items-center justify-center rounded-full font-display text-sm font-bold transition-colors',
                            'bg-turquoise text-white' => $step === $n,
                            'bg-navy-deep text-white' => $step > $n,
                            'bg-navy-tint text-navy/50' => $step < $n,
                        ])
                        @if($step <= $n) disabled @endif
                    >
                        @if($step > $n)
                            <x-brand-icon name="check" class="h-4 w-4" />
                        @else
                            {{ $n }}
                        @endif
                    </button>
                    <span class="hidden text-xs font-medium {{ $step === $n ? 'text-navy' : 'text-navy/50' }} sm:block">{{ $label }}</span>
                </div>
                @if(!$loop->last)
                    <div class="h-px flex-1 {{ $step > $n ? 'bg-navy-deep' : 'bg-navy-tint' }}" style="margin-top:-20px"></div>
                @endif
            @endforeach
        </div>

        <form wire:submit="{{ $step === 4 ? 'submit' : 'nextStep' }}" novalidate>
            @if($step === 1)
                <div>
                    <p class="mb-3 text-sm font-bold text-navy">Votre projet & besoins d'aménagement</p>
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach($services as $service)
                            <button
                                type="button"
                                wire:click="$set('serviceId', {{ $service->id }})"
                                class="flex items-start gap-3 border-2 p-4 text-left transition-colors {{ $serviceId === $service->id ? 'border-turquoise-dark bg-turquoise-tint' : 'border-stone/25 bg-white hover:border-turquoise-dark/40' }}"
                                style="min-height:44px"
                            >
                                <x-brand-icon :name="$service->icon" class="h-5 w-5 shrink-0 text-turquoise-dark" />
                                <span class="text-[15px] font-medium text-navy">{{ $service->title }}</span>
                            </button>
                        @endforeach
                    </div>
                    @error('serviceId') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                    <p class="mb-3 mt-6 text-sm font-bold text-navy">Pour qui effectuez-vous cette demande ?</p>
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach(\App\Models\ContactRequest::BENEFICIARY_TYPES as $value => $label)
                            <button
                                type="button"
                                wire:click="$set('beneficiaryType', '{{ $value }}')"
                                class="border-2 p-4 text-left text-[15px] font-medium text-navy transition-colors {{ $beneficiaryType === $value ? 'border-turquoise-dark bg-turquoise-tint' : 'border-stone/25 bg-white hover:border-turquoise-dark/40' }}"
                                style="min-height:44px"
                            >
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                    @error('beneficiaryType') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif

            @if($step === 2)
                <div class="space-y-5">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-bold text-navy">Nom & prénom <span class="text-red-600">*</span></label>
                            <input type="text" wire:model="name" placeholder="Ex. Jean Dupont"
                                   class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark" style="min-height:44px">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-bold text-navy">Téléphone direct <span class="text-red-600">*</span></label>
                            <input type="tel" wire:model="phone" placeholder="Ex. 06 12 34 56 78"
                                   class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark" style="min-height:44px">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-bold text-navy">Adresse e-mail</label>
                            <input type="email" wire:model="email" placeholder="Ex. jean.dupont@email.fr"
                                   class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark" style="min-height:44px">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-bold text-navy">Ville & code postal</label>
                            <input type="text" wire:model="city" placeholder="Ex. Argenteuil, 95100"
                                   class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark" style="min-height:44px">
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-navy">Adresse précise du logement</label>
                        <input type="text" wire:model="address" placeholder="N°, rue, bâtiment, étage, digicode..."
                               class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark" style="min-height:44px">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-navy">Type de bien</label>
                        <select wire:model="propertyType" class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark" style="min-height:44px">
                            <option value="">Sélectionnez une option</option>
                            @foreach(\App\Models\ContactRequest::PROPERTY_TYPES as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            @if($step === 3)
                <div class="space-y-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-navy">Jour préférentiel</label>
                        <input type="text" wire:model="preferredDay" placeholder="Ex. Au plus tôt, ou une date précise"
                               class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark" style="min-height:44px">
                        <p class="mt-1.5 text-xs text-navy/60">Un technicien confirme le créneau exact avec vous par téléphone.</p>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-navy">Plage horaire adaptée</label>
                        <select wire:model="preferredTimeSlot" class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark" style="min-height:44px">
                            <option value="">Sélectionnez une option</option>
                            @foreach(\App\Models\ContactRequest::TIME_SLOTS as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            @if($step === 4)
                <div class="space-y-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-navy">Description du chantier & contraintes</label>
                        <textarea wire:model="message" rows="4" placeholder="Ex. baignoire actuelle en fonte à remplacer par une douche de plain-pied, présence d'une marche difficile à enjamber…"
                                  class="w-full border-0 bg-navy-tint/60 px-3.5 py-2.5 text-[16px] text-navy placeholder:text-navy/40 focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"></textarea>
                        @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-navy">Photos du chantier (optionnel)</label>
                        <label class="flex cursor-pointer flex-col items-center gap-2 border-2 border-dashed border-stone/40 bg-navy-tint/40 px-4 py-8 text-center hover:border-turquoise-dark">
                            <x-brand-icon name="quote" class="h-6 w-6 text-turquoise-dark" />
                            <span class="text-sm font-medium text-navy">Sélectionner des fichiers sur mon appareil</span>
                            <span class="text-xs text-navy/60">JPG, PNG jusqu'à 8 Mo par photo, 5 photos maximum</span>
                            <input type="file" wire:model="photos" multiple accept="image/*" class="sr-only">
                        </label>
                        <div wire:loading wire:target="photos" class="mt-2 text-sm text-navy/60">Envoi en cours…</div>
                        @error('photos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @error('photos.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                        @if(!empty($photos))
                            <ul class="mt-3 space-y-2">
                                @foreach($photos as $index => $photo)
                                    <li class="flex items-center justify-between gap-3 bg-navy-tint/60 px-3 py-2 text-sm text-navy">
                                        <span class="truncate">{{ $photo->getClientOriginalName() }}</span>
                                        <button type="button" wire:click="removePhoto({{ $index }})" class="shrink-0 font-semibold text-red-600" aria-label="Retirer cette photo">Retirer</button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <label class="flex cursor-pointer items-start gap-3 border-l-4 border-stone/30 pl-4 has-[:checked]:border-turquoise">
                        <input type="checkbox" wire:model="consent"
                               class="mt-0.5 h-5 w-5 shrink-0 rounded-sm border-2 border-stone/50 accent-turquoise-dark focus:ring-turquoise-dark focus:ring-offset-0">
                        <span class="text-[14px] leading-relaxed text-navy/80">
                            J'accepte d'être recontacté(e) par CONFOR'INO au sujet de ma demande.
                        </span>
                    </label>
                    @error('consent') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                    <div class="space-y-2 text-xs leading-relaxed text-navy/60">
                        <p>Pour une demande d’adaptation du logement au vieillissement ou au handicap, le rappel intervient dans les cinq jours ouvrables et reste limité aux prestations demandées. Tout autre démarchage téléphonique suppose votre consentement préalable, sauf dans le cadre d’un contrat en cours.</p>
                        <p>Ce formulaire ne vaut pas consentement à recevoir d’autres appels commerciaux.</p>
                        <p>CONFOR’INO utilise vos données pour traiter votre demande, vous rappeler et préparer, le cas échéant, un devis. Les champs marqués d’un astérisque sont obligatoires. Consultez notre <a href="{{ route('page.show', 'politique-de-confidentialite') }}" class="underline hover:text-turquoise-dark">politique de confidentialité</a> pour connaître les destinataires, les durées de conservation et vos droits.</p>
                        <p>Merci de ne transmettre aucune information médicale détaillée.</p>
                    </div>
                </div>
            @endif

            <div class="mt-8 flex items-center justify-between gap-3">
                @if($step > 1)
                    <button type="button" wire:click="previousStep" class="inline-flex items-center justify-center gap-2 rounded-sm bg-navy-tint px-6 font-medium text-navy transition-colors hover:bg-navy-tint/70" style="min-height:44px">
                        ← Retour
                    </button>
                @else
                    <span></span>
                @endif

                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="nextStep,submit,photos">
                    <span wire:loading.remove wire:target="nextStep,submit">
                        {{ $step === 4 ? 'Valider ma demande de visite technique gratuite' : 'Suivant →' }}
                    </span>
                    <span wire:loading wire:target="nextStep,submit">Envoi en cours…</span>
                </button>
            </div>
        </form>

        <p class="mt-6 flex items-center gap-2 text-xs text-navy/60">
            <x-brand-icon name="shield" class="h-4 w-4 shrink-0 text-turquoise-dark" />
            Confidentialité totale : vos coordonnées sont strictement réservées à l'équipe technique de CONFOR'INO.
        </p>
    @endif
</div>
