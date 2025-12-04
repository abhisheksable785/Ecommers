@extends('layout.back.master')

@section('title', 'Send Push Notification')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Notifications /</span> Send Push Notification
    </h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Send Push Notification</h5>
            <i class="bx bx-bell bx-md"></i>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.notifications.send') }}" id="notificationForm">
                @csrf

                <!-- Notification Title -->
                <div class="mb-3">
                    <label class="form-label">Notification Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           placeholder="Enter notification title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Notification Message -->
                <div class="mb-3">
                    <label class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                              rows="4" placeholder="Type your notification message here..." required>{{ old('message') }}</textarea>
                    <small class="text-muted">Maximum 250 characters recommended</small>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Recipient Type -->
                <div class="mb-3">
                    <label class="form-label">Send To <span class="text-danger">*</span></label>
                    <select name="recipient_type" id="recipientType" class="form-select @error('recipient_type') is-invalid @enderror" required>
                        <option value="">Select Recipient Type</option>
                        <option value="all" {{ old('recipient_type') == 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="specific" {{ old('recipient_type') == 'specific' ? 'selected' : '' }}>Specific User</option>
                    </select>
                    @error('recipient_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Specific User Selection (Hidden by default) -->
                <div class="mb-3" id="userSelectionDiv" style="display: none;">
                    <label class="form-label">Select User <span class="text-danger">*</span></label>
                    <select name="user_id" id="userId" class="form-select @error('user_id') is-invalid @enderror">
                        <option value="">Choose a user</option>
                        @if(isset($users))
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Priority (Optional) -->
                <div class="mb-3">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>

                <!-- Action URL (Optional) -->
                <div class="mb-3">
                    <label class="form-label">Action URL (Optional)</label>
                    <input type="url" name="action_url" class="form-control @error('action_url') is-invalid @enderror" 
                           placeholder="https://example.com/action" value="{{ old('action_url') }}">
                    <small class="text-muted">URL to open when notification is clicked</small>
                    @error('action_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Schedule (Optional) -->
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="scheduleToggle" name="schedule_enabled">
                        <label class="form-check-label" for="scheduleToggle">
                            Schedule for later
                        </label>
                    </div>
                </div>

                <div class="mb-3" id="scheduleDiv" style="display: none;">
                    <label class="form-label">Schedule Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at') }}">
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-send me-1"></i> Send Notification
                    </button>
                    <a href="{{ route('admin.notifications') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-x me-1"></i> Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

    <!-- Preview Card -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Notification Preview</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bx bx-bell bx-sm me-2 mt-1"></i>
                    <div>
                        <h6 class="alert-heading mb-1" id="previewTitle">Your Notification Title</h6>
                        <p class="mb-0" id="previewMessage">Your notification message will appear here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const recipientType = document.getElementById('recipientType');
    const userSelectionDiv = document.getElementById('userSelectionDiv');
    const userId = document.getElementById('userId');
    const scheduleToggle = document.getElementById('scheduleToggle');
    const scheduleDiv = document.getElementById('scheduleDiv');
    const titleInput = document.querySelector('input[name="title"]');
    const messageInput = document.querySelector('textarea[name="message"]');
    const previewTitle = document.getElementById('previewTitle');
    const previewMessage = document.getElementById('previewMessage');

    // Toggle user selection based on recipient type
    recipientType.addEventListener('change', function() {
        if (this.value === 'specific') {
            userSelectionDiv.style.display = 'block';
            userId.required = true;
        } else {
            userSelectionDiv.style.display = 'none';
            userId.required = false;
            userId.value = '';
        }
    });

    // Toggle schedule datetime
    scheduleToggle.addEventListener('change', function() {
        scheduleDiv.style.display = this.checked ? 'block' : 'none';
    });

    // Live preview
    titleInput.addEventListener('input', function() {
        previewTitle.textContent = this.value || 'Your Notification Title';
    });

    messageInput.addEventListener('input', function() {
        previewMessage.textContent = this.value || 'Your notification message will appear here...';
    });

    // Restore state if form has errors
    if (recipientType.value === 'specific') {
        userSelectionDiv.style.display = 'block';
        userId.required = true;
    }

    if (scheduleToggle.checked) {
        scheduleDiv.style.display = 'block';
    }
});
</script>
@endpush