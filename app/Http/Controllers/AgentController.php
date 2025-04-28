<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\SubAgent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::all();
        return view('agents.index', compact('agents'));
    }

    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:agents,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
        ]);

        // Get the latest agent ID and increment it
        $lastAgent = Agent::orderBy('id', 'desc')->first();
        $nextId = $lastAgent ? $lastAgent->id + 1 : 1;

        // Format the rep_code as RIB/001, RIB/002, etc.
        $repCode = 'RIB/' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Create the agent with rep_code
        Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company_name' => $request->company_name,
            'rep_code' => $repCode,
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent added successfully.');
    }


    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:agents,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
        ]);

        $agent = Agent::findOrFail($id);
        $agent->update($request->all());

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();

        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
    }

    public function subagentindex(){
        $agentsWithSubagents = Agent::with('subagents')->get();
        $subagents = SubAgent::all();
        return view('sub_agents.index',compact('subagents','agentsWithSubagents'));

    }
    public function subagentcreate(){
        $subagents = Agent::all();
        return view('sub_agents.create',compact('subagents'));
    }

    public function subagentstore(Request $request){
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'sub_agent_name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'company_name' => 'required|string|max:255',
        ]);

        SubAgent::create([
            'agent_id' => $request->agent_id,
            'sub_agent_name' => $request->sub_agent_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company_name' => $request->company_name,
        ]);

        return redirect()->route('sub_agents.index')->with('success', 'Sub-agent added successfully.');
    }

    public function subagentedit($id){
        $subagent = SubAgent::findOrFail($id);
        $agents = Agent::all();
        return view('sub_agents.edit',compact('subagent','agents'));
    }

    public function subagentupdate(Request $request, $id){
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'sub_agent_name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,'.$id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'company_name' => 'required|string|max:255',
        ]);

        $subagent = SubAgent::findOrFail($id);
        $subagent->update($request->all());

        return redirect()->route('sub_agents.index')->with('success', 'Sub-agent updated successfully.');
    }
    public function subagentdestroy($id){
        $subagent = SubAgent::findOrFail($id);
        $subagent->delete();

        return redirect()->route('sub_agents.index')->with('success', 'Sub-agent deleted successfully.');
    }
}
