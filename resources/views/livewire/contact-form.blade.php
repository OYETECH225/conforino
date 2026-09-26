<div>
    @if($submitted)
        <div class="rounded-sm border border-turquoise/40 bg-turquoise-tint p-6" role="status">
            <h3 class="font-display text-lg font-semibold text-navy">Merci, votre demande a bien été envoyée</h3>
            <p class="mt-2 text-[15px] text-navy/80">
                Nous revenons vers vous sous 48h ouvrées avec un premier retour sur votre projet.
            </p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5" novalidate>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-navy">Nom et prénom *</label>
                    <input type="text" id="name" wire:model="name" required
                           class="mt-1 w-full rounded-sm border border-stone/40 px-3 py-2 text-[16px] text-navy focus:border-turquoise-dark"
                           style="min-height:44px">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-navy">Téléphone *</label>
                    <input type="tel" id="phone" wire:model="phone" required
                           class="mt-1 w-full rounded-sm border border-stone/40 px-3 py-2 text-[16px] text-navy focus:border-turquoise-dark"
                           style="min-height:44px">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-navy">Email</label>
                    <input type="email" id="email" wire:model="email"
                           class="mt-1 w-full rounded-sm border border-stone/40 px-3 py-2 text-[16px] text-navy focus:border-turquoise-dark"
                           style="min-height:44px">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-navy">Ville du projet</label>
                    <input type="text" id="city" wire:model="city"
                           class="mt-1 w-full rounded-sm border border-stone/40 px-3 py-2 text-[16px] text-navy focus:border-turquoise-dark"
                           style="min-height:44px">
                </div>
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-navy">Décrivez votre projet</label>
                <textarea id="message" wire:model="message" rows="4"
                          class="mt-1 w-full rounded-sm border border-stone/40 px-3 py-2 text-[16px] text-navy focus:border-turquoise-dark"></textarea>
            </div>

            <div class="flex items-start gap-3">
                <input type="checkbox" id="consent" wire:model="consent"
                       class="mt-1 h-5 w-5 rounded-sm border-stone/50 text-turquoise focus:ring-turquoise-dark">
                <label for="consent" class="text-[14px] text-navy/80">
                    J'accepte d'être recontacté(e) par CONFOR'INO au sujet de ma demande.
                    Aucune information médicale ne doit être transmise via ce formulaire.
                </label>
            </div>
            @error('consent') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

            <button type="submit" class="btn-primary w-full sm:w-auto" wire:loading.attr="disabled">
                <span wire:loading.remove>Envoyer ma demande</span>
                <span wire:loading>Envoi en cours…</span>
            </button>
        </form>
    @endif
</div>
