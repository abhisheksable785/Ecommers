@extends('layout.front.app')
@section('title','Profile') 
@section('content')

<style>
    .profile-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 0 15px;
    }
    
    .profile-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .profile-header {
        background-color: #091522;
        
        padding: 1rem;
        text-align: center;
    }
    
    .profile-body {
        padding: 1.5rem;
        background-color: #fff;
    }
    
    .form-label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 0.4rem;
        font-size: 0.9rem;
    }
    
    .form-control {
        border-radius: 4px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        font-size: 0.9rem;
        height: auto;
    }
    
    .btn-save {
        background-color: #27ae60;
        border: none;
        padding: 8px 25px;
        font-size: 0.9rem;
    }
    
    .input-group-append .btn {
        padding: 8px 12px;
        font-size: 0.8rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 576px) {
        .profile-container {
            margin: 1rem auto;
        }
        
        .profile-body {
            padding: 1.25rem;
        }
    }
</style>

<div class="profile-container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" id="successAlert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
          <script>
        // Hide success message after 3 seconds
        setTimeout(function() {
            var alertBox = document.getElementById('successAlert');
            if (alertBox) {
                alertBox.style.display = 'none';
            }
        }, 3000); // 3000ms = 3 seconds
    </script>
    @endif

    <div class="profile-card">
        <div class="profile-header text-white">
            <h4 class="mb-0" style="font-size: 1.25rem;">Profile Details</h4>
        </div>
        <div>
             {{-- @if ($errors->any())
        <ul>

            @foreach ($errors->all() as $error)
                <li style="color: red">{{ $error }}</li>
            @endforeach
        </ul>

    @endif --}}
        </div>

        <div class="profile-body">
        <form action="{{ $profile ? route('profile.update', $profile->id) : route('profile.store') }}" method="POST">
                @csrf
                @if($profile)
                    @method('PUT')
                @endif
               
                <div class="form-group">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name"   value="{{ old('full_name', $profile->full_name ?? '') }}"
                           required>
                           <span> @error('full_name')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </span>
                </div>
                
                <div class="form-group">
                    <label for="mobile_number" class="form-label">Mobile Number</label>
                    <div class="input-group">
                        <input type="tel" class="form-control" id="mobile_number" name="mobile_number"  value="{{ old('mobile_number', $profile->mobile_number ?? '') }}"
                               pattern="[0-9]{10}" maxlength="10" 
                               placeholder="10-digit number" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="changeMobileBtn">CHANGE</button>
                        </div>
                    </div>
                    <span> @error('mobile_number')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </span>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email',$profile->email ?? '') }}"
                            required>
                            <span> @error('email')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </span>
                </div>

                <div class="form-group">
                    <label for="birthday" class="form-label">Date of Birth</label>
                    <input type="text" class="form-control datepicker" id="birthday" name="birthday"  value="{{ old('birthday', $profile->birthday ?? '') }}"
                           placeholder="yyyy/mm/dd" autocomplete="off">
                           <span> @error('birthday')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </span>
                </div>

             <div class="form-group">
    <label for="address" class="form-label">Delivery Address</label>
    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $profile->address ?? '') }}">
    <span>
        @error('address')
            <div style="color: red">{{ $message }}</div>
        @enderror
    </span>
</div>

                
               <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city',$profile->city ?? '') }}"
                               required>
                               <span> @error('city')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control" id="pincode" name="pincode"  value="{{ old('pincode',$profile->pincode ?? '') }}"
                               pattern="[0-9]{6}" maxlength="6">
                               <span> @error('pincode')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark">
    {{ $profile ? 'Edit Details' : 'Save Details' }}
</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize datepicker
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        });

        // Mobile number input validation
        $('#mobile_number').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        // Pincode input validation
        $('#pincode').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
        });

        // Mobile number change functionality
        $('#changeMobileBtn').click(function() {
            const mobileInput = $('#mobile_number');
            const btn = $(this);
            
            if (mobileInput.prop('readonly')) {
                mobileInput.prop('readonly', false).focus();
                btn.text('CANCEL').removeClass('btn-outline-secondary').addClass('btn-outline-danger');
            } else {
                mobileInput.prop('readonly', true);
                btn.text('CHANGE').removeClass('btn-outline-danger').addClass('btn-outline-secondary');
            }
        });

        // Form submission handling
        $('#profileForm').submit(function(e) {
            e.preventDefault();
            
            // Validate mobile number
            const mobileNumber = $('#mobile_number').val();
            if (mobileNumber.length !== 10) {
                alert('Please enter a valid 10-digit mobile number');
                return;
            }
            
            // Here you would typically make an AJAX call to update the profile
            $('#successAlert').removeClass('d-none');
            
            // Simulate form submission
            setTimeout(() => {
                $('#successAlert').alert('close');
            }, 3000);
        });
    });
</script>
@endsection