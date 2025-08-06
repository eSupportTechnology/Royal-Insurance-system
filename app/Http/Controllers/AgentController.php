<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\SubAgent;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgentController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Agent::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<a href="' . route('agents.edit', $row->id) . '" class="btn btn-sm btn-warning"><i class="icon-pencil-alt"></i></a>';
                $delete = '
                    <form action="' . route('agents.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\');" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" style="height: 31px; padding: 0 28px;"><i class="icon-trash"></i></button>
                    </form>';
                return '<div class="d-flex gap-1 align-items-center">' . $edit . $delete . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('agents.index');
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

    public function subagentindex(Request $request)
{
    if ($request->ajax()) {
        $data = SubAgent::with('agent');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('rep_code', function ($row) {
                return $row->agent ? $row->agent->rep_code : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $edit = '<a href="' . route('sub_agents.edit', $row->id) . '" class="btn btn-sm btn-warning"><i class="icon-pencil-alt"></i></a>';
                $delete = '
                    <form action="' . route('sub_agents.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\');" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" style="height: 31px; padding: 0 28px;"><i class="icon-trash"></i></button>
                    </form>';
                return '<div class="d-flex gap-1 align-items-center">' . $edit . $delete . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('sub_agents.index');
}
    public function subagentcreate(){
        $subagents = Agent::all();
        return view('sub_agents.create',compact('subagents'));
    }

    public function subagentstore(Request $request)
{
    $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'sub_agent_name' => 'required|string|max:255',
        'email' => 'nullable|email|unique:agents,email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
    ]);

    // Get selected agent
    $agent = Agent::findOrFail($request->agent_id);

    // Get the agent's rep_code (e.g., RIB/001)
    $baseRepCode = $agent->rep_code;

    // Count existing sub-agents for this agent
    $count = SubAgent::where('agent_id', $agent->id)->count();

    // Generate sub-agent rep code: RIB/001/001, RIB/001/002, etc.
    $subAgentRepCode = $baseRepCode . '/' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

    // Create the sub-agent
    SubAgent::create([
        'agent_id' => $agent->id,
        'sub_agent_rep_code' => $subAgentRepCode,
        'sub_agent_name' => $request->sub_agent_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    return redirect()->route('sub_agents.index')->with('success', 'Sub-agent added successfully.');
}


    public function subagentedit($id){
        $subagent = SubAgent::findOrFail($id);
        $agents = Agent::all();
        return view('sub_agents.edit',compact('subagent','agents'));
    }

  public function subagentupdate(Request $request, $id)
{
    $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'sub_agent_name' => 'required|string|max:255',
        'email' => 'nullable|email|unique:agents,email,' . $id,
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
    ]);

    $subagent = SubAgent::findOrFail($id);
    $newAgent = Agent::findOrFail($request->agent_id);
    $baseRepCode = $newAgent->rep_code;

    // Find the highest rep code under the selected agent
    $latestSub = SubAgent::where('agent_id', $newAgent->id)
        ->where('id', '!=', $id) // Exclude current sub-agent if it's already under this agent
        ->orderByDesc('sub_agent_rep_code')
        ->first();

    if ($latestSub && preg_match('/\/(\d+)$/', $latestSub->sub_agent_rep_code, $matches)) {
        $nextNum = intval($matches[1]) + 1;
    } else {
        $nextNum = 1;
    }

    $newSubRepCode = $baseRepCode . '/' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

    // Update fields
    $subagent->agent_id = $request->agent_id;
    $subagent->sub_agent_name = $request->sub_agent_name;
    $subagent->email = $request->email;
    $subagent->phone = $request->phone;
    $subagent->address = $request->address;
    $subagent->sub_agent_rep_code = $newSubRepCode;
    $subagent->save();

    return redirect()->route('sub_agents.index')->with('success', 'Sub-agent updated successfully.');
}




    public function subagentdestroy($id){
        $subagent = SubAgent::findOrFail($id);
        $subagent->delete();

        return redirect()->route('sub_agents.index')->with('success', 'Sub-agent deleted successfully.');
    }
}
