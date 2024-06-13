<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicSession\PublicSession1;
use App\Http\Requests\PublicSession\PublicSession2;
use App\Models\AdvancedUser;
use App\Models\AssignedService;
use App\Models\PublicSession;
use App\Models\Service;
use App\Models\ServiceManager;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicSessionController extends Controller
{

    public function show(Service $service)
    {
        $publicSessions = PublicSession::with('session')
            ->whereHas('session.service', function ($query) use ($service) {
            $query->where('serviceID', $service['id']);})->get();
        if (request()->is('api/*')) {
            return response()->json($publicSessions, 200);
        }

        return view('', compact('publicSessions'));
    }
//    public function showActivities()
//    {
//        $publicSessions = PublicSession::with('session')
//            ->whereHas('session.service', function ($query) {
//            $query->where('serviceType', 'Activity');})->get();
//
//        if (request()->is('api/*')) {
//            return response()->json($publicSessions, 200);
//        }
//
//        return view('', compact('publicSessions'));
//    }
//
//    public function showExams()
//    {
//        $exams = PublicSession::with('session')
//            ->whereHas('session.service', function ($query) {
//            $query->where('serviceType', 'Exam');})->get();
//
//        if (request()->is('api/*')) {
//            return response()->json($exams, 200);
//        }
//
//        return view('', compact('exams'));
//    }
//
//    public function showMyActivities()
//    {
//        $userID = Auth::id();
//        $advancedUser = AdvancedUser::where('userID', $userID)->first();
//        $assignedServiceIDs = AssignedService::where('advancedUserID', $advancedUser->id)->pluck('serviceID');
//        $sessions = Session::whereIn('serviceID', $assignedServiceIDs)
//                ->whereHas('service', function ($query) {
//                    $query->where('serviceType', 'Activity');})->get();
//
//        if (request()->is('api/*')) {
//            return response()->json($sessions, 200);
//        }
//
//         return view('', compact('sessions'));
//    }

    public function showMyExams()
    {
        $userID = Auth::id();
        $advancedUser = AdvancedUser::where('userID', $userID)->first();
        $assignedServiceIDs = AssignedService::where('advancedUserID', $advancedUser->id)->pluck('serviceID');
        $sessions = Session::whereIn('serviceID', $assignedServiceIDs)
            ->whereHas('service', function ($query) {
                $query->where('serviceType', 'exam');})->get();

        if (request()->is('api/*')) {
            return response()->json($sessions, 200);
        }

         return view('', compact('sessions'));
        }

    public function create(PublicSession1 $request, Session $session)
    {
        $data = array_merge($request->validated(), ['sessionID' => $session->id]);
        $publicSession = PublicSession::create($data);

        if (request()->is('api/*')) {
            return response()->json($publicSession, 200);
        }

        return view('', compact('publicSession'));
    }

    public function update(PublicSession $publicSession, PublicSession2 $request)
    {
        $publicSession->update($request->validated());

        if (request()->is('api/*')){
            return response()->json($publicSession,200);
        }

        return view ('');
    }

}
