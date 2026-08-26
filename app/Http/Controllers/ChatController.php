<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Cari atau buat chat room untuk pelanggan yang sedang login.
     */
    public function getOrCreateRoom(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $room = ChatRoom::firstOrCreate(
            ['user_id' => $userId],
            ['status' => 'active']
        );

        if ($request->filled('car_id') && !$room->car_id) {
            $room->update(['car_id' => $request->car_id]);
        }

        return response()->json([
            'id' => $room->id,
            'user_id' => $room->user_id,
            'car_id' => $room->car_id,
            'status' => $room->status,
        ]);
    }

    /**
     * Ambil semua pesan dalam suatu chat room.
     */
    public function getMessages($roomId)
    {
        $user = Auth::user();
        $room = ChatRoom::findOrFail($roomId);

        // Hanya pemilik room atau admin yang boleh mengakses pesan room ini
        if ($user->role !== 'admin' && $room->user_id !== $user->id) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        // Tandai pesan sebagai terbaca jika pengirimnya bukan user saat ini
        Message::where('chat_room_id', $roomId)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where('chat_room_id', $roomId)
            ->with(['sender' => function ($query) {
                $query->select('id', 'name', 'role');
            }])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($room) {
                return [
                    'id' => (int) $msg->id,
                    'chat_room_id' => (int) $msg->chat_room_id,
                    'room_user_id' => (int) $room->user_id,
                    'sender_id' => (int) $msg->sender_id,
                    'message' => $msg->message,
                    'is_read' => (bool) $msg->is_read,
                    'sender_name' => $msg->sender ? $msg->sender->name : 'Pengguna',
                    'sender_role' => $msg->sender ? $msg->sender->role : 'user',
                    'time' => $msg->created_at ? $msg->created_at->format('H:i') : '',
                    'date' => $msg->created_at ? $msg->created_at->format('d M Y') : '',
                ];
            });

        return response()->json($messages);
    }

    /**
     * Kirim pesan baru ke chat room.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required|exists:chat_rooms,id',
            'message'      => 'required|string|max:2000',
        ]);

        $user = Auth::user();
        $room = ChatRoom::findOrFail($request->chat_room_id);

        if ($user->role !== 'admin' && $room->user_id !== $user->id) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $message = Message::create([
            'chat_room_id' => $room->id,
            'sender_id'    => $user->id,
            'message'      => trim($request->message),
            'is_read'      => false,
        ]);

        // Perbarui timestamp room agar naik ke urutan teratas
        $room->touch();

        return response()->json([
            'id' => (int) $message->id,
            'chat_room_id' => (int) $message->chat_room_id,
            'room_user_id' => (int) $room->user_id,
            'sender_id' => (int) $message->sender_id,
            'message' => $message->message,
            'is_read' => false,
            'sender_name' => $user->name,
            'sender_role' => $user->role,
            'time' => $message->created_at->format('H:i'),
            'date' => $message->created_at->format('d M Y'),
        ]);
    }

    /**
     * Ambil daftar room chat untuk Admin secara real-time.
     */
    public function getAdminRooms()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $chatRooms = ChatRoom::with(['user', 'messages' => function ($query) {
            $query->latest();
        }])
        ->has('user')
        ->latest('updated_at')
        ->get()
        ->map(function ($room) {
            $lastMsg = $room->messages->first();
            $unreadCount = Message::where('chat_room_id', $room->id)
                ->where('sender_id', $room->user_id)
                ->where('is_read', false)
                ->count();

            return [
                'id' => (int) $room->id,
                'user_id' => (int) $room->user_id,
                'user_name' => $room->user ? $room->user->name : 'Pelanggan',
                'user_email' => $room->user ? $room->user->email : '',
                'user_phone' => $room->user ? $room->user->phone : '',
                'last_message' => $lastMsg ? $lastMsg->message : 'Belum ada pesan',
                'last_time' => $lastMsg ? $lastMsg->created_at->format('H:i') : $room->created_at->format('H:i'),
                'unread_count' => (int) $unreadCount,
                'updated_at' => $room->updated_at,
            ];
        });

        return response()->json($chatRooms);
    }

    /**
     * Bersihkan riwayat pesan dalam room tertentu (tanpa menghapus room).
     */
    public function deleteRoom($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $room = ChatRoom::findOrFail($id);
        Message::where('chat_room_id', $room->id)->delete();
        $room->touch();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pesan berhasil dibersihkan.'
        ]);
    }

    /**
     * Tampilkan halaman inbox konsultasi untuk Admin.
     */
    public function adminInbox()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('landing')->with('error', 'Akses ditolak.');
        }

        $chatRooms = ChatRoom::with(['user', 'car', 'messages' => function ($query) {
            $query->latest();
        }])
        ->has('user')
        ->latest('updated_at')
        ->get();

        return view('admin.consultation.index', compact('chatRooms'));
    }
}