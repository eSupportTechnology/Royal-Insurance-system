<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Health;

class HealthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $healths = Health::all();
        return view('health.index',compact('healths'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('health.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
                'name'=> 'required',
                'age'=> 'required|integer',
                'nic'=> 'required',
                'address'=> 'required',
                'weight'=> 'required|integer',
                'contact_number'=> 'required',
                'blood_group'=> 'required',
            ]);
    
            $data = $request->except("_token");
    
            $healths= new Health;
            $healths->name=$data["name"];
            $healths->age=$data["age"];
            $healths->nic=$data["nic"];
            $healths->address=$data["address"];
            $healths->weight=$data["weight"];
            $healths->contact_number=$data["contact_number"];
            $healths->blood_group=$data["blood_group"];
            $healths->save();
    
            return redirect()->route('health.index')->with('success','successfully created');
        }
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $healths = Health::find($id);
        return view('health.edit',compact('healths'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=> 'required',
            'age'=> 'required|integer',
            'nic'=> 'required',
            'address'=> 'required',
            'weight'=> 'required|integer',
            'contact_number'=> 'required',
            'blood_group'=> 'required',
                ]);
                
                $healths=Health::find($id) ;
                $healths->name=$request->input("name");
                $healths->age=$request->input("age");
                $healths->nic=$request->input("nic");
                $healths->address=$request->input("address");
                $healths->weight=$request->input("weight");
                $healths->contact_number=$request->input("contact_number");
                $healths->blood_group=$request->input("blood_group");
                $healths->save();
        
                return redirect()->route('health.index')->with('success','successfully updated');
            }
        
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $healths = Health::find($id);
      if($healths){
        $healths->delete();
        return redirect()->route('health.index')->with('success','Data is deleted');
      }
      return redirect()->route('health.index')->with('error','Not Available');
    }
     
    
}
   
