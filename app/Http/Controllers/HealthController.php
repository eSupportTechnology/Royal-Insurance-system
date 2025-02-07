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
        $helths = Health::all();
        return view('health.index',compact('helths'));
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

            $helths= new Health;
            $helths->name=$data["name"];
            $helths->age=$data["age"];
            $helths->nic=$data["nic"];
            $helths->address=$data["address"];
            $helths->weight=$data["weight"];
            $helths->contact_number=$data["contact_number"];
            $helths->blood_group=$data["blood_group"];
            $helths->save();

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
        $helths = Health::find($id);
        return view('health.edit',compact('helths'));
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

                $helths=Health::find($id) ;
                $helths->name=$request->input("name");
                $helths->age=$request->input("age");
                $helths->nic=$request->input("nic");
                $helths->address=$request->input("address");
                $helths->weight=$request->input("weight");
                $helths->contact_number=$request->input("contact_number");
                $helths->blood_group=$request->input("blood_group");
                $helths->save();

                return redirect()->route('health.index')->with('success','successfully updated');
            }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $helths = Health::find($id);
      if($helths){
        $helths->delete();
        return redirect()->route('health.index')->with('success','Data is deleted');
      }
      return redirect()->route('health.index')->with('error','Not Available');
    }


}

