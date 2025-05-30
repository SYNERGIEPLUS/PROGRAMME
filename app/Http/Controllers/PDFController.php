<?php

namespace App\Http\Controllers;
use PDF; // Assurez-vous que la bibliothèque PDF est correctement importée


use Illuminate\Http\Request;
use App\Models\ProgrammeTravail; // Assurez-vous que le modèle est correctement importé

class PDFController extends Controller
{
    //
    /**
     * Génère un PDF à partir des données du programme de travail.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public $groupe;

    public function generatePDF_Programme(Request $request)
    {
        $groupe = $request->input('groupe'); 

        // Récupère les données de la table
        $planning = ProgrammeTravail::where('groupe', $groupe)
                    ->orderBy('date', 'asc') // ou 'desc' pour décroissant
                    ->get();


        // Envoie à la vue avec les données attendues
        $pdf = PDF::loadView('pdf.etat_programme', [
            'planning' => $planning,
            'groupe' => $groupe
        ]);

        return $pdf->stream("{$groupe}.pdf");
    }

}
