<x-app-layout headerTitle="{{ explode(' ', trim($user->name))[0] }}'s Profile">
<style>
    /* ── Hero Banner ─────────────────────────────────────────── */
    .profile-hero {
        position: relative;
        width: 100%;
        border-radius: 1.5rem;
        overflow: hidden;
        padding: 2rem 2.5rem;
        margin-bottom: 1.75rem;
        background: url('{{ asset('images/hero_banner.png') }}') center/cover no-repeat,
                    linear-gradient(135deg, #C8D5F8 0%, #BDD0FF 100%);
        min-height: 160px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 24px 0 rgba(44,59,235,0.10);
    }
    .profile-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(200,213,248,0.97) 0%, rgba(200,213,248,0.72) 55%, transparent 100%);
        pointer-events: none;
    }
    .profile-hero-content {
        position: relative;
        z-index: 10;
    }
    .profile-hero h1 {
        font-size: 2rem;
        font-weight: 900;
        color: #0B1221;
        letter-spacing: -0.02em;
        line-height: 1.15;
        margin-bottom: 0.35rem;
    }
    .profile-hero p {
        font-size: 0.8rem;
        color: #4B5563;
        font-weight: 500;
        max-width: 28rem;
    }
    .profile-hero-accent {
        display: block;
        width: 3rem;
        height: 3px;
        border-radius: 9999px;
        background: linear-gradient(to right, #2C3BEB, #818CF8);
        margin-top: 0.65rem;
    }

    /* ── Main Card ───────────────────────────────────────────── */
    .profile-card {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-radius: 1.5rem;
        border: 1px solid rgba(200,213,248,0.55);
        box-shadow: 0 8px 40px 0 rgba(44,59,235,0.08), 0 1.5px 6px 0 rgba(44,59,235,0.04);
        padding: 2rem 2rem 1.75rem;
        overflow: hidden;
    }

    /* ── Avatar & Badge Strip ────────────────────────────────── */
    .profile-identity {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid rgba(200,213,248,0.45);
    }
    .profile-avatar {
        width: 3.75rem;
        height: 3.75rem;
        border-radius: 9999px;
        background: linear-gradient(135deg, #2C3BEB 0%, #818CF8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.04em;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(44,59,235,0.28);
    }
    .profile-name-group {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .profile-name-group strong {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0B1221;
        letter-spacing: -0.01em;
        line-height: 1.2;
    }
    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        color: #2C3BEB;
        background: rgba(44,59,235,0.08);
        border: 1px solid rgba(44,59,235,0.18);
        border-radius: 9999px;
        padding: 0.18rem 0.65rem;
        width: fit-content;
    }

    /* ── Info Grid ───────────────────────────────────────────── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
    }
    @media (max-width: 640px) {
        .info-grid { grid-template-columns: 1fr; }
    }
    .info-card {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        background: rgba(248,250,255,0.85);
        border: 1px solid rgba(200,213,248,0.45);
        border-radius: 0.875rem;
        padding: 0.85rem 1rem;
        transition: box-shadow 0.18s, border-color 0.18s, transform 0.18s;
    }
    .info-card:hover {
        box-shadow: 0 4px 18px rgba(44,59,235,0.08);
        border-color: rgba(44,59,235,0.22);
        transform: translateY(-1px);
    }
    .info-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        background: rgba(44,59,235,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 0.05rem;
    }
    .info-icon svg {
        color: #2C3BEB;
    }
    .info-text {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        min-width: 0;
    }
    .info-label {
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #9CA3AF;
        text-transform: uppercase;
        line-height: 1;
    }
    .info-value {
        font-size: 0.82rem;
        font-weight: 600;
        color: #111827;
        line-height: 1.35;
        word-break: break-word;
    }

    /* ── Action Buttons ──────────────────────────────────────── */
    .profile-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.75rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(200,213,248,0.45);
        gap: 1rem;
    }
    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.82rem;
        font-weight: 700;
        color: #DC2626;
        background: transparent;
        border: 1.5px solid #FCA5A5;
        border-radius: 0.625rem;
        padding: 0.6rem 1.25rem;
        cursor: pointer;
        transition: background 0.18s, border-color 0.18s, color 0.18s, transform 0.15s, box-shadow 0.18s;
    }
    .btn-delete:hover {
        background: #FEF2F2;
        border-color: #EF4444;
        box-shadow: 0 4px 14px rgba(220,38,38,0.12);
        transform: translateY(-1px);
    }
    .btn-update {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.82rem;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #2C3BEB 0%, #4F5FF5 100%);
        border: none;
        border-radius: 0.625rem;
        padding: 0.65rem 1.5rem;
        cursor: pointer;
        text-decoration: none;
        transition: filter 0.18s, transform 0.15s, box-shadow 0.18s;
        box-shadow: 0 4px 14px rgba(44,59,235,0.28);
    }
    .btn-update:hover {
        filter: brightness(1.10);
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(44,59,235,0.36);
    }
