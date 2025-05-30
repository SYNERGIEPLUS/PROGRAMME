<div class="bg-white p-4 rounded shadow">

    @if($showModalGenerer)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
            <div class="bg-white w-full max-w-5xl mx-auto rounded shadow-md overflow-auto max-h-[90vh]">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Programme généré</h3>
                </div>

                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4 text-center">Programme de Travail (15 jours)</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse text-sm">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th class="border px-4 py-2">Date</th>
                                    <th class="border px-4 py-2">CTX</th>
                                    <th class="border px-4 py-2">Vérif du jour</th>
                                    <th class="border px-4 py-2">Service Générale</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($planning as $jour)
                                    <tr class="text-center hover:bg-gray-50">
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($jour['date'])->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</td>
                                        <td class="border px-4 py-2">{{ $personnes[$jour['ctx']] ?? $jour['ctx'] }}</td>
                                        <td class="border px-4 py-2">{{ $personnes[$jour['verif']] ?? $jour['verif'] }}</td>
                                        <td class="border px-4 py-2 text-left">
                                        @if (is_array($jour['generale']))
                                            @php
                                                $pairs = array_chunk($jour['generale'], 2);
                                            @endphp
                                            @foreach ($pairs as $pair)
                                                <div>
                                                    {{ implode(', ', array_map(fn($code) => $personnes[$code] ?? $code, $pair)) }}
                                                </div>
                                            @endforeach
                                        @else
                                            {{ $personnes[$jour['generale']] ?? $jour['generale'] }}
                                        @endif
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="p-4 border-t flex justify-end space-x-2">
                    <button
                        wire:click="save"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition duration-150"
                    >
                        Enregistrer
                    </button>

                    <button
                        wire:click="fermerModal"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium transition duration-150"
                    >
                        Fermer
                    </button>
                </div>

            </div>
        </div>
    @endif

    <h3 class="text-lg font-semibold mb-4">Generer votre programme</h3>
    <ul class="divide-y">
        <li class="py-4">
            <div class="bg-white  rounded-lg p-4 space-y-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date de début</label>
                    <input type="date" id="date" wire:model="Date" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <div class="mb-2">
                        <label class="block text-sm font-medium">Nom du programme</label>
                        <input type="text" wire:model="groupe" class="w-full border rounded px-3 py-2" placeholder="Ex: Programme A">
                        <p class="text-xs text-gray-500 mt-1">Garder le champ vide par defaut pour que le programme génère un nom automatiquement</p>
                        <p class="text-xs text-gray-500 mt-1">Ex : Programme du 20-06-2025</p>
                    </div>
                </div>

                <div class="text-right">

                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <button onclick="location.reload()"
                                class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-md shadow-sm">
                                🔄 Actualiser
                            </button>


                            <button wire:click.prevent="genere"
                                class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17v-6h13M9 11V5m0 6l-2.5-2.5M9 11l2.5-2.5" />
                                </svg>
                                Générer le programme
                            </button>
                        </div>

                </div>
            </div>
        </li>


        <li class="py-2">

            <div class="max-h-40 overflow-y-auto border rounded px-2 py-1">
                <ul class="space-y-2">
                    @foreach($groupes as $groupe)
                        <li class="py-2 flex justify-between items-center">
                            <div>
                                <a href="#" wire:click.prevent="voirGroupe('{{ $groupe }}')" class="text-blue-600 hover:underline">
                                    Voir le programme : {{ $groupe }}
                                </a>
                            </div>
                            <form action="{{ route('imprimer_programme.etats') }}" method="GET" target="_blank">
                                <input type="hidden" name="groupe" value="{{ $groupe }}">
                                <button id="btnImprimer" class="text-red-600 hover:underline text-sm">
                                    <i class="fa fa-print fa-lg mr-2"></i>
                                    <span>Imprimer PDF</span>
                                </button>
                            </form>
                            <button
                                wire:click="confirmerSuppression('{{ $groupe }}')"
                                class="text-red-600 hover:underline text-sm"
                            >
                                Supprimer
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>



            {{-- Modal --}}
            @if($showModalDetails)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white rounded shadow-lg max-w-4xl w-full p-6 overflow-y-auto max-h-[80vh] relative">
                    {{-- Bouton fermeture en haut à droite --}}
                    <button 
                        wire:click="$set('showModalDetails', false)" 
                        class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 focus:outline-none"
                        aria-label="Fermer le modal"
                        title="Fermer"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h2 class="text-xl font-bold mb-4">Programme : {{ $groupeSelectionne }}</h2>

                    <table class="w-full table-auto border-collapse">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">Date</th>
                                <th class="border px-4 py-2">CTX</th>
                                <th class="border px-4 py-2">Vérif du jour</th>
                                <th class="border px-4 py-2">Service Générale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($planningGroupe as $item)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item['date'])->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</td>
                                    <td class="border px-4 py-2">{{ $personnes[$item['ctx']] ?? $item['ctx'] }}</td>
                                    <td class="border px-4 py-2">{{ $personnes[$item['verif']] ?? $item['verif'] }}</td>
                                    <td class="border px-4 py-2 text-left">
                                        @if (is_array($item['generale']))
                                            @php
                                                $pairs = array_chunk($item['generale'], 2);
                                            @endphp
                                            @foreach ($pairs as $pair)
                                                <div>
                                                    {{ implode(', ', array_map(fn($code) => $personnes[$code] ?? $code, $pair)) }}
                                                </div>
                                            @endforeach
                                        @else
                                            {{ $personnes[$item['generale']] ?? $item['generale'] }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 text-right">
                        <button wire:click="$set('showModalDetails', false)" class="bg-gray-300 px-4 py-2 rounded">Fermer</button>
                    </div>
                </div>
            </div>
            @endif

        </li>
    </ul>
</div>
