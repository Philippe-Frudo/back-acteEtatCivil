<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;

class RegionController extends Controller
{

    protected $region;

    public function __construct()
    {
        $this->region = new Region();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->region->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $region = $this->region->where('code_region', $request->code_region)->first();

        if (!$region) {
            $response = $this->region->create($request->all());
            if (!$response) {
                return ['status' => false, 'message' => "Un erreur s'est produit lors d'enregistrement"];
            }
            return ['status' => true, 'message' => "Une nouvelle region a été ajouté"];
        }
        return ['status' => false, 'message' => 'Cette région existe déjà dans la base.'];
    }


    public function addAllRegion(Request $request)
    {
        $requests = json_decode($request->getContent(), true); // decodage du JSON

        $regionExist = [];
        $i = 0;
        foreach ($requests as $region) {
            $resp = Region::where('code_region', $region['code_region'])->first();
            if (!$resp) {
                Region::create([
                    'code_region' => $region['code_region'],
                    'nom_region' => $region['nom_region']
                ]);
            } else {
                $regionExist[$i] = $region['code_region'] . ' ' . $region['nom_region'];
                $i++;
            }
        }
        return response()->json(['status' => !empty($regionExist), 'rejeter' => $regionExist]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = $this->region->find($id);

        if (!$region) {
            return response()->json(['status' => false, 'message' => "Cette région n'existe pas"], 404);
        }
        return response()->json($region, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        // $region = $this->region->where('id_region', $id)->where('code_region', $request->code_region)->first();
        $region = $this->region->find($id);

        // Vérifier si l'enregistrement est trouvé
        if (!$region) {
            return response()->json(['status' => false, 'message' => 'Cette région est introuvable']);
        }

        // Mettre à jour le nom du region
        $region->update([
            'code_region' => $request->code_region,
            'nom_region' => $request->nom_region
        ]);

        return response()->json(['status' => true, 'message' => 'Modification réussi'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = $this->region->find($id);
        if (!$region) {
            return response()->json(['status' => false, 'message' => "region introuvable"], 404);
        }
        $region->delete();
        return response()->json(['status' => true, 'message' => "Suppression reuissi"], 200);
    }
}
