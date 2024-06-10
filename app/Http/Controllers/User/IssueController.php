<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateIssueRequest;
use App\Http\Resources\IssueResource;
use App\Services\Issue\IssueServiceInterface;
use Illuminate\Http\Request;

class IssueController extends Controller
{
     /**
      * @var IssueServiceInterface  $issueService
      */
    public $issueService;

    /**
     * IssueController constructor.
     *
     * @param IssueServiceInterface $issueService
     */
    public function __construct(IssueServiceInterface $issueService)
    {
        $this->issueService = $issueService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $lang = $request->header('lang', 'en');
        $params = $request->query();
        return $this->issueService->get($params, $lang);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIssueRequest $request)
    {
        $validatedData = $request->validated();
        return $this->issueService->createForUser($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->issueService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateIssueRequest $request, int $id)
    {
        $validatedData = $request->validated();
        return $this->issueService->updateForUser($id, $validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->issueService->deleteForUser($id);
    }
}
