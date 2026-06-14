{{-- ══════════════════════════════════════════════════════════
     Delete Account Modal  –  shared across show & edit pages
     The actual DELETE form lives here; buttons elsewhere just
     call openDeleteModal() / closeDeleteModal().
════════════════════════════════════════════════════════════ --}}

{{-- Hidden DELETE form (backend untouched) --}}
<form id="delete-modal-form" action="" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

{{-- Backdrop + Modal --}}
<div id="delete-modal-backdrop"
     aria-modal="true" role="dialog" aria-labelledby="delete-modal-title"
     style="display:none; position:fixed; inset:0; z-index:9999;
            background:rgba(15,23,42,0.55); backdrop-filter:blur(6px);
            -webkit-backdrop-filter:blur(6px);
            display:none; align-items:center; justify-content:center; padding:1rem;">

    <div id="delete-modal-card"
         style="background:#fff; border-radius:1.5rem;
                box-shadow:0 24px 80px rgba(0,0,0,0.18), 0 4px 20px rgba(220,38,38,0.08);
                max-width:440px; width:100%; position:relative; overflow:hidden;
                transform:scale(0.92); opacity:0; transition:transform 0.28s cubic-bezier(0.34,1.56,0.64,1), opacity 0.22s ease;">

        {{-- Decorative top strip --}}
        <div style="height:5px; background:linear-gradient(to right,#EF4444,#F97316,#EF4444); width:100%;"></div>

        {{-- Close button --}}
        <button onclick="closeDeleteModal()" aria-label="Close"
                style="position:absolute; top:1.1rem; right:1.1rem;
                       width:2rem; height:2rem; border-radius:9999px;
                       background:#F3F4F6; border:none; cursor:pointer;
                       display:flex; align-items:center; justify-content:center;
                       color:#6B7280; transition:background 0.15s, color 0.15s;"
                onmouseover="this.style.background='#FEE2E2';this.style.color='#DC2626'"
                onmouseout="this.style.background='#F3F4F6';this.style.color='#6B7280'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>

        {{-- Body --}}
        <div style="padding:2rem 2rem 2.25rem;">

            {{-- Icon illustration --}}
            <div style="display:flex; justify-content:center; margin-bottom:1.5rem;">
                <div style="position:relative; width:5.5rem; height:5.5rem;">
                    {{-- Outer glow ring --}}
                    <div style="position:absolute; inset:-6px; border-radius:9999px;
                                background:radial-gradient(circle,rgba(239,68,68,0.15) 0%,transparent 70%);"></div>
                    {{-- Circle background --}}
                    <div style="width:5.5rem; height:5.5rem; border-radius:9999px;
                                background:linear-gradient(135deg,#FEE2E2 0%,#FECACA 100%);
                                display:flex; align-items:center; justify-content:center;
                                border:2px solid rgba(239,68,68,0.2);
                                box-shadow:0 8px 24px rgba(239,68,68,0.18);">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                            <line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
                        </svg>
                    </div>
                    {{-- Warning badge --}}
                    <div style="position:absolute; bottom:-4px; right:-4px;
                                width:1.6rem; height:1.6rem; border-radius:9999px;
                                background:#F97316; border:2px solid #fff;
                                display:flex; align-items:center; justify-content:center;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="0">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
                            <line x1="12" y1="17" x2="12.01" y2="17" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Title --}}
            <h2 id="delete-modal-title"
                style="text-align:center; font-size:1.2rem; font-weight:900;
                       color:#0B1221; letter-spacing:-0.02em; margin:0 0 0.5rem;">
                Delete?
            </h2>
            <p id="delete-modal-desc" style="text-align:center; font-size:0.82rem; color:#6B7280;
                      font-weight:500; margin:0 0 1.25rem; line-height:1.55;">
                This action is <strong style="color:#374151;">permanent</strong> and cannot be undone.<br>
                Please read carefully before proceeding.
            </p>



            {{-- Buttons --}}
            <div style="display:flex; flex-direction:column; gap:0.6rem;">
                <button onclick="document.getElementById('delete-modal-form').submit()"
                        style="width:100%; display:inline-flex; align-items:center; justify-content:center; gap:0.5rem;
                               padding:0.75rem 1.5rem; border-radius:0.75rem; border:none; cursor:pointer;
                               background:linear-gradient(135deg,#DC2626 0%,#EF4444 100%);
                               color:#fff; font-size:0.85rem; font-weight:800; letter-spacing:0.01em;
                               box-shadow:0 4px 16px rgba(220,38,38,0.32);
                               transition:filter 0.18s, transform 0.15s, box-shadow 0.18s;"
                        onmouseover="this.style.filter='brightness(1.08)';this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 24px rgba(220,38,38,0.42)'"
                        onmouseout="this.style.filter='';this.style.transform='';this.style.boxShadow='0 4px 16px rgba(220,38,38,0.32)'">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    Yes, Delete
                </button>

                <button onclick="closeDeleteModal()"
                        style="width:100%; display:inline-flex; align-items:center; justify-content:center; gap:0.5rem;
                               padding:0.72rem 1.5rem; border-radius:0.75rem; cursor:pointer;
                               background:transparent; border:1.5px solid #E5E7EB;
                               color:#374151; font-size:0.85rem; font-weight:700;
                               transition:background 0.18s, border-color 0.18s, transform 0.15s;"
                        onmouseover="this.style.background='#F9FAFB';this.style.borderColor='#D1D5DB';this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.background='transparent';this.style.borderColor='#E5E7EB';this.style.transform=''">
                    Cancel
                </button>
            </div>

        </div>{{-- /body --}}
    </div>{{-- /card --}}
</div>{{-- /backdrop --}}

<script>
function openDeleteModal(actionUrl, titleText, descText) {
    const backdrop = document.getElementById('delete-modal-backdrop');
    const card     = document.getElementById('delete-modal-card');
    const form     = document.getElementById('delete-modal-form');
    
    // Update dynamic content
    form.action = actionUrl;
    if (titleText) document.getElementById('delete-modal-title').innerText = titleText;
    if (descText) document.getElementById('delete-modal-desc').innerHTML = descText;

    backdrop.style.display = 'flex';
    // Trigger animation on next frame
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            card.style.transform = 'scale(1)';
            card.style.opacity   = '1';
        });
    });
    document.addEventListener('keydown', _deleteModalEsc);
}

function closeDeleteModal() {
    const backdrop = document.getElementById('delete-modal-backdrop');
    const card     = document.getElementById('delete-modal-card');
    card.style.transform = 'scale(0.92)';
    card.style.opacity   = '0';
    setTimeout(() => { backdrop.style.display = 'none'; }, 230);
    document.removeEventListener('keydown', _deleteModalEsc);
}

function _deleteModalEsc(e) {
    if (e.key === 'Escape') closeDeleteModal();
}

// Close when clicking the backdrop itself
document.getElementById('delete-modal-backdrop').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
