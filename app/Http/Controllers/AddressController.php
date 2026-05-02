<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Simpan alamat baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone'          => ['required', 'string', 'max:20'],
            'street'         => ['required', 'string'],
            'city'           => ['required', 'string', 'max:100'],
            'postal_code'    => ['required', 'string', 'max:10'],
        ]);

        $user = Auth::user();

        // Kalau ini alamat pertama, otomatis jadi default
        $isFirst = $user->addresses()->count() === 0;

        $user->addresses()->create([
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'street'         => $request->street,
            'city'           => $request->city,
            'postal_code'    => $request->postal_code,
            'is_default'     => $isFirst,
        ]);

        return redirect()->route('profile')->with('success', 'ADDRESS_ADDED_SUCCESSFULLY');
    }

    /**
     * Tampilkan form edit alamat.
     */
    public function edit($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        return view('pages.address-edit', compact('address'));
    }

    /**
     * Update alamat yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone'          => ['required', 'string', 'max:20'],
            'street'         => ['required', 'string'],
            'city'           => ['required', 'string', 'max:100'],
            'postal_code'    => ['required', 'string', 'max:10'],
        ]);

        $address->update($request->only([
            'recipient_name',
            'phone',
            'street',
            'city',
            'postal_code',
        ]));

        return redirect()->route('profile')->with('success', 'ADDRESS_UPDATED_SUCCESSFULLY');
    }

    /**
     * Set alamat sebagai default.
     */
    public function setDefault($id)
    {
        $user = Auth::user();

        // Reset semua alamat user jadi bukan default
        $user->addresses()->update(['is_default' => false]);

        // Set alamat yang dipilih jadi default
        $user->addresses()->where('id', $id)->update(['is_default' => true]);

        return redirect()->route('profile')->with('success', 'DEFAULT_ADDRESS_UPDATED');
    }

    /**
     * Hapus alamat.
     */
    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        $wasDefault = $address->is_default;
        $address->delete();

        // Kalau yang dihapus adalah default, set alamat pertama yang tersisa jadi default
        if ($wasDefault) {
            $remaining = Auth::user()->addresses()->first();
            if ($remaining) {
                $remaining->update(['is_default' => true]);
            }
        }

        return redirect()->route('profile')->with('success', 'ADDRESS_DELETED_SUCCESSFULLY');
    }
}