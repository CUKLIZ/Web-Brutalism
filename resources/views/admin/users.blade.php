@extends('admin.layout')

@section('content')

<div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 10px;">[ ACCESS_LEVEL: ROOT ]</div>
        <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -2px; margin: 0;">USER_ARCHIVE</h1>
        <p style="font-weight: 900; opacity: 0.6; margin-top: 10px; font-size: 0.9rem;">MANAGING_VOIDS_AND_NOMADS_IN_THE_SYSTEM.</p>
    </div>

    <div style="display: flex; gap: 15px;">
        <div class="admin-stat-card" style="padding: 10px 20px; box-shadow: 4px 4px 0px black;">
            <span style="font-size: 0.55rem; font-weight: 900; color: #666; display: block;">TOTAL_USERS</span>
            <span style="font-size: 1.5rem; font-weight: 900;">{{ $users->count() }}</span>
        </div>
        <div class="admin-stat-card" style="padding: 10px 20px; box-shadow: 4px 4px 0px black; border-color: #FF0000;">
            <span style="font-size: 0.55rem; font-weight: 900; color: #666; display: block;">BANNED</span>
            <span style="font-size: 1.5rem; font-weight: 900; color: #FF0000;">{{ $users->where('is_banned', true)->count() }}</span>
        </div>
        <div class="admin-stat-card" style="padding: 10px 20px; box-shadow: 4px 4px 0px black; border-color: var(--neon-green);">
            <span style="font-size: 0.55rem; font-weight: 900; color: #666; display: block;">ACTIVE</span>
            <span style="font-size: 1.5rem; font-weight: 900; color: var(--neon-green); text-shadow: 1px 1px 0px black;">{{ $users->where('is_banned', false)->count() }}</span>
        </div>
    </div>
</div>

