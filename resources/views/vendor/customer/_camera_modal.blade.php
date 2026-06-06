{{--
    Reusable camera capture modal.
    Usage: @include('vendor.customer._camera_modal')
    Then call window.openCameraModal((dataUrl) => { ... }) from your page JS.

    Exposes:
      - window.openCameraModal(onSave)   // open modal; onSave called with PNG data URL when user confirms
      - window.closeCameraModal()
--}}

<style>
    .camera-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .65);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .camera-modal-overlay.active { display: flex; }

    .camera-modal {
        background: #fff;
        border-radius: 16px;
        max-width: 720px;
        width: 100%;
        max-height: 92vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
        animation: cameraModalIn .2s ease;
    }

    @keyframes cameraModalIn {
        from { transform: scale(.95); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }

    .camera-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid var(--brown-10, rgba(116, 70, 34, .1));
    }

    .camera-modal-header h2 {
        font-size: 16px;
        font-weight: 700;
        color: var(--brown, #744622);
    }

    .camera-modal-close {
        background: none;
        border: none;
        font-size: 26px;
        line-height: 1;
        color: var(--brown-60, rgba(116, 70, 34, .6));
        cursor: pointer;
        padding: 0 4px;
    }

    .camera-modal-close:hover { color: var(--brown, #744622); }

    .camera-modal-body {
        padding: 22px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    @media (max-width: 720px) {
        .camera-modal-body { grid-template-columns: 1fr; }
    }

    .camera-pane,
    .snapshot-pane {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .pane-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: var(--brown-60, rgba(116, 70, 34, .6));
    }

    #cameraVideo,
    #snapshotCanvas {
        width: 100%;
        aspect-ratio: 4 / 3;
        background: #000;
        border-radius: 10px;
        object-fit: cover;
    }

    #snapshotCanvas { background: var(--cream, #FBF5E8); }

    .camera-modal-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .camera-modal-row select {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid var(--brown-10, rgba(116, 70, 34, .1));
        border-radius: 8px;
        font-family: inherit;
        font-size: 13px;
        background: #fff;
    }

    .camera-btn {
        padding: 8px 16px;
        border-radius: 10px;
        border: 1px solid transparent;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background .2s, transform .15s;
    }

    .camera-btn:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .camera-btn-primary {
        background: var(--green, #42766A);
        color: #fff;
    }
    .camera-btn-primary:hover:not(:disabled) { background: #355f55; transform: translateY(-1px); }

    .camera-btn-outline {
        background: #fff;
        color: var(--brown, #744622);
        border-color: var(--brown-10, rgba(116, 70, 34, .1));
    }
    .camera-btn-outline:hover:not(:disabled) { background: var(--cream, #FBF5E8); }

    .camera-modal-footer {
        padding: 16px 22px;
        border-top: 1px solid var(--brown-10, rgba(116, 70, 34, .1));
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .camera-error {
        background: rgba(220, 38, 38, .1);
        color: #B91C1C;
        border: 1px solid rgba(220, 38, 38, .2);
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 13px;
        margin: 0 22px 16px;
        display: none;
    }

    .camera-error.active { display: block; }
</style>

<div id="cameraModalOverlay" class="camera-modal-overlay" aria-hidden="true">
    <div class="camera-modal" role="dialog" aria-modal="true" aria-labelledby="cameraModalTitle">
        <div class="camera-modal-header">
            <h2 id="cameraModalTitle">Modal Ambil Foto</h2>
            <button type="button" id="cameraModalCloseBtn" class="camera-modal-close" aria-label="Tutup">&times;</button>
        </div>

        <div id="cameraError" class="camera-error"></div>

        <div class="camera-modal-body">
            <div class="camera-pane">
                <div class="pane-label">Video</div>
                <video id="cameraVideo" autoplay playsinline muted></video>
                <div class="camera-modal-row">
                    <select id="cameraSelect" aria-label="Pilihan Kamera"></select>
                </div>
                <div class="camera-modal-row">
                    <button type="button" id="captureSnapshotBtn" class="camera-btn camera-btn-primary">Ambil Foto</button>
                </div>
            </div>
            <div class="snapshot-pane">
                <div class="pane-label">Snapshot</div>
                <canvas id="snapshotCanvas" width="640" height="480"></canvas>
            </div>
        </div>

        <div class="camera-modal-footer">
            <button type="button" id="cameraModalCancelBtn" class="camera-btn camera-btn-outline">Batal</button>
            <button type="button" id="cameraSaveBtn" class="camera-btn camera-btn-primary" disabled>Simpan Foto</button>
        </div>
    </div>
</div>

<script>
    (function() {
        const overlay = document.getElementById('cameraModalOverlay');
        const closeBtn = document.getElementById('cameraModalCloseBtn');
        const cancelBtn = document.getElementById('cameraModalCancelBtn');
        const video = document.getElementById('cameraVideo');
        const canvas = document.getElementById('snapshotCanvas');
        const cameraSelect = document.getElementById('cameraSelect');
        const captureBtn = document.getElementById('captureSnapshotBtn');
        const saveBtn = document.getElementById('cameraSaveBtn');
        const errorBox = document.getElementById('cameraError');

        let activeStream = null;
        let currentDataUrl = null;
        let onSaveCallback = null;

        function showError(msg) {
            errorBox.textContent = msg;
            errorBox.classList.add('active');
        }

        function clearError() {
            errorBox.textContent = '';
            errorBox.classList.remove('active');
        }

        async function startStream(deviceId) {
            stopStream();
            const constraints = {
                video: deviceId ? { deviceId: { exact: deviceId } } : { facingMode: 'user' },
                audio: false,
            };
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                activeStream = stream;
                video.srcObject = stream;
                clearError();
            } catch (err) {
                showError('Tidak dapat mengakses kamera: ' + (err.message || err.name));
            }
        }

        function stopStream() {
            if (activeStream) {
                activeStream.getTracks().forEach((t) => t.stop());
                activeStream = null;
            }
            video.srcObject = null;
        }

        async function populateCameras() {
            // enumerateDevices may return empty labels until camera permission is granted at least once.
            // We call getUserMedia first (in startStream) before populating, so labels are usable.
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                const cams = devices.filter((d) => d.kind === 'videoinput');
                cameraSelect.innerHTML = '';
                cams.forEach((cam, idx) => {
                    const opt = document.createElement('option');
                    opt.value = cam.deviceId;
                    opt.textContent = cam.label || ('Kamera ' + (idx + 1));
                    cameraSelect.appendChild(opt);
                });
                if (cams.length <= 1) {
                    cameraSelect.disabled = true;
                } else {
                    cameraSelect.disabled = false;
                }
            } catch (err) {
                showError('Gagal memuat daftar kamera: ' + err.message);
            }
        }

        function snapshot() {
            if (!video.videoWidth || !video.videoHeight) {
                showError('Video belum siap. Tunggu sebentar lalu coba lagi.');
                return;
            }
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            currentDataUrl = canvas.toDataURL('image/png');
            saveBtn.disabled = false;
            clearError();
        }

        function open(onSave) {
            onSaveCallback = onSave;
            currentDataUrl = null;
            saveBtn.disabled = true;
            overlay.classList.add('active');
            overlay.setAttribute('aria-hidden', 'false');
            (async () => {
                await startStream();
                await populateCameras();
                // Sync the select to the active deviceId
                const tracks = activeStream ? activeStream.getVideoTracks() : [];
                if (tracks.length) {
                    const settings = tracks[0].getSettings();
                    if (settings.deviceId) cameraSelect.value = settings.deviceId;
                }
            })();
        }

        function close() {
            stopStream();
            overlay.classList.remove('active');
            overlay.setAttribute('aria-hidden', 'true');
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            onSaveCallback = null;
            currentDataUrl = null;
            clearError();
        }

        function save() {
            if (!currentDataUrl) {
                showError('Belum ada snapshot. Klik "Ambil Foto" dulu.');
                return;
            }
            if (typeof onSaveCallback === 'function') {
                onSaveCallback(currentDataUrl);
            }
            close();
        }

        closeBtn.addEventListener('click', close);
        cancelBtn.addEventListener('click', close);
        overlay.addEventListener('click', (e) => { if (e.target === overlay) close(); });
        captureBtn.addEventListener('click', snapshot);
        saveBtn.addEventListener('click', save);
        cameraSelect.addEventListener('change', (e) => startStream(e.target.value));

        window.openCameraModal = open;
        window.closeCameraModal = close;
    })();
</script>
