<x-app-layout>
<style>
/* ── Reset / base ──────────────────────────────────────────── */
[x-cloak] { display: none !important; }

/* ── Hero ──────────────────────────────────────────────────── */
.ep-hero {
    position: relative;
    width: 100%;
    border-radius: 1.5rem;
    overflow: hidden;
    padding: 2rem 2.5rem;
    margin-bottom: 1.5rem;
    background: url('{{ asset('images/hero_banner.png') }}') center/cover no-repeat,
                linear-gradient(135deg,#C8D5F8 0%,#BDD0FF 100%);
    min-height: 155px;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 24px rgba(44,59,235,.10);
}
.ep-hero::before {
    content:'';
    position: absolute; inset: 0;
    background: linear-gradient(to right,rgba(200,213,248,.97) 0%,rgba(200,213,248,.72) 55%,transparent 100%);
    pointer-events: none;
}
.ep-hero-inner { position: relative; z-index: 10; display: flex; align-items: center; gap: 1.5rem; }
.ep-avatar {
    width: 4rem; height: 4rem; border-radius: 9999px;
    background: linear-gradient(135deg,#2C3BEB 0%,#818CF8 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; font-weight: 900; color: #fff; letter-spacing: .04em;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(44,59,235,.28);
}
.ep-hero-text h1 { font-size:1.7rem; font-weight:900; color:#0B1221; letter-spacing:-.02em; line-height:1.15; margin-bottom:.3rem; }
.ep-hero-text p  { font-size:.78rem; color:#4B5563; font-weight:500; max-width:26rem; }
.ep-badge {
    display:inline-flex; align-items:center; gap:.3rem;
    font-size:.65rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase;
    color:#2C3BEB; background:rgba(44,59,235,.09); border:1px solid rgba(44,59,235,.2);
    border-radius:9999px; padding:.18rem .65rem; margin-top:.5rem; width:fit-content;
}

/* ── Progress bar card ─────────────────────────────────────── */
.ep-progress-card {
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(16px);
    border:1px solid rgba(200,213,248,.55);
    border-radius:1.25rem;
    box-shadow:0 4px 20px rgba(44,59,235,.06);
    padding:1.1rem 1.5rem;
    display:flex; align-items:center; gap:1.25rem;
    margin-bottom:1.5rem;
}
.ep-progress-icon {
    width:2.5rem; height:2.5rem; border-radius:.75rem; flex-shrink:0;
    background:rgba(44,59,235,.09);
    display:flex; align-items:center; justify-content:center;
}
.ep-progress-info { flex:1; min-width:0; }
.ep-progress-info strong { font-size:.82rem; font-weight:800; color:#0B1221; display:block; margin-bottom:.1rem; }
.ep-progress-info span  { font-size:.72rem; color:#9CA3AF; font-weight:500; }
.ep-bar-wrap { flex:1; display:flex; align-items:center; gap:.85rem; }
.ep-bar-bg { flex:1; height:8px; border-radius:9999px; background:#EEF0FF; overflow:hidden; }
.ep-bar-fill { height:100%; border-radius:9999px; background:linear-gradient(to right,#2C3BEB,#818CF8); transition:width .6s cubic-bezier(.4,0,.2,1); }
.ep-pct { font-size:.9rem; font-weight:900; color:#2C3BEB; min-width:2.5rem; text-align:right; }

/* ── Section card ──────────────────────────────────────────── */
.ep-section {
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(16px);
    border:1px solid rgba(200,213,248,.55);
    border-radius:1.25rem;
    box-shadow:0 4px 20px rgba(44,59,235,.06);
    padding:1.5rem 1.75rem 1.75rem;
    margin-bottom:1.25rem;
}
.ep-section-header { display:flex; align-items:flex-start; gap:.85rem; margin-bottom:1.4rem; }
.ep-section-icon {
    width:2.4rem; height:2.4rem; border-radius:.625rem; flex-shrink:0;
    background:rgba(44,59,235,.09);
    display:flex; align-items:center; justify-content:center;
    margin-top:.1rem;
}
.ep-section-icon svg { color:#2C3BEB; }
.ep-section-title { font-size:.95rem; font-weight:800; color:#0B1221; margin-bottom:.15rem; }
.ep-section-sub   { font-size:.72rem; color:#9CA3AF; font-weight:500; }

/* ── Field wrapper ─────────────────────────────────────────── */
.ep-field { display:flex; flex-direction:column; gap:.35rem; }
.ep-label { font-size:.7rem; font-weight:700; letter-spacing:.07em; text-transform:uppercase; color:#6B7280; }
.ep-input-wrap { position:relative; }
.ep-input-icon {
    position:absolute; left:.7rem; top:50%; transform:translateY(-50%);
    color:#9CA3AF; pointer-events:none; display:flex;
}
.ep-textarea-icon { position:absolute; left:.7rem; top:.7rem; color:#9CA3AF; pointer-events:none; display:flex; }

/* shared input/select/textarea look */
.ep-input, .ep-select, .ep-textarea {
    width:100%;
    background:#F8FAFF;
    border:1.5px solid #E5E9FF;
    border-radius:.625rem;
    font-size:.82rem;
    color:#111827;
    font-weight:500;
    transition:border-color .18s, box-shadow .18s, background .18s;
    outline:none;
}
.ep-input, .ep-select { padding:.58rem .75rem .58rem 2.4rem; }
.ep-textarea { padding:.65rem .75rem .65rem 2.4rem; resize:vertical; line-height:1.5; }
.ep-input:focus, .ep-select:focus, .ep-textarea:focus {
    border-color:#2C3BEB;
    background:#fff;
    box-shadow:0 0 0 3px rgba(44,59,235,.12);
}
.ep-select { appearance:none; cursor:pointer; }

/* ── Buttons ───────────────────────────────────────────────── */
.ep-actions {
    display:flex; justify-content:space-between; align-items:center;
    margin-top:1.5rem; padding-top:1.5rem;
    border-top:1px solid rgba(200,213,248,.5);
    gap:1rem;
}
.ep-btn-delete {
    display:inline-flex; align-items:center; gap:.45rem;
    font-size:.82rem; font-weight:700; color:#DC2626;
    background:transparent; border:1.5px solid #FCA5A5;
    border-radius:.625rem; padding:.6rem 1.25rem; cursor:pointer;
    transition:background .18s,border-color .18s,transform .15s,box-shadow .18s;
}
.ep-btn-delete:hover { background:#FEF2F2; border-color:#EF4444; transform:translateY(-1px); box-shadow:0 4px 14px rgba(220,38,38,.12); }
.ep-btn-save {
    display:inline-flex; align-items:center; gap:.45rem;
    font-size:.85rem; font-weight:800; color:#fff;
    background:linear-gradient(135deg,#2C3BEB 0%,#4F5FF5 100%);
    border:none; border-radius:.625rem; padding:.65rem 1.75rem; cursor:pointer;
    box-shadow:0 4px 16px rgba(44,59,235,.30);
    transition:filter .18s,transform .15s,box-shadow .18s;
}
.ep-btn-save:hover { filter:brightness(1.1); transform:translateY(-1px); box-shadow:0 6px 24px rgba(44,59,235,.38); }

/* checkbox custom */
.ep-checkbox-row { display:flex; align-items:center; gap:.6rem; padding:.4rem 0; }
.ep-checkbox-row input[type="checkbox"] { width:1rem; height:1rem; accent-color:#2C3BEB; cursor:pointer; flex-shrink:0; }
.ep-checkbox-row label { font-size:.8rem; font-weight:600; color:#374151; cursor:pointer; }
</style>

@php
    $u = auth()->user();
    $words    = preg_split('/\s+/', trim($u->name));
    $initials = strtoupper(substr($words[0],0,1).(isset($words[1]) ? substr($words[1],0,1) : ''));
    $roleLabel = match($u->role ?? 'student') {
        'admin'          => 'Super Admin Account',
        'representative' => 'Representative Account',
        default          => 'Student Account',
    };


@endphp

<div class="max-w-4xl mx-auto">

    {{-- ── Back Button ─────────────────────────────────────────── --}}
    <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#2C3BEB] hover:underline mb-4">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Profile
    </a>

    {{-- ── Hero ─────────────────────────────────────────────── --}}
    <div class="ep-hero">
        <div class="ep-hero-inner">
            <div class="ep-avatar" aria-hidden="true">{{ $initials }}</div>
            <div class="ep-hero-text">
                <h1>Update Your Profile</h1>
                <p>Keep your information updated to receive more accurate scholarship recommendations.</p>
                <span class="ep-badge">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3.5 2 8.5 2 12 0v-5"/></svg>
                    {{ $roleLabel }}
                </span>
            </div>
        </div>
    </div>



    @if(in_array($u->role, ['admin', 'representative']))
        {{-- ══════════════════════════════════════════════════ --}}
        {{-- ADMIN / REPRESENTATIVE FORM                        --}}
        {{-- ══════════════════════════════════════════════════ --}}
        <form id="admin-update-form" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            {{-- Personal Information --}}
            <div class="ep-section">
                <div class="ep-section-header">
                    <div class="ep-section-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <div class="ep-section-title">Personal Information</div>
                        <div class="ep-section-sub">Your basic account details.</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Full Name --}}
                    <div class="ep-field">
                        <label class="ep-label" for="name">Full Name</label>
                        <div class="ep-input-wrap">
                            <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                            <input id="name" name="name" type="text" class="ep-input" value="{{ old('name', $u->name) }}" required autofocus autocomplete="name">
                        </div>
                        <x-input-error class="mt-1" :messages="$errors->get('name')" />
                    </div>

                    {{-- Email --}}
                    <div class="ep-field">
                        <label class="ep-label" for="email">Email Address</label>
                        <div class="ep-input-wrap">
                            <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></span>
                            <input id="email" name="email" type="email" class="ep-input" value="{{ old('email', $u->email) }}" required autocomplete="username">
                        </div>
                        <x-input-error class="mt-1" :messages="$errors->get('email')" />
                    </div>

                    {{-- Phone --}}
                    <div class="ep-field">
                        <label class="ep-label" for="phone_num">Phone Number</label>
                        <div class="ep-input-wrap">
                            <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7a2 2 0 0 1 1.72 2.04z"/></svg></span>
                            <input id="phone_num" name="phone_num" type="text" class="ep-input" value="{{ old('phone_num', $u->phone_num) }}" autocomplete="tel">
                        </div>
                        <x-input-error class="mt-1" :messages="$errors->get('phone_num')" />
                    </div>

                    {{-- Password --}}
                    <div class="ep-field">
                        <label class="ep-label" for="password">New Password</label>
                        <div class="ep-input-wrap">
                            <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                            <input id="password" name="password" type="password" class="ep-input" placeholder="Leave blank to keep current" autocomplete="new-password">
                        </div>
                        <x-input-error class="mt-1" :messages="$errors->get('password')" />
                    </div>
                </div>
            </div>
        </form>{{-- /admin-update-form --}}

            {{-- Actions --}}
            <div class="ep-actions">
                <button type="button" onclick="openDeleteModal('{{ route('profile.destroy') }}', 'Delete Your Account?', 'This action is permanent and cannot be undone.<br>Please read carefully before proceeding.')" class="ep-btn-delete">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    Delete Account
                </button>
                <div class="flex items-center gap-4">
                    @if(session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-semibold">Saved!</p>
                    @endif
                    <button type="submit" form="admin-update-form" class="ep-btn-save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Save Changes
                    </button>
                </div>
            </div>

    @else
        {{-- ══════════════════════════════════════════════════ --}}
        {{-- STUDENT FORM                                        --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @include('profile.partials.update-profile-information-form')
    @endif

</div>

@include('profile.partials.delete-account-modal')
</x-app-layout>