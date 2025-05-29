@extends('layout.front.app')
@section('title','Contact')
@section('content')
     <div class="row">
        <div class="col-8">
           @if (session('success'))
    <div class="alert alert-success" id="successAlert">
        {{ session('success') }}
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

        </div>
    </div>
<!-- Map Begin -->
<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3663.0507552280847!2d74.57294347502852!3d18.14521868287706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc3a03957da0e85%3A0xd9f9bb98706717e0!2sBaramati%20Bus%20Stand!5e1!3m2!1sen!2sin!4v1742909184819!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
<!-- Map End -->

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__text">
                    <div class="section-title">
                        <span>Information</span>
                        <h2>Contact Us</h2>
                        <p>As you might expect of a company that began as a high-end interiors contractor, we pay
                            strict attention.</p>
                    </div>
                    <ul>
                        <li>
                            <h4>India</h4>
                            <p>indapur road baramati pune  <br />Maharastra</p>
                        </li>
                
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__form">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" placeholder="name" name="name">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="email" name="email">
                            </div>
                            <div class="col-lg-12">
                                <textarea placeholder="message" name="message"></textarea>
                                <button type="submit" class="site-btn">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->
@endsection