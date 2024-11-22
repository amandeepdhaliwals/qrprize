<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Notifications\MobileAppNotification;


class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'unread_notifications' => $user->unreadNotifications,
            'read_notifications' => $user->readNotifications,
            'unreadCount' =>  $user->unreadNotifications->count(),
            'readCount' => $user->readNotifications->count(),
        ]);
    }

    public function notificationCount(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'unreadCount' =>  $user->unreadNotifications->count(),
            'readCount' => $user->readNotifications->count(),
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->find($id);

        if ($notification && $notification->read_at === null) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read.']);
        }

        return response()->json(['message' => 'Notification not found or already read.'], 404);
    }

    public function markAsUnread(Request $request, $id)
    {
        $notification = $request->user()->notifications()->find($id);

        if ($notification && $notification->read_at !== null) {
            $notification->update(['read_at' => null]);
            return response()->json(['message' => 'Notification marked as unread.']);
        }

        return response()->json(['message' => 'Notification not found or already unread.'], 404);
    }

    public function markAsReadAll(Request $request)
    {
        $user = Auth::user(); // or JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $user->unreadNotifications->markAsRead();
        return response()->json(['message' => 'Notification marked as read.']);
    
    }

    public function markAsUnreadAll(Request $request)
    {
        $user = Auth::user(); // or JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $user->readNotifications->markAsUnread();
        return response()->json(['message' => 'Notification marked as unread.']);
    
    }


    public function sendNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $user = User::findOrFail($request->user_id);

        $notificationData = [
            'title' => $request->title,
            'body' => $request->body,
            'additional_data' => $request->additional_data ?? [],
        ];

        $user->notify(new MobileAppNotification($notificationData));

        return response()->json(['message' => 'Notification sent successfully!']);
    }

   

}
