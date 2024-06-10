<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Issue\IssueServiceImplement;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    private IssueServiceImplement $issueServiceImpl;

    public function __construct(IssueServiceImplement $issueServiceImpl)
    {
        $this->issueServiceImpl = $issueServiceImpl;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $params = $request->query();
        // return response()->json($lang);
        return $this->issueServiceImpl->index($params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return $this->issueServiceImpl->createForAdmin($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return $this->issueServiceImpl->showForAdmin($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        return $this->issueServiceImpl->updateForAdmin($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return $this->issueServiceImpl->deleteForAdmin($id);
    }
}
