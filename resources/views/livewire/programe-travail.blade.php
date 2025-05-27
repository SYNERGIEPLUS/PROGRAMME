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
                                        <td class="border px-4 py-2">{{ $jour['date'] }}</td>
                                        <td class="border px-4 py-2">{{ $jour['ctx'] }}</td>
                                        <td class="border px-4 py-2">{{ $jour['verif'] }}</td>
                                        <td class="border px-4 py-2 text-left">{{ implode(', ', $jour['generale']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="p-4 border-t flex justify-end">
                    <button wire:click="$set('showModalGenerer', false)" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    @endif

    <h3 class="text-lg font-semibold mb-4">Generer votre programme</h3>
    <ul class="divide-y">
        <li class="py-2">
            <a href="#" wire:click.prevent="genere" class="text-blue-600 hover:underline">
                Créer un programme de travail
            </a>
        </li>

        <li class="py-2">
            <a href="#" class="text-blue-600 hover:underline">Liste des programmes de travail</a>
        </li>
    </ul>
</div>
