<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * index users
     */

    // API untuk menampilkan semua user
    public function index()
    {
        return response()->json(\App\Models\User::all());
    }

    // menampilkan data user di admin panel
    public function show()
    {
        return view('admin.User.index', [
            'user' => User::get()
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1,                                    // default role member //
            'is_verified' => false,
            
        ]);

        // Kirim OTP
        $otpService = app(\App\Services\OtpService::class);
        $otp = $otpService->generateOtp($user->email, 'email');
        $otpService->sendOtp($user->email, $otp, 'email');

        // Simpan email ke session untuk verify OTP
        session(['otp_email' => $user->email]);

        // ⬇️ INI YANG PENTING
        return redirect()->route('verify.otp.page')
            ->with('success', 'OTP has been sent to your email.');
    }

    public function loginWeb(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        // ambil user dulu
        $user = User::where('email', $request->email)->first();

        // email / password salah
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'email atau password Anda salah',
            ])->onlyInput('email');
        }

        // larang admin login ke portal user
        if ($user->role == 2) {
            return back()->withErrors([
                'email' => 'Akun admin tidak dapat login di halaman user. Silakan gunakan portal admin.'
            ])->onlyInput('email');
        }

        // belum verifikasi OTP
        if (!$user->is_verified) {
            // simpan email ke session biar verify page aman
            session(['otp_email' => $user->email]);

            return redirect()
                ->route('verify.otp.page')
                ->withErrors([
                    'email' => 'Mohon verifikasi email Anda terlebih dahulu'
                ]);
        }

        // login setelah lolos semua cek
        Auth::login($user, $request->boolean('remember'));

        // anti session fixation
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function loginAdmin(Request $request)
    {

        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::guard('admin')->attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        $user = Auth::guard('admin')->user();

        // bukan admin
        if ($user->role != 2) {
            Auth::guard('admin')->logout();
            return back()->withErrors([
                'email' => 'Anda tidak memiliki akses sebagai admin',
            ]);
        }

        // belum verifikasi
        if (!$user->is_verified) {
            Auth::guard('admin')->logout();
            return back()->withErrors([
                'email' => 'Akun belum diverifikasi',
            ]);
        }

        // login juga ke guard web agar fitur share dengan member tetap jalan
        Auth::guard('web')->login($user);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Login API user and return token
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        if (!$user->is_verified) {
            return response()->json([
                'message' => 'Email not verified. Please verify your email with the OTP sent.'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * Get authenticated user
     */
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ], 200);
    }

    // PROMOTE USER -> ADMIN
    public function promote($id)
    {
        $user = User::findOrFail($id);

        // ❌ tidak boleh promote diri sendiri (opsional, tapi aman)
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mempromosikan diri sendiri.');
        }

        // ❌ kalau sudah admin
        if ($user->role == 2) {
            return back()->with('error', 'User ini sudah menjadi admin.');
        }

        $user->update([
            'role' => 2
        ]);

        return back()->with('success', 'User berhasil dipromosikan menjadi admin.');
    }

    // DEMOTE ADMIN -> USER
    public function demote($id)
    {
        $user = User::findOrFail($id);

        // ❌ tidak boleh demote diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menurunkan role diri sendiri.');
        }

        // ❌ kalau bukan admin
        if ($user->role != 2) {
            return back()->with('error', 'User ini bukan admin.');
        }

        $user->update([
            'role' => 1
        ]);

        return back()->with('success', 'Admin berhasil diturunkan menjadi user.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // cegah hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        // cegah hapus admin lain
        if ($user->role == 2) {
            return back()->with('error', 'Tidak bisa menghapus akun admin');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }

    public function logoutWeb(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Logout API user (revoke token)
     */
    public function logout(Request $request)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }


    /**
     * Refresh token
     */
    public function refresh(Request $request)
    {
        $user = $request->user();
        
        // Revoke the current token
        $user->currentAccessToken()->delete();

        // Create a new token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Token refreshed successfully',
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * Admin: edit profil sendiri.
     */
    public function editProfileAdmin()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Admin: update profil sendiri (nama saja).
     */
    public function updateProfileAdmin(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Member: edit profil sendiri.
     */
    public function editProfileMember()
    {
        $user = Auth::user();
        return view('member.profilemem', compact('user'));
    }

    /**
     * Member: update profil sendiri (nama saja).
     */
    public function updateProfileMember(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
