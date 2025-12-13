@extends('layout.back.master')

@section('title', 'Send Push Notification')

@section('content')
<style>
    /* Mobile Preview Mockup */
    .mobile-mockup {
        width: 100%;
        max-width: 320px;
        margin: 0 auto;
        background: #fff;
        border: 10px solid #2b2b2b;
        border-radius: 30px;
        overflow: hidden;
        position: relative;
        height: 600px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        background-image: url('https://images.unsplash.com/photo-1554034483-04fda0d3507b?q=80&w=1000&auto=format&fit=crop'); /* Wallpaper */
        background-size: cover;
        background-position: center;
    }
    
    .mobile-notch {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 25px;
        background: #2b2b2b;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
        z-index: 2;
    }

    .mobile-status-bar {
        padding: 8px 15px;
        display: flex;
        justify-content: space-between;
        color: white;
        font-size: 10px;
        font-weight: 600;
        margin-top: 5px;
    }

    /* Notification Card on Lock Screen */
    .notification-bubble {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        margin: 20px 15px;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        animation: slideDown 0.5s ease-out;
    }

    .notif-header {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .app-icon {
        width: 20px;
        height: 20px;
        background: #696cff; /* Vuexy Primary */
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
    }
    
    .app-name { font-size: 11px; font-weight: 600; color: #566a7f; flex-grow: 1; }
    .time-now { font-size: 10px; color: #a1acb8; }

    .notif-content h6 { font-size: 13px; font-weight: 700; margin-bottom: 4px; color: #333; }
    .notif-content p { font-size: 12px; margin-bottom: 0; color: #555; line-height: 1.4; }
    
    .notif-img-preview {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
        display: none; /* Hidden by default */
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Notifications /</span> Create New
    </h4>

    <div class="row">
        <div class="col-12 col-lg-8">
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.notifications.send') }}" id="notificationForm" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Notification Content</h5>
                        <small class="text-muted float-end">Step 1 of 2</small>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label">Notification Title <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-captions"></i></span>
                                <input type="text" name="title" id="inputTitle" class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="e.g., Flash Sale Alert!" value="{{ old('title') }}" required>
                            </div>
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message Body <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-message-detail"></i></span>
                                <textarea name="message" id="inputMessage" class="form-control @error('message') is-invalid @enderror" 
                                          rows="3" placeholder="Write your compelling message here..." required>{{ old('message') }}</textarea>
                            </div>
                            <div class="form-text text-end" id="charCount">0/250 characters</div>
                            @error('message') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Attachment Image (Optional)</label>
                            <input type="file" name="image" id="inputImage" class="form-control" accept="image/*">
                            <div class="form-text">Supports JPG, PNG. Max size 2MB.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deep Link / Action URL</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-link"></i></span>
                                <input type="url" name="action_url" class="form-control" 
                                       placeholder="https://yourapp.com/products/123" value="{{ old('action_url') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Targeting & Delivery</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <label class="form-label">Audience</label>
                                <select name="recipient_type" id="recipientType" class="form-select @error('recipient_type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select Audience</option>
                                    <option value="all" {{ old('recipient_type') == 'all' ? 'selected' : '' }}>📢 All Users</option>
                                    <option value="specific" {{ old('recipient_type') == 'specific' ? 'selected' : '' }}>👤 Specific User</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal (Standard)</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High (Immediate)</option>
                                </select>
                            </div>

                            <div class="col-12" id="userSelectionDiv" style="display: none;">
                                <label class="form-label">Select User</label>
                                <select name="user_id" id="userId" class="form-select">
                                    <option value="">Search user by name or email...</option>
                                    @if(isset($users))
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="form-text">Only the selected user will receive this notification.</div>
                            </div>

                            <div class="col-12">
                                <hr class="my-2">
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="scheduleToggle" name="schedule_enabled">
                                    <label class="form-check-label" for="scheduleToggle">Schedule for later delivery</label>
                                </div>
                            </div>

                            <div class="col-12" id="scheduleDiv" style="display: none;">
                                <label class="form-label">Delivery Date & Time</label>
                                <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at') }}">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.notifications') }}" class="btn btn-label-secondary">Discard</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-paper-plane me-1"></i> Send Notification
                    </button>
                </div>
            </form>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card bg-transparent shadow-none border-0 sticky-top" style="top: 20px;">
                <h6 class="text-muted text-center mb-3">Live Preview (Lock Screen)</h6>
                
                <div class="mobile-mockup">
                    <div class="mobile-notch"></div>
                    
                    <div class="mobile-status-bar">
                        <span id="clockTime">12:00</span>
                        <span>
                            <i class="bx bx-wifi"></i>
                            <i class="bx bxs-battery-full"></i>
                        </span>
                    </div>

                    <div class="notification-bubble">
                        <div class="notif-header">
                            <div class="app-icon">
                                <i class="bx bxs-bell text-white" style="font-size: 12px;"></i>
                            </div>
                            <span class="app-name">YOUR APP</span>
                            <span class="time-now">Now</span>
                        </div>
                        <div class="notif-content">
                            <h6 id="previewTitle">Notification Title</h6>
                            <p id="previewMessage">Your message will appear here shortly...</p>
                            <img id="previewImage" src="" class="notif-img-preview" alt="Preview">
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-muted">This is an approximation of how it will appear on iOS/Android.</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // === Elements ===
    const recipientType = document.getElementById('recipientType');
    const userSelectionDiv = document.getElementById('userSelectionDiv');
    const userId = document.getElementById('userId');
    const scheduleToggle = document.getElementById('scheduleToggle');
    const scheduleDiv = document.getElementById('scheduleDiv');
    
    // Inputs
    const titleInput = document.getElementById('inputTitle');
    const messageInput = document.getElementById('inputMessage');
    const imageInput = document.getElementById('inputImage');
    
    // Preview Elements
    const previewTitle = document.getElementById('previewTitle');
    const previewMessage = document.getElementById('previewMessage');
    const previewImage = document.getElementById('previewImage');
    const charCount = document.getElementById('charCount');
    const clockTime = document.getElementById('clockTime');

    // === Logic ===

    // 1. Recipient Type Toggle
    recipientType.addEventListener('change', function() {
        if (this.value === 'specific') {
            userSelectionDiv.style.display = 'block';
            userId.required = true;
            // Add animation class if using animate.css
            userSelectionDiv.classList.add('animate__animated', 'animate__fadeIn');
        } else {
            userSelectionDiv.style.display = 'none';
            userId.required = false;
            userId.value = '';
        }
    });

    // 2. Schedule Toggle
    scheduleToggle.addEventListener('change', function() {
        if(this.checked) {
            scheduleDiv.style.display = 'block';
            scheduleDiv.classList.add('animate__animated', 'animate__fadeIn');
        } else {
            scheduleDiv.style.display = 'none';
        }
    });

    // 3. Live Text Preview
    titleInput.addEventListener('input', function() {
        previewTitle.textContent = this.value || 'Notification Title';
    });

    messageInput.addEventListener('input', function() {
        const val = this.value;
        previewMessage.textContent = val || 'Your message will appear here shortly...';
        charCount.textContent = `${val.length}/250 characters`;
        
        if(val.length > 250) {
            charCount.classList.add('text-danger');
        } else {
            charCount.classList.remove('text-danger');
        }
    });

    // 4. Image Preview
    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
            previewImage.src = '';
        }
    });

    // 5. Update Clock in Status Bar
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        clockTime.textContent = `${hours}:${minutes}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // === Init State on Load (for Validation Errors) ===
    if (recipientType.value === 'specific') {
        userSelectionDiv.style.display = 'block';
    }
    if (scheduleToggle.checked) {
        scheduleDiv.style.display = 'block';
    }
});
</script>
@endpush