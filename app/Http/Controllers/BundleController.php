<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bundle;

class BundleController extends Controller
{
    // Create bundle
    public function createBundle(Request $request){
        $validated = $request->validate([
            'name'=>'required|string',
            'start_time'=>'required|date',
            'duration'=>'required|date',
            'description'=>'nullable|string|max:1000',
            'category_id'=>'required|exists:categories,id',
            ]);
            $bundle = new Bundle();
            $bundle->name = $validated['name'];
            $bundle->start_time = $validated['start_time'];
            $bundle->duration = $validated['duration'];
            $bundle->description = $validated['description'];
            $bundle->category_id = $validated['category_id'];

            try{
                $createdBundle = $bundle->save();
                return response()->json($bundle);
            }
            catch(\Exception $exception){
                return response()->json(
                    ['error'=>'Failed to save bundle',
                    'message'=> $exception->getMessage()
                ]);
            }
    }

    // Read all bundles
    public function readAllBundles(){
        try{
            // $bundles = Bundle::all();
            $bundles = Bundle::join('categories', 'bundles.category_id','=', 'categories.id')
                               ->select('bundles.*', 'categories.name as category_name')
                               ->get();

            return response()->json($bundles);
            }
            catch(\Exception $exception){
                return response()->json([
                    'error'=> 'Failed to fetch bundles',
                    'message'=> $exception->getMessage()
                ]);
            }
    }

    public function readBundle($id){
        try {
            // $bundle = Bundle::findOrFail($id);
            $bundle = Bundle::join('categories', 'bundles.category_id','=', 'categories.id')
                               ->select('bundles.*', 'categories.name as category_name')
                               ->where('bundles.id', $id)
                               ->first();

            return response()->json($bundle);
        }
        catch(\Exception $exception){
                return response()->json([
                    'error'=> 'Failed to fetch the bundle with ID: '.$id,
                    'message'=> $exception->getMessage()
                ]);
            }
    }
    public function updateBundle(Request $request, $id){
        try{
            $validated = $request->validate([
                'name'=>'required|string',
                'start_time'=>'required|date',
                'duration'=>'required|date',
                'description'=>'nullable|string|max:1000',
                'category_id'=>'required|exists:categories,id',
            ]);
            $bundle = Bundle::findOrFail($id);
            $bundle->name = $validated['name'];
            $bundle->start_time = $validated['start_time'];
            $bundle->duration = $validated['duration'];
            $bundle->description = $validated['description'];
            $bundle->category_id = $validated['category_id'];
            $bundle->save();
            return response()->json($bundle);
        }
        catch(\Exception $exception){
            return response()->json([
            'error'=> 'Failed to update the bundle with ID: '.$id,
            'message'=> $exception->getMessage()
            ]);
        }
    }
    public function deleteBundle($id){
        try{
            $bundle = Bundle::findOrFail($id);
            $bundle->delete();
            return response("Bundle deleted successfully");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to delete the bundle',
                'message'=> $exception->getMessage()
            ]);
        }
    }
}