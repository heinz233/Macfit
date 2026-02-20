<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gym;
class GymController extends Controller
{
    // Create roles
    public function createGym(Request $request){
        $validated = $request->validate([
            'name'=>'required|string',
            'longitude'=>'required|string',
            'latitude'=>'required|string',
            'description'=>'nullable|string|max:1000',
            ]);
            $gym = new Gym();
            $gym->name = $validated['name'];
            $gym->longitude = $validated['name'];
            $gym->latitude = $validated['name'];
            $gym->description = $validated['description'];

            try{
                $createdGym = $gym->save();
                return response()->json($gym);
            }
            catch(\Exception $exception){
                return response()->json(
                    ['error'=>'Failed to save gym',
                    'message'=> $exception->getMessage()
                ]);
            }
    }

    // Read all roles
    public function readAllGyms(){
        try{
            $roles = Gym::all();
            return response()->json($roles);
            }
            catch(\Exception $exception){
                return response()->json([
                    'error'=> 'Failed to fetch roles',
                    'message'=> $exception->getMessage()
                ]);
            }
    }

    public function readGym($id){
        try {
            $gym = Gym::findOrFail($id);
            return response()->json($gym);
        }
        catch(\Exception $exception){
                return response()->json([
                    'error'=> 'Failed to fetch the gym with ID: ',&$id,
                    'message'=> $exception->getMessage()
                ]);
            }
    }
    public function updateGym(Request $request, $id){
        try{
            $validated = $request->validate([
                'name'=>'required|string|unique:roles,name',
                'description'=>'nullable|string|max:1000',
            ]);
            $gym = Gym::findOrFail($id);
            $gym->name = $validated['name'];
            $gym->description = $validated['description'];
            $gym->save();
            return response()->json($gym);
        }
        catch(\Exception $exception){
            return response()->json([
            'error'=> 'Failed to fetch the gym with ID: '.$id,
            'message'=> $exception->getMessage()
            ]);
        }
    }
    public function deleteGym($id){
        try{
            $gym = Gym::findOrFail($id);
            $gym->delete();
            return response("Gym deleted successfully");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to delete the gym',
                'message'=> $exception->getMessage()
            ]);
        }
    }
}