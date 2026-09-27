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
            <div class="mb-5">
                <label for="name" class="mb-1.5 block text-sm font-medium text-navy">Nom et prénom <span class="text-turquoise-dark">*</span></label>
                <div class="relative">
                    <x-brand-icon name="user" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-stone" />
                    <input type="text" id="name" wire:model="name" required autocomplete="name"
                           class="w-full border border-stone/40 bg-navy-tint/40 py-2.5 pl-11 pr-3 text-[16px] text-navy transition-colors focus:border-turquoise-dark focus:bg-white"
                           style="min-height:44px">
                </div>
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-medium text-navy">Téléphone <span class="text-turquoise-dark">*</span></label>
                    <div class="relative">
                        <x-brand-icon name="phone" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-stone" />
                        <input type="tel" id="phone" wire:model="phone" required autocomplete="tel"
                               class="w-full border border-stone/40 bg-navy-tint/40 py-2.5 pl-11 pr-3 text-[16px] text-navy transition-colors focus:border-turquoise-dark focus:bg-white"
                               style="min-height:44px">
                    </div>
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-navy">Email</label>
                    <div class="relative">
                        <x-brand-icon name="mail" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-stone" />
                        <input type="email" id="email" wire:model="email" autocomplete="email"
                               class="w-full border border-stone/40 bg-navy-tint/40 py-2.5 pl-11 pr-3 text-[16px] text-navy transition-colors focus:border-turquoise-dark focus:bg-white"
                               style="min-height:44px">
                    </div>
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-5">
                <label for="city" class="mb-1.5 block text-sm font-medium text-navy">Ville du projet</label>
                <div class="relative">
                    <x-brand-icon name="pin" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-stone" />
                    <input type="text" id="city" wire:model="city" autocomplete="address-level2"
                           class="w-full border border-stone/40 bg-navy-tint/40 py-2.5 pl-11 pr-3 text-[16px] text-navy transition-colors focus:border-turquoise-dark focus:bg-white"
                           style="min-height:44px">
                </div>
            </div>

            <div class="mb-6">
                <label for="message" class="mb-1.5 block text-sm font-medium text-navy">Décrivez votre projet</label>
                <div class="relative">
                    <x-brand-icon name="message" class="pointer-events-none absolute left-3 top-3 h-5 w-5 text-stone" />
                    <textarea id="message" wire:model="message" rows="4"
                              class="w-full border border-stone/40 bg-navy-tint/40 py-2.5 pl-11 pr-3 text-[16px] text-navy transition-colors focus:border-turquoise-dark focus:bg-white"></textarea>
                </div>
            </div>

            <label for="consent" class="mb-6 flex cursor-pointer items-start gap-3 border-l-4 border-stone/30 pl-4 has-[:checked]:border-turquoise">
                <input type="checkbox" id="consent" wire:model="consent"
                       class="mt-0.5 h-5 w-5 shrink-0 rounded-sm border-2 border-stone/50 accent-turquoise-dark focus:ring-turquoise-dark focus:ring-offset-0">
                <span class="text-[14px] leading-relaxed text-navy/80">
                    J'accepte d'être recontacté(e) par CONFOR'INO au sujet de ma demande.
                    Aucune information médicale ne doit être transmise via ce formulaire.
                </span>
            </label>
            @error('consent') <p class="-mt-4 mb-6 text-sm text-red-600">{{ $message }}</p> @enderror

            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove>Envoyer ma demande</span>
                <span wire:loading>Envoi en cours…</span>
            </button>
        </form>
    @endif
</div>