</style>

<div class="max-w-4xl mx-auto">

    {{-- ── Hero Banner ──────────────────────────────────────── --}}
    <div class="profile-hero">
        <div class="profile-hero-content">
            <h1>{{ explode(' ', trim($user->name))[0] }}'s Profile</h1>
            <p>View your account details and personal information.</p>
            <span class="profile-hero-accent"></span>
        </div>
    </div>

    {{-- ── Profile Card ─────────────────────────────────────── --}}
    <div class="profile-card">

        {{-- Avatar + Name + Badge --}}
        <div class="profile-identity">
            @php
                $words    = preg_split('/\s+/', trim($user->name));
                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

                $roleLabel = match($user->role ?? 'student') {
                    'admin'          => 'Super Admin Account',
                    'representative' => 'Representative Account',
                    default          => 'Student Account',
                };
            @endphp
            <div class="profile-avatar" aria-hidden="true">{{ $initials }}</div>
            <div class="profile-name-group">
                <strong>{{ $user->name }}</strong>
                <span class="profile-badge">
                    {{-- graduation cap icon --}}
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3.5 2 8.5 2 12 0v-5"/></svg>
                    {{ $roleLabel }}
                </span>
            </div>
        </div>

        {{-- Info Grid --}}
        <div class="info-grid">

            {{-- Full Name --}}
            <div class="info-card">
                <div class="info-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="info-text">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
            </div>

            {{-- Email --}}
            <div class="info-card">
                <div class="info-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <div class="info-text">
                    <span class="info-label">Email Address</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
            </div>

            {{-- Phone --}}
            <div class="info-card">
                <div class="info-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7a2 2 0 0 1 1.72 2.04z"/></svg>
                </div>
                <div class="info-text">
                    <span class="info-label">Phone Number</span>
                    <span class="info-value">{{ $user->phone_num ?? 'Not provided' }}</span>
                </div>
            </div>

            {{-- Password --}}
            <div class="info-card">
                <div class="info-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div class="info-text">
                    <span class="info-label">Password</span>
                    <span class="info-value">••••••••</span>
                </div>
            </div>

            @if($user->role === 'student')
                {{-- Gender --}}
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                    </div>
                    <div class="info-text">
                        <span class="info-label">Gender</span>
                        <span class="info-value capitalize">{{ $user->gender ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Marital Status --}}
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </div>
                    <div class="info-text">
                        <span class="info-label">Marital Status</span>
                        <span class="info-value capitalize">{{ $user->marital_status ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Nationality --}}
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <div class="info-text">
                        <span class="info-label">Nationality</span>
                        <span class="info-value">{{ $user->nationality ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Birth State --}}
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
                    </div>
                    <div class="info-text">
                        <span class="info-label">Birth State</span>
                        <span class="info-value">{{ $user->birth_state ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Date of Birth --}}
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div class="info-text">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">{{ $user->dob ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Study Location --}}
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div class="info-text">
                        <span class="info-label">Study Location</span>
                        <span class="info-value">{{ $user->study_location ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Place of Study --}}
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/><path d="M9 9v.01"/><path d="M9 12v.01"/><path d="M9 15v.01"/><path d="M9 18v.01"/></svg>
                    </div>
                    <div class="info-text">
                        <span class="info-label">Place of Study</span>
                        <span class="info-value">{{ $user->place_of_study ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Residential Address --}}
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <div class="info-text">
                        <span class="info-label">Residential Address</span>
                        <span class="info-value">{{ $user->address ?? 'Not provided' }}</span>
                    </div>
                </div>
            @endif

        </div>

        {{-- Action Buttons --}}
        <div class="profile-actions">
            <button type="button" onclick="openDeleteModal('{{ route('profile.destroy') }}', 'Delete Your Account?', 'This action is permanent and cannot be undone.<br>Please read carefully before proceeding.')" class="btn-delete">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                Delete Account
            </button>

            <a href="{{ route('profile.edit') }}" class="btn-update">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Update Profile
            </a>
        </div>

    </div>{{-- /profile-card --}}

</div>{{-- /max-w-4xl --}}

@include('profile.partials.delete-account-modal')
</x-app-layout>