{{-- Flash Messages --}}
@if (session('success'))
    <div style="background: var(--neon-green); border: 4px solid black; padding: 15px 20px; font-weight: 900; margin-bottom: 30px; box-shadow: 4px 4px 0px black;">
        ✓ {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div style="background: #FF0000; color: white; border: 4px solid black; padding: 15px 20px; font-weight: 900; margin-bottom: 30px; box-shadow: 4px 4px 0px black;">
        ✗ {{ session('error') }}
    </div>
@endif

{{-- SEARCH & FILTER --}}
<form method="GET" action="{{ route('admin.users') }}">
    <div class="admin-stat-card" style="margin-bottom: 30px; display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 20px; align-items: end; background: #eee;">
        <div>
            <label style="display: block; font-weight: 900; font-size: 0.6rem; margin-bottom: 5px;">SEARCH_BY_IDENTITY</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="USERNAME_OR_EMAIL..."
                   style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white;">
        </div>
        <div>
            <label style="display: block; font-weight: 900; font-size: 0.6rem; margin-bottom: 5px;">ROLE_PROTOCOL</label>
            <select name="role" style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; appearance: none; cursor: pointer;">
                <option value="">ALL_ROLES</option>
                <option value="developer" {{ request('role') === 'developer' ? 'selected' : '' }}>DEVELOPER</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>ADMIN</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>CUSTOMER</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-weight: 900; font-size: 0.6rem; margin-bottom: 5px;">STATUS_FILTER</label>
            <select name="status" style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; appearance: none; cursor: pointer;">
                <option value="">ANY_STATUS</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>ACTIVE</option>
                <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>BANNED</option>
            </select>
        </div>
        <button type="submit" class="brutal-button" style="background: black; color: var(--neon-green); padding: 12px 20px; font-size: 0.9rem;">
            FILTER
        </button>
    </div>
</form>

{{-- USER TABLE --}}
<div class="admin-stat-card" style="padding: 0; overflow: hidden; border-width: 5px;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: black; color: white;">
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; border-right: 2px solid #333;">01_IDENT</th>
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; border-right: 2px solid #333;">02_ROLE_STAT</th>
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; border-right: 2px solid #333;">03_ACTIVITY</th>
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; border-right: 2px solid #333;">04_ORDERS</th>
                <th style="padding: 20px; font-weight: 900; font-size: 0.7rem; text-align: right;">05_OPERATE</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
                <tr style="border-bottom: 4px solid black; background: {{ $index % 2 === 0 ? '#fff' : '#f9f9f9' }}; {{ $user->is_banned ? 'opacity: 0.6;' : '' }}">

                    {{-- IDENT --}}
                    <td style="padding: 20px; border-right: 3px solid black;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 45px; height: 45px; border: 3px solid black; overflow: hidden; flex-shrink: 0;">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; background: {{ $user->role === 'developer' ? 'var(--accent-pink)' : ($user->role === 'admin' ? 'var(--neon-green)' : '#000') }}; display: flex; align-items: center; justify-content: center; color: {{ $user->role === 'admin' ? '#000' : '#fff' }}; font-weight: 900; font-size: 1.2rem;">
                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div style="font-weight: 900; font-size: 1rem; line-height: 1;">{{ strtoupper($user->username) }}</div>
                                <div style="font-size: 0.65rem; font-weight: 900; opacity: 0.5; margin-top: 4px;">{{ $user->email }}</div>
                                @if ($user->id === Auth::id())
                                    <div style="font-size: 0.55rem; font-weight: 900; color: var(--neon-green); margin-top: 4px;">[YOU]</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- ROLE & STATUS --}}
                    <td style="padding: 20px; border-right: 3px solid black;">
                        <div style="margin-bottom: 8px;">
                            @php
                                $roleColor = match($user->role) {
                                    'developer' => 'var(--accent-pink)',
                                    'admin'     => 'var(--neon-green)',
                                    default     => '#ddd',
                                };
                                $roleTextColor = $user->role === 'customer' ? 'black' : ($user->role === 'developer' ? 'white' : 'black');
                            @endphp
                            <span style="background: {{ $roleColor }}; color: {{ $roleTextColor }}; padding: 3px 10px; font-size: 0.65rem; font-weight: 900; border: 2px solid black;">
                                {{ strtoupper($user->role) }}
                            </span>
                        </div>
                        <div>
                            <span style="font-size: 0.6rem; font-weight: 900; color: {{ $user->is_banned ? '#FF0000' : 'var(--neon-green)' }}; display: flex; align-items: center; gap: 5px;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor; display: inline-block;"></span>
                                {{ $user->is_banned ? 'BANNED' : 'ACTIVE' }}
                            </span>
                        </div>
                    </td>

                    {{-- ACTIVITY --}}
                    <td style="padding: 20px; border-right: 3px solid black;">
                        <div style="font-size: 0.55rem; font-weight: 900; color: #666; margin-bottom: 4px;">JOINED_DATE:</div>
                        <div style="font-weight: 900; font-size: 0.8rem;">{{ $user->created_at->format('Y-m-d') }}</div>
                    </td>

                    {{-- ORDERS --}}
                    <td style="padding: 20px; border-right: 3px solid black;">
                        <div style="font-size: 0.55rem; font-weight: 900; color: #666; margin-bottom: 4px;">ORDER_COUNT:</div>
                        <div style="font-size: 1.8rem; font-weight: 900; line-height: 1;">{{ $user->orders->count() }}</div>
                    </td>

                    {{-- ACTIONS --}}
                    <td style="padding: 20px; text-align: right;">
                        <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">

                            {{-- ROLE TOGGLE — hanya developer yang bisa --}}
                            @if (Auth::user()->role === 'developer' && $user->id !== Auth::id())
                                <form id="role-form-{{ $user->id }}" action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <button type="button"
                                    onclick="window.BrutalModal.confirm(
                                        'CHANGE_ROLE?',
                                        'USER [{{ strtoupper($user->username) }}] ROLE WILL BE CHANGED FROM {{ strtoupper($user->role) }} TO {{ $user->role === 'admin' ? 'CUSTOMER' : 'ADMIN' }}.',
                                        () => document.getElementById('role-form-{{ $user->id }}').submit(),
                                        'CONFIRM',
                                        'CANCEL'
                                    )"
                                    style="border: 3px solid black; background: {{ $user->role === 'admin' ? '#ddd' : 'var(--neon-green)' }}; color: black; padding: 6px 12px; font-weight: 900; font-size: 0.65rem; cursor: pointer; white-space: nowrap; width: 120px;">
                                    {{ $user->role === 'admin' ? 'DEMOTE' : 'PROMOTE' }}
                                </button>
                            @endif

                            @php
                                $hierarchy   = ['customer' => 1, 'admin' => 2, 'developer' => 3];
                                $authLevel   = $hierarchy[Auth::user()->role] ?? 0;
                                $targetLevel = $hierarchy[$user->role] ?? 0;
                                $canOperate  = $authLevel > $targetLevel && $user->id !== Auth::id();
                            @endphp

                            {{-- BAN TOGGLE --}}
                            @if ($canOperate)
                                <form id="ban-form-{{ $user->id }}" action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <button type="button"
                                    onclick="window.BrutalModal.confirm(
                                        '{{ $user->is_banned ? 'UNBAN_USER?' : 'BAN_USER?' }}',
                                        'USER [{{ strtoupper($user->username) }}] WILL BE {{ $user->is_banned ? 'UNBANNED AND CAN LOGIN AGAIN.' : 'BANNED AND CANNOT LOGIN.' }}',
                                        () => document.getElementById('ban-form-{{ $user->id }}').submit(),
                                        'CONFIRM',
                                        'CANCEL'
                                    )"
                                    style="border: 3px solid black; background: {{ $user->is_banned ? 'var(--neon-green)' : '#FF0000' }}; color: {{ $user->is_banned ? 'black' : 'white' }}; padding: 6px 12px; font-weight: 900; font-size: 0.65rem; cursor: pointer; white-space: nowrap; width: 120px;">
                                    {{ $user->is_banned ? 'UNBAN' : 'BAN' }}
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 100px 20px; text-align: center;">
                        <div style="border: 4px dashed #999; padding: 40px; display: inline-block;">
                            <h2 style="font-weight: 900; margin: 0; color: #999;">NO_USERS_INSIDE_THE_VAULT</h2>
                            <p style="font-size: 0.7rem; font-weight: 900; color: #bbb; margin-top: 10px;">RE-INITIALIZE_SCAN_PARAMETER</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection